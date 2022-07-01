<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class SubstoreTransaction extends Model
{
    use SoftDeletes;
    protected $table = "substore_transactions";
    //
    public function order_snapshot(){
        return  json_decode( $this->sales_snapshot);
    }
    
    public function substore(){
        return $this->belongsTo('App\Models\Substore', 'substore_id', 'id');
    }
    public function createdBy(){
        $user = $this->hasOne('App\User','id','user_id');
        return $user; 
        //TODO 
        //Make this return only usernames
    }
    public function approval(){
        return $this->hasOne('App\Models\Approval','process_id','id')->where('process_type','SST');
    }

    public function reversalApproval(){
        return $this->hasOne('App\Models\Approval','process_id','id')->where('process_type','SST-REVERSAL');
    }

    public function reversed(){
        if(Approval::where('process_id',$this->id)->where('process_type','SST-REVERSAL')->first()){
            return true;
        }
        else {
            return false;
        }
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

    public function reversalApprovedBy($level){
        $approvals = $this->reversalApproval;

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
}
