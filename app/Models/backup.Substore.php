<?php

namespace App\Models;
use App\Models\AccountTransaction;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Substore extends Model
{
    protected $table = "substores";
    //

    function customerProfile(){
        return $this->hasOne('App\Models\Customer', 'id', 'customer_id');
    }

    public function ssts(){
        return  $this->hasMany('App\Models\SubstoreTransaction','substore_id','id');
    }
    
    public function total_sales($start_time= null, $end_time = null){
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
        foreach ($this->ssts->where('created_at', '>=', $start_time)->where('created_at', '<=', $end_time)->where('approval_status', 'CONFIRMED')  as $substore_sst) {
            if($substore_sst->transaction_type == 'CREDIT'){
                $sales_totals += $substore_sst->amount;
            }
            elseif($substore_sst->transaction_type == 'DEBIT'){
                $sales_totals -= $substore_sst->amount;
            }       
            
            
        }
        return $sales_totals;
    }

    public function total_lodgements($start_time= "", $end_time = "" ){
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
        foreach ( AccountTransaction::where('account_id',$this->account->id)->where('related_process','SST_LODGEMENT')->where('created_at', '>=', $start_time)->where('created_at', '<=', $end_time)->get() as $lodgement) {
                   
            $total_lodgements += $lodgement->amount;
            
        }
        return $total_lodgements;
    }

    public function account(){
        return $this->hasOne('App\Models\Account','owner_id','id')->whereIn('account_type',['STATION_SUBSTORE','LUBEBAY_SUBSTORE']);
    }
    
    public function lodgements($start_time= null, $end_time = null){
        if($start_time==null || $end_time == null){
            $start_time= now()->startOfMonth() ;
            $end_time = now()->endOfMonth() ;
        }
        $sales_totals = 0;

        return AccountTransaction::where('account_id',$this->account->id)->where('related_process','SST_LODGEMENT')->whereBetween('created_at', [$start_time,$end_time])->get();
        
       
    }

    public function lodgements_range($start_time= null, $end_time = null){
        if($start_time==null || $end_time == null){
            $start_time= now()->startOfMonth() ;
            $end_time = now()->endOfMonth() ;
        }
        $sales_totals = 0;

        return AccountTransaction::where('account_id',$this->account->id)->where('related_process','SST_LODGEMENT')->whereBetween('created_at', [$start_time,$end_time])->get();
        
       
    }
    
    public function unlodged_ssts(){
        return $this->ssts->where('transaction_id',null);
    }
    
    public function inventory(){
        return $this->hasMany('App\Models\SubstoreInventory','substore_id','id');
    }
    
    public function productInventory($product_id){
        
        $product_inventory = $this->inventory->where('product_id',$product_id)->first();
        if($product_inventory){
            return $product_inventory->quantity;
        }
        else{
            return "0" ;
        }
    }

    public function productSalesQuantity($product_id,$start_time=null , $end_time = null ){
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
        
        foreach ($this->ssts->where('created_at', '>=', $start_time)->where('created_at', '<=', $end_time)->where('approval_status', 'CONFIRMED')  as $substore_sst) {
             $sales_snapshot = json_decode($substore_sst->sales_snapshot);
            
             foreach ($sales_snapshot as $sales_item) {
                 if($sales_item->product_id== $product_id){

                     $product_sales_quantity += $sales_item->product_quantity;
                 }
             }     
            
        }
        return $product_sales_quantity;
    } 

    public function productSalesValue($product_id,$start_time=null , $end_time = null ){
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
        foreach ($this->ssts->where('created_at', '>=', $start_time)->where('created_at', '<=', $end_time)->where('approval_status', 'CONFIRMED') as $substore_sst) {
             $sales_snapshot = json_decode($substore_sst->sales_snapshot);
             
             foreach ($sales_snapshot as $sales_item) {
                 if($sales_item->product_id == $product_id){

                     $product_sales_value += $sales_item->product_price * $sales_item->product_quantity;
                 }
             }     
            
        }
        return $product_sales_value;
    }

    public function stockTransactions(){
        return $this->hasMany('App\Models\SubstoreStockTransaction','substore_id','id');
    }

    public function productStock($product_id,$date=null){
        $date_stock_balance = 0;
        $accuracy = 1;
        if($date==null){
            return [$this->productInventory($product_id),$accuracy] ;
            
        }
        else{
            $last_stock_transaction_with_balance = $this->stockTransactions->where('product_id',$product_id)->sortByDesc('created_at')->whereNotIn('stock_balance',[null])->where('created_at' ,'<=', $date)->first();

            if($last_stock_transaction_with_balance){
                $date_stock_balance = $last_stock_transaction_with_balance->stock_balance;
                $accuracy = 1;
                foreach ($this->stockTransactions->where('product_id',$product_id)->where('created_at' ,'>', $last_stock_transaction_with_balance->created_at)->where('created_at' <= $date) as $stock_transaction_after_last_balance) {
                    if ($stock_transaction_after_last_balance->transaction_type=="CREDIT") {
                        $date_stock_balance += $stock_transaction_after_last_balance->quantity;
                    }
                    elseif ($stock_transaction_after_last_balance->transaction_type=="DEBIT") {
                        $date_stock_balance -= $stock_transaction_after_last_balance->quantity;
                    }
                    $accuracy = 2;
                    
                }
            }
            else{
                $date_stock_balance = $this->productInventory($product_id);
                $accuracy = 3;
                foreach ($this->stockTransactions->where('product_id',$product_id)->where('created_at' , '>' , $date) as $stock_transaction_before_curent_inventory){
                    if ($stock_transaction_before_curent_inventory->transaction_type=="CREDIT") {
                        $date_stock_balance -= $stock_transaction_before_curent_inventory->quantity;
                    }
                    elseif ($stock_transaction_before_curent_inventory->transaction_type=="DEBIT") {
                        $date_stock_balance += $stock_transaction_before_curent_inventory->quantity;
                    }
                   

                }
            }

            return [$date_stock_balance,$accuracy];
        }
    }

    public function productStockRecieved($product_id,$date=null){
        $date_stock_recieved = 0;
        if($date == null){
            $date = now();
        }
        $days_stock_transactions = $this->stockTransactions->where('product_id',$product_id)->where('created_at', '>=', $date->startOfDay())->where('created_at', '<=', $date->endOfDay());
        //return $date->format('Y-m-d');
        foreach ($days_stock_transactions as $stock_transaction) {
            if($stock_transaction->transaction_type == 'CREDIT'){
                $date_stock_recieved += $stock_transaction->quantity;
            }
            elseif($stock_transaction->transaction_type == 'DEBIT' && ($stock_transaction->transaction_id == 'INV-ADJ' || substr($stock_transaction->transaction_id,0,2) == 'REV' ) ){
                $date_stock_recieved -= $stock_transaction->quantity;
            }
           
        }

        return $date_stock_recieved;
        
       
    }


    
}
