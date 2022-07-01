<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 


class Prf extends Model
{
    use SoftDeletes;

    protected $table = "prfs";
    //
    public function approval(){
        return $this->hasOne('App\Models\Approval','process_id','id')->where('process_type','PRF');
    }

    public function createdBy(){
        $user = $this->hasOne('App\User','id','sales_rep');
        return $user; 
        //TODO 
        //Make this return only usernames
    }
    
    public function warehouse(){
        return $this->hasOne('App\Models\Warehouse','id', 'warehouse_id');
    }

    public function order_snapshot(){
        return  json_decode( $this->order_snapshot);
    }
    public function customer(){
        return $this->hasOne('App\Models\Customer','id','client_id');
    }
    public function approvedBy($level){
        $approvals = $this->approval;

        if($level=='l0'){
            return \App\User::find($approvals->l0)->name;

        }
        elseif($level=='l1')
        {
            return \App\User::find($approvals->l1)->name;
        }
        elseif($level=='l2')
        {
            return \App\User::find($approvals->l2)->name;
        }
        elseif($level=='l3')
        {
            return \App\User::find($approvals->l3)->name;
        }
        elseif($level=='l4')
        {
            return \App\User::find($approvals->l4)->name;
        }
        elseif($level=='l5')
        {
            return \App\User::find($approvals->l5)->name;
        }

        else
        {
            return NULL;
        }
    }
    public function payments(){

       return  $this->hasMany('App\Models\CustomerTransaction', 'order_id' , 'id');

    }

    public function totalPaid(){
        $total_payments = 0;
        foreach ($this->payments->where('transaction_type','CREDIT')->where('approval_status','CONFIRMED') as $payment) {
            $total_payments += $payment->amount;
        }
        return $total_payments;

    }

    public function reversed(){

        //todo 
        ///implement reversal log funtions
        return false;
        
    }

}
