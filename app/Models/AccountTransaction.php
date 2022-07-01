<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class AccountTransaction extends Model
{
    use softDeletes;
    protected $table = 'account_transactions';

    public function related_lst_sales(){
        return $this->hasMany('App\Models\LubebayServiceTransaction','transaction_id', 'id');
    }

    public function related_lst_underlodgemnets(){
        return $this->hasMany('App\Models\LubebayExpense','process_id', 'id')->where('related_process','LST_LODGEMENT');
    }
    public function lst_lodgment_expected_value(){
        $total_orders_value = 0;
        foreach ($this->related_lst_sales as $sale) {
            $total_orders_value += $sale->total_amount;
        }
        return $total_orders_value;
    }

    public function lst_total_underlodgments(){
        $total_underlodgememnts = 0;
        foreach ($this->related_lst_underlodgments as $underlodgement) {
            $total_orders_value += $underlodgement->amount;
        }

    return $total_orders_value;
    }

    public function related_sst_sales(){
        return $this->hasMany('App\Models\SubstoreTransaction','transaction_id', 'id');
    }
    public function related_sst_underlodgemnets(){
        return $this->hasMany('App\Models\expense','transaction_id', 'id');
    }

    

    public function sst_lodgment_expected_value(){
            $total_orders_value = 0;
        foreach ($this->related_sst_sales as $sale) {
            $total_orders_value += $sale->amount;
        }
        return $total_orders_value;
    }

    public function sst_total_underlodgments(){
        $total_underlodgememnts = 0;
        foreach ($this->related_sst_underlodgments as $sale) {
            $total_orders_value += $sale->order_amount;
        }
    return $total_orders_value;
    }

    public function approval(){
        return $this->hasOne('App\Models\Approval','process_id','id')->where('process_type','ACCOUNT_TRANSACTION');
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
    //
}
