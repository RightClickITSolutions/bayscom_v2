<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerOrder extends Model
{
    protected $table = 'client_orders';

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer','client_id','id');
    }

}
