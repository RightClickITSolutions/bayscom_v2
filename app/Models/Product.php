<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 

class Product extends Model
{
    use SoftDeletes;
    protected $table = 'products';
    //
    public function name(){
        return $this->product_name.'-'.$this->product_description;
    }

    public function productPrice($customer_type){
        
        $price_scheme = PriceScheme::where('customer_type',$customer_type)->where('product_id',$this->id)->get()->first();
        if($price_scheme){
            return $price_scheme->price;
        }
        else{
            return 0;
        }
    }
}
