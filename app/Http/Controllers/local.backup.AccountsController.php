<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Pro;
use App\Http\Controllers\Custom\AccountTransactionClass;
use App\Helpers\PostStatusHelper;
class AccountsController extends Controller
{
    //
    public function viewAllAccounts(Request $request){
        $accounts = Account::all();
        $view_data['accounts_list'] = $accounts;

        return view('accounts_view_all_accounts',$view_data);
    }

    public function viewAccountDetails(Request $request, Account $account){
        //$accounts = Account::all();
        
        $view_data['account'] = $account;

        return view('accounts_view_account_transactions',$view_data);
    }

    public function sageAccountDetails(Request $request){
        $account = Account::where('account_name', 'MOFAD_SAGE')->where('account_type','MAIN')->first();
        $unfulfiled_pros = Pro::where('approval_status','APPROVED_NOT_COLLECTED')->get();
        
        $unrecieved_products_total = 0 ;
        foreach($unfulfiled_pros as $unfulfiled_pro){
            
            foreach ($unfulfiled_pro->order_snapshot() as $order_product) {
                $unrecieved_products_total += $order_product->product_price * ($order_product->product_quantity - $unfulfiled_pro->received_product_quantity($order_product->product_id));
   
            }

            
        }
        $view_data['unrecieved_products_total'] = $unrecieved_products_total;
        $view_data['account'] = $account;

        return view('accounts_view_sage_account_transactions',$view_data);
    }

    public function postCreditDedit(Request $request, Account $account){
        $view_data['account'] = $account;
        $post_status = new PostStatusHelper;

        if ($request->isMethod('post')) {
            if($request->input('transaction_type')=='CREDIT'){
                $request->validate([
                    'credit_amount' => 'required|numeric',
                    'transaction_type' => 'required|in:CREDIT,DEBIT|string' 
                ]);
                $amount = $request->input('credit_amount');
            }
            elseif($request->input('transaction_type')=='DEBIT'){
                $request->validate([
                    'debit_amount' => 'required|numeric',
                    'transaction_type' => 'required|in:CREDIT,DEBIT|string' 
                ]);
                $amount = $request->input('debit_amount');
            }
            else{
                $request->validate([
                    'transaction_type' => 'required|in:CREDIT,DEBIT|string' 
                ]);
            }
            
            
            
            
            $account_transaction = new AccountTransactionClass;
            $account_transaction_id = $account_transaction->new_transaction(
                $account->id,
                $related_process="ADMIN_POST",
                $related_process_id=null,
                $transaction_type=$request->input('transaction_type'),
                $transaction_amount=$amount,
                $payment_comment="",
                $bank_reference=$request->input('bank_reference',''),
                $approved=true);
                
            if ($account_transaction_id) {
                $post_status->success();
                $post_status->post_status_message = $request->input('transaction_type').' Post Successful';

            }
            else{
                $post_status->failed();
            }
        }
        
        

        $view_data['post_status'] = $post_status->post_status;
        $view_data['post_status_message'] = $post_status->post_status_message;
        return view('accounts_account_post_credit_debits',$view_data);
    }
    public function sagePostCreditDedit(Request $request){
        $account = Account::where('account_name', 'MOFAD_SAGE')->where('account_type','MAIN')->first();
        $view_data['account'] = $account;
        $post_status = new PostStatusHelper;

        if ($request->isMethod('post')) {
            if($request->input('transaction_type')=='CREDIT'){
                $request->validate([
                    'credit_amount' => 'required|numeric',
                    'transaction_type' => 'required|in:CREDIT,DEBIT|string' 
                ]);
                $amount = $request->input('credit_amount');
            }
            elseif($request->input('transaction_type')=='DEBIT'){
                $request->validate([
                    'debit_amount' => 'required|numeric',
                    'transaction_type' => 'required|in:CREDIT,DEBIT|string' 
                ]);
                $amount = $request->input('debit_amount');
            }
            else{
                $request->validate([
                    'transaction_type' => 'required|in:CREDIT,DEBIT|string' 
                ]);
            }
            
            
            
            
            $account_transaction = new AccountTransactionClass;
            $account_transaction_id = $account_transaction->new_transaction(
                $account->id,
                $related_process="ADMIN_POST",
                $related_process_id=null,
                $transaction_type=$request->input('transaction_type'),
                $transaction_amount=$amount,
                $payment_comment="",
                $bank_reference=$request->input('bank_reference',''),
                $approved=true);
                
            if ($account_transaction_id) {
                $post_status->success();
                $post_status->post_status_message = $request->input('transaction_type').' Post Successful';

            }
            else{
                $post_status->failed();
            }
        }
        
        

        $view_data['post_status'] = $post_status->post_status;
        $view_data['post_status_message'] = $post_status->post_status_message;
        return view('accounts_account_post_credit_debits',$view_data);
    }

    public function sageAccount(){
        $unfulfiled_pros = Pro::where('approval_status','APPROVED_NOT_COLLECTED')->get();
        
        $unrecieved_products = [];
        foreach($unfulfiled_pros as $unfulfiled_pro){
            

            

            $product_order_quantity = 0;
            foreach ($unfulfiled_pro->order_snapshot() as $order_product) {
                if(isset($unrecieved_products[$order_product->product_id]))
                {
                    $unrecieved_products[$order_product->product_id]['product_unrecieved_quantity'] += $order_product->product_quantity - $unfulfiled_pro->received_product_quantity($order_product->product_id);
                    $unrecieved_products[$order_product->product_id]['related_orders'][] = $unfulfiled_pro->id;
                    
                }
                else{
                    $unrecieved_products[$order_product->product_id] = [
                        'product_id' => $order_product->product_id,
                        'product_name' => $order_product->product_name,
                        'product_price' => $order_product->product_price,
                        'product_unrecieved_quantity' => $order_product->product_quantity - $unfulfiled_pro->received_product_quantity($order_product->product_id),
                        'related_orders'=>[$unfulfiled_pro->id]
                    ];

                }

            }

            
        }
        $view_data['unrecieved_products'] = $unrecieved_products;
        return view('accounts_sage_account',$view_data);
    }

}
