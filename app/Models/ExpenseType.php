<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 
class ExpenseType extends Model
{
    protected $table = 'expense_type';
    use SoftDeletes;
    //
}
