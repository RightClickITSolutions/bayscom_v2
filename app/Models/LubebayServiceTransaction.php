<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class LubebayServiceTransaction extends Model
{
     use SoftDeletes;
     protected $table = "lubebay_service_transactions";
    //
    
    //
    public function approval(){
        return $this->hasOne('App\Models\Approval','process_id','id')->where('process_type','LST');
    }
    public function createdBy(){
        $user = $this->hasOne('App\User','id','user_id');
        return $user; 
        //TODO 
        //Make this return only usernames
    }

    public function lubebay(){
        return $this->belongsTo('App\Models\Lubebay','lubebay_id','id');
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

    public function totalLodgments(){
        $total_lodgments = 0;
        $lodgments =  LubebayTransaction::where('process_type','LST_LODGEMENT')->where('process_id',$this->id);
        foreach ($lodgments as $lodgment) {
            $total_lodgments += $lodgment->amount;
        }
        
        return $total_lodgments;
    }

    public function totalUnderlodgments(){
        $total_underlodgments = 0;
        $underlodgments = LubebayExpense::where('related_process','LST')->where('proccess_id',$this->id);
        foreach ($underlodgments as $underlodgment) {
            $total_underlodgments += $underlodgment->amount;
        }

        return $total_underlodgments;
    }
}
