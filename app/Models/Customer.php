<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PriceScheme;
use Illuminate\Database\Eloquent\SoftDeletes; 
use App\Models\Substore;
use App\Models\State;

class Customer extends Model
{
    use SoftDeletes;
    protected $table = 'customers';
    public function substore(){
        //return Substore::where('customer_id',$this->id)->first();
        return $this->hasOne('App\Models\Substore','customer_id','id');
    }

    public function productScheme($product_id){
        return PriceScheme::where('customer_type',$this->customer_type)->where('product_id',$product_id)->get()->first();
    }

    public function customerType (){
        return $this->belongsTo('App\Models\CustomerType','customer_type','id');
    }

    public function customerPrfs(){
        return $this->hasMany('App\Models\Prf','client_id', 'id');
    }

    public function totalPurchases(){
        $total_purchases = 0;
        foreach( $this->payments->where('transaction_type', 'CREDIT') as $payment){
            $total_purchases += $payment->amount;
        }
        return $total_purchases;
        //todo
    }
    public function totalOutstanding(){
        $total_Outstanding = 0;
        //todo
    }

    //renamed transaction and graduallly migrate useage of payemnt to transactions where appropriate
    public function payments(){
        return  $this->hasMany('App\Models\CustomerTransaction', 'customer_id' , 'id');
    }

    public function transactions(){
        return  $this->hasMany('App\Models\CustomerTransaction', 'customer_id' , 'id');
    }

    public function totalPayments($start_time=null , $end_time = null){
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
        $total_payments = 0;
        foreach( $this->payments->where('created_at', '>=', $start_time)->where('created_at', '<=', $end_time)->where('transaction_type', 'CREDIT')->where('comment', 'Customer payment ') as $payment){
            $total_payments += $payment->amount;
        }
        return $total_payments;

    }

    public function paymentIntervalLastBalance($start_time=null , $end_time = null){
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
        $last_interval_balance = 0;
        $last_interval_payment = $this->payments->where('created_at', '>=', $start_time)->where('created_at', '<=', $end_time)->where('transaction_type', 'CREDIT')->where('comment', 'Customer payment ')->whereNotIn('balance',[null])->sortByDesc('created_at')->first();
       
        if($last_interval_payment ){
            
                $last_interval_balance = $last_interval_payment->balance;
            
        }        
        else{
            $last_payment = $this->payments->sortByDesc('created_at')->whereNotIn('balance',[null])->first();
             return $last_payment->balance;
            if($last_payment){
                $last_interval_balance = $last_payment->balance;
                
            }
            else{
                $last_interval_balance = $this->balance;
            }
        }    
        return $last_interval_balance;
    }

    public function approvedPayments(){
        return  $this->hasMany('App\Models\CustomerTransaction', 'customer_id' , 'id')->where('approval_status','CONFIRMED');
    }

    public function lastPayment(){
         return $this->payments->sortByDesc('id')->first();
    }

    public function state(){
        return State::where('id', $this->state)->first();
    }

    public function customerOrder()
    {
        return $this->hasMany('App\Models\CustomerOrder','client_id','id');
    }
    
}
