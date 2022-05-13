<?php

namespace App\Models;
use App\Models\AccountTransaction;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Lubebay extends Model
{
    protected $table = "lubebays";

    public function lsts(){
       return  $this->hasMany('App\Models\LubebayServiceTransaction','lubebay_id','id');
    }
    public function expenses(){
        return  $this->hasMany('App\Models\LubebayExpense','lubebay_id','id');
    }

    public function expenses_range($start_time= null, $end_time = null){
        if($start_time==null || $end_time == null){
            $start_time= now()->startOfMonth() ;
            $end_time = now()->endOfMonth() ;
        }

        return  $this->expenses->whereBetween('created_at', [$start_time,$end_time]);
    }

    
    
    public function account(){
        return  $this->hasOne('App\Models\Account','owner_id','id')->where('account_type','LUBEBAY');
    }
    public function lodgements(){
        return AccountTransaction::where('account_id',$this->account->id)->where('related_process','LST_LODGEMENT')->get();
    }
    public function lodgements_range($start_time= null, $end_time = null){
        if($start_time==null || $end_time == null){
            $start_time= now()->startOfMonth() ;
            $end_time = now()->endOfMonth() ;
        }

        return  $this->lodgements()->whereBetween('created_at', [$start_time,$end_time]);
    }
    public function substore(){
        return  $this->hasOne('App\Models\Substore','id','substore_id');
    }

    public function total_lodgements($start_time= null, $end_time = null ){
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
        foreach ( AccountTransaction::where('account_id',$this->account->id)->where('related_process','LST_LODGEMENT')->where('created_at', '>=', $start_time)->where('created_at', '<=', $end_time)->get() as $lodgement) {
                   
            $total_lodgements += $lodgement->amount;
            
        }
        return $total_lodgements;
    }
    public function unlodged_lsts(){
        return $this->lsts->where('transaction_id',null);
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
        foreach ($this->lsts->where('created_at', '>=', $start_time)->where('created_at', '<=', $end_time)->where('approval_status', 'CONFIRMED') as $lubebay_lst) {
                   
            $sales_totals += $lubebay_lst->total_amount;
            
        }
        return $sales_totals;
    }

    
    //garudually depricat this accoss the system
    public function total_expense($start_time= "", $end_time = "" ){
        $start_time= now()->startOfMonth() ;
        $end_time = now()->endOfMonth() ;
        
        $expense_totals = 0;
        
        foreach ($this->expenses->whereBetween('created_at', [$start_time,$end_time]) as $lubebay_expense) {
                   
            $expense_totals +=  $lubebay_expense->amount;
            
        }
        return $expense_totals;
    }
    //use this going forward
    public function total_expenses($start_time= null, $end_time = null){
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
        
        $expense_totals = 0;
        
        foreach ($this->expenses->where('created_at', '>=', $start_time)->where('created_at', '<=', $end_time) as $lubebay_expense) {
                   
            $expense_totals +=  $lubebay_expense->amount;
            
        }
        return $expense_totals;
    }
    //notuse if it is used somewhere comment if it breaks somthing
    public function serviceSalesQuantity($service_id,$start_time=null , $end_time = null ){
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
        $service_sales_quantity = 0;
        
        foreach ($this->lsts->where('created_at', '>=', $start_time)->where('created_at', '<=', $end_time)->where('approval_status', 'CONFIRMED')  as $lubebay_lst) {
             $sales_snapshot = json_decode($lubebay_lst->order_snapshot);
            
             foreach ($sales_snapshot as $sales_item) {
                 if($sales_item->service_id== $service_id){

                     $service_sales_quantity += $sales_item->service_quantity;
                 }
             }     
            
        }
        return $service_sales_quantity;
    } 

    public function serviceCount($service_id,$start_time=null , $end_time = null ){
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
        $service_sales_quantity = 0;
        
        foreach ($this->lsts->where('created_at', '>=', $start_time)->where('created_at', '<=', $end_time)->where('approval_status', 'CONFIRMED')  as $lubebay_lst) {
             $sales_snapshot = json_decode($lubebay_lst->order_snapshot);
            
             foreach ($sales_snapshot as $sales_item) {
                 if($sales_item->service_id== $service_id){

                     $service_sales_quantity += $sales_item->service_quantity;
                 }
             }     
            
        }
        return $service_sales_quantity;
    } 
    public function serviceSalesValue($service_id,$start_time=null , $end_time = null ){
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
        $service_sales_value = 0;
        foreach ($this->lsts->where('created_at', '>=', $start_time)->where('created_at', '<=', $end_time)->where('approval_status', 'CONFIRMED') as $lubebay_lst) {
             $sales_snapshot = json_decode($lubebay_lst->order_snapshot);
             
             foreach ($sales_snapshot as $sales_item) {
                 if($sales_item->service_id == $service_id){

                     $service_sales_value += $sales_item->service_price * $sales_item->service_quantity;
                 }
             }     
            
        }
        return $service_sales_value;
    }

    
    //
}
