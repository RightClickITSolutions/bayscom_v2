<?php

namespace App\Models;
use App\Models\SubstoreTransaction;

use Illuminate\Database\Eloquent\Model;

class SubstoreStockTransaction extends Model
{
    //
    public function createdBy(){
        if(SubstoreTransaction::find($this->transaction_id))
        {
            return SubstoreTransaction::find($this->transaction_id)->createdBy->name;
        }
        else{
            return 'N/A';
        }
    }
}
