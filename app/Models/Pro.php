<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
use StockTransactions;

class Pro extends Model
{
    use SoftDeletes;
    protected $table = "pros";
    //
    public function approval(){
        return $this->hasOne('App\Models\Approval','process_id','id')->where('process_type','PRO');
    }

    public function createdBy(){
        $user = $this->hasOne('App\User','id','user_id');
        return $user; 
        //TODO 
        //Make this return only usernames
    }
    public function warehouse(){
        return $this->hasOne('App\Models\Waresouse','warehouse_id', 'id');
    }

    public function order_snapshot(){
        return  json_decode( $this->order_snapshot);
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

    public function received_product_quantity($product_id){
        $received_pro_product_transactions = StockTransaction::where('order_id',$this->id)->where('order_type','PRO')->where('product_id',$product_id)->get();
        $total_received_quantity = 0;
        foreach($received_pro_product_transactions as $pro_product){
            $total_received_quantity += $pro_product->quantity;

        }
        return $total_received_quantity;
    }

    public function received_products_log(){
        $received_product_log = StockTransaction::where('order_id',$this->id)->where('order_type','PRO')->get();
        
        return $received_products_log;
    }
}
