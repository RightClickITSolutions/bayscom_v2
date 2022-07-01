<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';

    function transactions(){
        return $this->hasMany('App\Models\AccountTransaction','account_id','id');
        
    }
    //
}
