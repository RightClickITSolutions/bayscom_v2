<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Customer;
use App\Models\CustomerTransaction;
use App\Models\Substore;
use App\Http\Controllers\Custom\AccountTransactionClass;
use App\Helpers\PostStatusHelper;
use DataTables;
use Yajra\DataTables\Html\Builder;


use App\Http\Controllers\Custom\CommitOrderTransaction;
// use Symfony\Component\HttpFoundation\Session\Session;


class CustomerController extends Controller
{
    //


    public function addCustomer(Requests\AddCustomer $request){
        $view_data = [];
        $post_status = "NONE";
        $post_status_message = "NONE";

        $view_data['post_status'] = $post_status;
        $view_data['post_status_message'] = $post_status_message;
        if($request->isMethod('post'))
        {   
            
            DB::beginTransaction();
            try {

                    $new_customer = new Customer;
                                    
                    $new_customer->name = $request->input('name');
                    $new_customer->address = $request->input('address');
                    $new_customer->state = $request->input('state');
                    $new_customer->email = $request->input('email');
                    $new_customer->phone = $request->input('phone');
                    $new_customer->alternate_phone = $request->input('alternate_phone');
                    $new_customer->old_ref_id = $request->input('old_ref_id');
                    $new_customer->payment = $request->input('name');
                    $new_customer->customer_type = $request->input('customer_type');
                    $new_customer->price_scheme_id = 1 ;//$request->input('name');
                    $new_customer->balance = $request->input('current_balance');
                    $new_customer->customer_creator = 1;// $request->input('name');
                    $new_customer->save();
                
                if($request->input('customer_type')==2||$request->input('customer_type')==3){
                    $new_substore = new Substore;
                    $new_substore->name = $request->input('name');
                    $new_substore->customer_id = $new_customer->id;
                    $new_substore->type = $request->input('customer_type');
                    $new_substore->location = $request->input('address');
                    $new_substore->save();

                }
                
                $post_status = 'SUCCESS';
                $post_status_message = "new customer ".$request->input('name')." was successfully added";
                $view_data['post_status'] = $post_status;
                $view_data['post_status_message'] = $post_status_message;


            
            }
            catch(exception $e){
                $post_status = 'FAILED';
                $post_status_message = "new customer addition failed";

                $view_data['post_status'] = $post_status;
                $view_data['post_status_message'] = $post_status_message;
                DB::rollback();
            }
            DB::commit();
        }
        else{

        }


        return view('add_customer',$view_data);

    }

    public function viewAllCustomers(){
        //return Customer::find(4)->customerType;
        $view_data['customers'] =  Customer::whereIn('state',json_decode(Auth::user()->accessibleEntities()->states) )->where('customer_type', 1)->get();
        return view('view_all_customers', $view_data);

        // return $view_data['customers'];
    }

    public function customerEditBalance($cid)
    {
        $view_data['customer_edit_balance'] = Customer::where('id', $cid)->get();

        return view('edit_balance', $view_data);
    }

    public function customerEditBalanceInts(Request $request)
    {
        $cid = $request->input('edit_id');
        $edit_balance = $request->input('edit_balance');

         $edit_customer = Customer::where('id', $cid)->update([
            "balance" => $edit_balance
        ]);

        if ($edit_customer) {
            $request->session()->flash('status-balance', 'Balance has been changed');
            return redirect('/customers');
        }else{
            $request->session()->flash('status-balance', 'Error changing balance');
            return redirect('/customers');
        }

    }

    public function viewCustomerOrders(Customer $customer){
        //return  Customer::find(4)->customerPrfs;
        $view_data['customer'] =  $customer;
        return view('customer_orders', $view_data);
    }

    public function viewCustomerTransactions(Customer $customer){
        //return  Customer::find(4)->customerPrfs;
        // dd($customer);
        
        
        // $model = Customer::with('payments')->where('id',$customer->id);
        // // dd($model);
        
        // if (request()->ajax()) {
            //     return DataTables::of(CustomerTransaction::query()->with('customer')->where('customer_id',$customer->id))->toJson();
            // }
            
            // $tabledata = DataTables::of(CustomerTransaction::query()->with('customer')->where('customer_id',$customer->id))->toJson();
            // // dd($tabledata);
            
            // $html = $builder->columns([
                //     ['data' => 'amount', 'name' => 'amount', 'title' => 'Name'],
                //     ['data' => 'created_at', 'name' => 'created_at', 'title' => 'Created At'],
                //     ['data' => 'updated_at', 'name' => 'updated_at', 'title' => 'Updated At'],
                // ]);
                // // dd($html);
                // $view_data['payments'] =  $html;
                
                // dd($view_data);
                
        $view_data['customer'] =  $customer;
        return view('customer_transactions', $view_data);
    }

