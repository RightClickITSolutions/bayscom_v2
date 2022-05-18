<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;


use App\Models\Customer;
use App\Models\CustomerTransaction;
use Illuminate\Http\Request;

class LodgementsController extends Controller
{
    public function lodgementView()
    {
        $view_data = [];
        $customer_id = '';
        // $view_data['heading'] = 'View Lodgements.';
        $lodgements = CustomerTransaction::all();
        $customers = Customer::where('id', $lodgements->customer_id)->get();
        return $customers;
        // echo $customer_id;
        // $view_data['customer_data'] = Customer::find('id', $customer_id)->get();
        // return view('lodgements.view', $view_data);
    }

    public function lodgementCreate()
    {
         //return Customer::find(4)->customerType;
        $view_data['customers'] =  Customer::whereIn('state',json_decode(Auth::user()->accessibleEntities()->states) )->where('customer_type', 1)->get();
        return view('view_lodgement_customer', $view_data);

        // return $view_data['customers'];
    }

    public function lodgementConfirm()
    {
        return 'Lodgement Confirm';
    }
}
