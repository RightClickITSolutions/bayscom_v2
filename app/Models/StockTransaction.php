<?php

namespace App\Models;
use App\Models\Pro;
use App\Models\Prf;
use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    protected $table =  "stock_transactions";
    //
    public function createdBy(){
        if ($this->order_type == 'PRO'){
            return Pro::find($this->order_id)->createdBy ?? "N/A";
        }
        elseif($this->order_type == 'PRF'){
            return Prf::find($this->order_id)->createdBy ?? "N/A" ;
        }
        elseif($this->order_type == 'INTER_WAREHOUSE')
        {
            //TODO
            return 'NONE';

        }
    }
    
}
