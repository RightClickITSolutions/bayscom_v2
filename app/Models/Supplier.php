<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
    public function formFields() {
        return [
            [
                'input_name' => 'supplier',
                'input_type' => 'text',
                'input_label' => 'Supplier Name',
                'value' => ''
            ]
        ];
    }
}
