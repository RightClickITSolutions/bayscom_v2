<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class CustomerTransaction extends Model
{
    use SoftDeletes;
    protected $table = "customer_transaction";
    //

    public function lodgedBy()
    {
        return $this->hasOne('App\User','id','created_by');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer','customer_id','id');
    }
    
    public function approval(){
        return $this->hasOne('App\Models\Approval','process_id','id')->where('process_type','CUSTOMER_LODGEMENT');
    }

    public function approvedBy($level){
        $approvals = $this->approval;
        if(!$approvals){
            return null;
        }
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
