<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
class LubebayExpenseType extends Model
{
    protected $table = 'lubebay_expense_type';
    use SoftDeletes;
    //
}
