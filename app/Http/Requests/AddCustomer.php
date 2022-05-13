<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCustomer extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if($this->isMethod('post')){
        $rules = [
            //
            'name'=>'string|required|max:220', 
            'customer_type'=>'integer|required|max:220', 
            'payment'=>'string|required|max:220', 
            'email'=>'string|required|max:220', 
            'phone'=>'string|required|max:220' ,
            'state'=>'string|required|max:220',
            'address'=>'string|required|max:220', 
            'current_balance'=>'numeric|required',   
            
        ];
        return $rules;
        }
        else{
            return [];
        }
    }
}
