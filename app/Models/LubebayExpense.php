<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class LubebayExpense extends Model
{
    //
    use SoftDeletes;
    protected $table = "lubebay_expenses";
    //
    public function approval(){
        return $this->hasOne('App\Models\Approval','process_id','id')->where('process_type','LUBEBAY_EXPENSE');
    }

    public function lubebay(){
        return $this->belongsTo('App\Models\Lubebay','lubebay_id','id');
    }

    public function createdBy(){
        $user = $this->hasOne('App\User','id','user_id');
        return $user; 
        //TODO 
        //Make this return only usernames
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
}
