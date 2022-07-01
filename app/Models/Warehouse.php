<?php

namespace App\Models;
use App\Models\Customer;
use Illuminate\Database\Eloquent\SoftDeletes; 
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use SoftDeletes;
    protected $table = 'warehouses';
    //
    function inventory(){
        return $this->hasMany('App\Models\WarehouseInventory','warehouse_id','id');
    }

    function warehousePrfs(){
        
        return $this->hasMany('App\Models\Prf','warehouse_id','id');
    } 
    
    public function productInventory($product_id){
        $product_inventory = $this->inventory->where('product_id',$product_id)->first();
        //die($product_inventory );
        if($product_inventory){
            return $product_inventory->quantity;
        }
        else{
            return 0;
        }
    }

    public function directSalesCustomers(){
        return Customers::where('customer_type','1')->get();

    }
    public function directSalesCustomersArray(){
        return Customer::where('customer_type','1')->pluck('id')->toArray();
        
    }
    function directSalesPrfs($start_time= null, $end_time = null){
        if($start_time==null && $end_time == null){
            $start_time= now()->startOfMonth() ;
            $end_time = now()->endOfMonth() ;
        }
        elseif($start_time==null && $end_time != null){
            $start_time = Carbon::create(2020, 1, 1, 0); //strtotime('2020-01-01 00:00:00');
        }

        elseif($start_time != null && $end_time == null){
            $end_time = now();
        }

        $direct_sales_prfs = $this->warehousePrfs->whereIn('client_id',$this->directSalesCustomersArray())
                                ->where('created_at', '>=', $start_time)
                                ->where('created_at', '<=', $end_time)
                                ->whereIn('approval_status', ["APPROVED_NOT_COLLECTED","APPROVED_COLLECTED"]);
                                 
        return $direct_sales_prfs;
    }

    public function directTotalSales($start_time= null, $end_time = null){
        if($start_time==null && $end_time == null){
            $start_time= now()->startOfMonth() ;
            $end_time = now()->endOfMonth() ;
        }
        elseif($start_time==null && $end_time != null){
            $start_time = Carbon::create(2020, 1, 1, 0); //strtotime('2020-01-01 00:00:00');
        }

        elseif($start_time != null && $end_time == null){
            $end_time = now();
        }
        $sales_totals = 0;
 
                                 
        foreach ($this->directSalesPrfs($start_time, $end_time) as $prf) {
                   
            $sales_totals += $prf->order_total;
            
        }
        return $sales_totals;
    }

    ///need to be reviewed
    public function directTotalLodgements($start_time= "", $end_time = "" ){
        if($start_time==null && $end_time == null){
            $start_time= now()->startOfMonth();
            $end_time = now()->endOfMonth();
        }
        elseif($start_time==null && $end_time != null){
            $start_time = strtotime('2020-01-01 00:00:00');
        }
        elseif($start_time != null && $end_time == null){
            $end_time = now();
        }
        $total_lodgements = 0;
        foreach ( CustomerTransaction::where('account_id',$this->account->id)->where('related_process','SST_LODGEMENT')->where('created_at', '>=', $start_time)->where('created_at', '<=', $end_time)->get() as $lodgement) {
                   
            $total_lodgements += $lodgement->amount;
            
        }
        return $total_lodgements;
    }

    public function direcProductSalesQuantity($product_id,$start_time=null , $end_time = null ){
        if($start_time==null && $end_time == null){
            $start_time= now()->startOfMonth() ;
            $end_time = now()->endOfMonth() ;
        }
        elseif($start_time==null && $end_time != null){
            $start_time = Carbon::create(2020, 1, 1, 0); //strtotime('2020-01-01 00:00:00');
        }
        elseif($start_time != null && $end_time == null){
            $end_time = now();
        }
        $sales_totals = 0; 
        $product_sales_quantity = 0;
        
        foreach ($this->directSalesPrfs($start_time, $end_time) as $prf) {
             $sales_snapshot = json_decode($prf->order_snapshot);
            
             foreach ($sales_snapshot as $sales_item) {
                 if($sales_item->product_id== $product_id){

                     $product_sales_quantity += $sales_item->product_quantity;
                 }
             }     
            
        }
        return $product_sales_quantity;
    } 

    public function directProductSalesValue($product_id,$start_time=null , $end_time = null ){
        if($start_time==null && $end_time == null){
            $start_time= now()->startOfMonth() ;
            $end_time = now()->endOfMonth() ;
        }
        elseif($start_time==null && $end_time != null){
            $start_time = Carbon::create(2020, 1, 1, 0); //strtotime('2020-01-01 00:00:00');
        }
        elseif($start_time != null && $end_time == null){
            $end_time = now();
        }
        $sales_totals = 0;
        $product_sales_value = 0;
        foreach ($this->directSalesPrfs($start_time, $end_time) as $prf) {
             $sales_snapshot = json_decode($prf->order_snapshot);
             
             foreach ($sales_snapshot as $sales_item) {
                 if($sales_item->product_id == $product_id){

                     $product_sales_value += $sales_item->product_price * $sales_item->product_quantity;
                 }
             }     
            
        }
        return $product_sales_value;
    }

}