    public function customerPayment(Request $request, Customer $customer){
        $post_status = new PostStatusHelper;
        $view_data['customer'] = $customer;
        if($request->isMethod('post')){
            $request->validate([
                'payment_amount' => 'required |numeric',
                'teller_no' => 'required'
            ]);
            //add check for accidental double post / additional paymment fter amount is covered.
            $payment_amount = $request->get('payment_amount') ;
            $bank_reference = $request->get('teller_no') ;
            //die("prf payment class jsut befor thecommmit order trnsaction class");
            $order_transaction = new CommitOrderTransaction;
            $customer_transaction_id = $order_transaction->customerPayment($customer,"CREDIT",$payment_amount,"Customer payment ", $reference_number=$bank_reference);
            
            
            //add below to approval function
            //$account_transaction = new AccountTransactionClass;
            ///$transaction_id = $account_transaction->new_transaction("1", $related_process="CUSTOMER_PAYMENT", $related_process_id=$customer_transaction_id ,$transaction_type="CREDIT",$transaction_amount=$payment_amount,$payment_comment="",$bank_reference="NONE", $approved=true);
            //if( $customer_transaction_id && $transaction_id)
            if( $customer_transaction_id )
            {
                $post_status->success();
                $view_data['post_status'] = $post_status->post_status;
                $view_data['post_status_message'] = $post_status->post_status_message;
                $view_data['customer'] = $customer;
                return view('customer_transactions', $view_data); 
            }
            else {
                $post_status->failed();
                $view_data['post_status'] = $post_status->post_status;
                $view_data['post_status_message'] = $post_status->post_status_message;

                return view('customer_lodgment', $view_data);
            }

            
            
            return view('customer_transactions', $view_data);

        }
    
        
        return view('customer_lodgment',$view_data);
    }

    public function confirmCustomerLogement(){
        $direct_sales_customers_array = Customer::all()->whereIn('state',json_decode(Auth::user()->accessibleEntities()->states) )->where('customer_type',1)->pluck('id')->toArray();
        
        $view_data['customer_payment_transactions'] = CustomerTransaction::where('transaction_type','CREDIT')->where('approval_status', 'CONFIRMED')->whereIn('customer_id',$direct_sales_customers_array)->limit(100)->get();
        return view('lodgements.view', $view_data);
    }

    public function confirmCustomerLogementInst()
    {
        $direct_sales_customers_array = Customer::all()->whereIn('state',json_decode(Auth::user()->accessibleEntities()->states) )->where('customer_type',1)->pluck('id')->toArray();
        
        $view_data['customer_payment_transactions'] = CustomerTransaction::where('transaction_type','CREDIT')->where('approval_status', 'NOT_CONFIRMED')->whereIn('customer_id',$direct_sales_customers_array)->get();
        return view('lodgements.view', $view_data);
        // return $view_data['customer_payment_transactions'];
    }

    public function customerEdit($cid)
    {
        $view_data['customer_edit_data'] = Customer::where('id', $cid)->get();
        return view('edit_customer', $view_data);
    }

    public function instEdit($cid, Request $request)
    {
        $fullname = $request->input('edit_name');
        $email = $request->input('edit_email');
        $phone = $request->input('edit_phone');
        $address = $request->input('edit_address');
        $balance = $request->input('edit_balance');

        $state = '';

        if($request->input('state') == 'Kano') {
            $state = 1;
        }elseif($request->input('state') == 'Abuja'){
            $state = 2;
        }

        $edit_customer = Customer::where('id', $cid)->update([
            "name" => $fullname,
            "address" => $address,
            "email" => $email,
            "phone" => $phone,
            "state" => $state,
            "balance" => $balance,
        ]);

        if ($edit_customer) {
            $request->session()->flash('status', 'Customer Edit!');
            return redirect('/customers');
        }else{
            $request->session()->flash('status', 'Error editing customer!');
            return redirect('/customers');
        }

    }

    public function customerDelete($cid)
    {
        $view_data['customer_delete_data'] = Customer::where('id', $cid)->get();
        return view('delete_customer', $view_data);
    }

    public function instDelete($cid, Request $request)
    {
        $deleted = Customer::where('id', $cid)->delete();
        if ($deleted) {
            $request->session()->flash('status', 'Customer deleted!');
            return redirect('/customers');
        }else{
            $request->session()->flash('status', 'Customer not deleted!');
            return redirect('/customers');
        }
    }

    public function reverseLodgement($lid)
    {
        $view_data['lodgement_to_reverse'] = CustomerTransaction::where('id', $lid)->get();

        return view('lodgements.reverse', $view_data);
    }

    public function reverseInstLodgement(Request $request)
    {
        $lid = $request->input('lid');
        
        $reverse_lodgement = CustomerTransaction::where('id', $lid)->delete();

        if ($reverse_lodgement) {
            $request->session()->flash('status', 'Lodgement Reverse successfully.');
            return redirect('/customer/lodgement/confirmation');
        }else{
            $request->session()->flash('status_error', 'Error while reversing lodgement.');
            return redirect('/customer/lodgement/confirmation');
        }
    }

    public function lodgementCreate()
    {
        
    }
}
