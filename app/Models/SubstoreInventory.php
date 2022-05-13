<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubstoreInventory extends Model
{
    protected $table = "substore_inventory";
    //
    public function product(){
        return $this->belongsTo('App\Models\Product','product_id','id');
    }
}
