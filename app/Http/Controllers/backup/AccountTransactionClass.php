<?php

namespace App\Http\Controllers\Custom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use App\Models\Pro;
use App\Models\Prf;
use App\Models\Approval;
use App\Models\StockTransaction;
use App\Models\Substore;
use App\Models\SubstoreInventory;
use App\Models\SubstoreTransaction;
use App\Models\SubstoreStockTransaction;

use App\Models\CustomerTransaction;
use App\Models\WarehouseInventory;
use App\Models\Account;
use App\Models\AccountTransaction;


class AccountTransactionClass {


     /**
       * 
       * Commits lubebay cash/moeny transactions a tranasaction 
       *
       * @param string $process_type  type of process (LST_LODGMENT/EXPENSE/..etc)
       * @param string $process_id  Process ID of process
       * @param integer $account_id  lubebay id
       * @param integer $transaction_type  CREDIT/DEBIT
       * @param string $transaction_amount  transaction amount
       * @param string $payment_comment  comment on transaction
       * @param string $bank_reference  bank ref/teller no
       * @return boolean
       */
      public function new_transaction($account_id, $related_process, $related_process_id,$transaction_type,$transaction_amount,$payment_comment="",$bank_reference="", $approved=false){
        $account = Account::find($account_id);
        
        DB::beginTransaction();
        try {
            
                $new_account_transaction = new AccountTransaction;
                $new_account_transaction->account_id = $account_id;
                $new_account_transaction->comment = $payment_comment;
                $new_account_transaction->amount = $transaction_amount;
                $new_account_transaction->user_id = Auth::user()->id;
                $new_account_transaction->related_process = $related_process;
                $new_account_transaction->transaction_type = $transaction_type;
                $new_account_transaction->related_process_id = $related_process_id;
                $new_account_transaction->bank_reference = $bank_reference;

                $new_approval_tracker = new Approval;
                $new_approval_tracker->process_type = "ACCOUNT_TRANSACTION";

                if ($approved==true) {
                    $new_account_transaction->current_approval = 'l1';
                    $new_account_transaction->final_approval = 'l1';
                    $new_account_transaction->approval_status = 'CONFIRMED';
                    
                    $new_approval_tracker->l0 = Auth::user()->id;
                    $new_approval_tracker->l1 = Auth::user()->id;

                    if ($transaction_type == 'CREDIT') {
                        $account->balance += $transaction_amount;
                    }
                    elseif ($transaction_type == 'DEBIT') {
                        $account->balance -= $transaction_amount;
                    }
                    else{
                        throw new Exception('invalid transaction_type');
                    }
                    $new_account_transaction->balance = $account->balance;
                
                    
                }else{
                    $new_account_transaction->balance = null;
                    $new_account_transaction->current_approval = 'l0';
                    $new_account_transaction->final_approval = 'l1';
                    $new_account_transaction->approval_status = 'NOT_CONFIRMED';
                    
                    $new_approval_tracker->l0 = Auth::user()->id;
                }
                 
                $new_account_transaction->save();
                $account->save();
                $new_approval_tracker->process_id = $new_account_transaction->id;
                $new_approval_tracker->save();
                

                
                
                
        } catch (Exception $e) {
            DB::rollback(); 
            DB::commit(); 
            return false;
            throw $e;
        }
       
        DB::commit(); 
        
        return $new_account_transaction->id;
        
            
    }

    private function substore_inventory_item($substore_id , $product_id){
        $substore_inventoy_item = SubstoreInventory::where('substore_id', $substore_id)->where('product_id', $product_id)->first();
        if(!$substore_inventoy_item->count()){
            $substore_inventoy_item = new SubstoreInventory;
            $substore_inventoy_item->qauntity = 0;
            $substore_inventoy_item->product_id = $product_id;
            $substore_inventoy_item->substore_id = $substore_id;
            $substore_inventoy_item->save();
            
        }
        return $substore_inventoy_item;
    }

    public function stockTransaction($substore_transction_id,$transaction_type){

        $transaction_type = "DEBIT";
        DB::beginTransaction();
        try {
            //code...
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
        DB::commit();
        $substore_transaction = SubstoreTransaction::find($substore_transction_id);
        $transaction_products = json_decode($substore_transaction->sales_snapshot);
        $all_general_products = Product::all();
        foreach($transaction_products as $transaction_product ){
            $new_substore_stock_transaction = new SubstoreStockTransaction;
                $new_substore_stock_transaction->substore_id = $substore_transaction->substore_id;
                $new_substore_stock_transaction->transaction_id = $substore_transaction->id;
                $new_substore_stock_transaction->product_id = $transaction_product->product_id;
                $new_substore_stock_transaction->cost_price = $all_general_products->firstWhere('id',$transaction_product->product_id)->cost_price;
                $new_substore_stock_transaction->sale_price = $transaction_product->product_price;
                $new_substore_stock_transaction->quantity = $transaction_product->product_quantity;
                $new_substore_stock_transaction->transaction_type = $transaction_type;
                $new_substore_stock_transaction->user_id = $substore_transaction->user_id;
                $new_substore_stock_transaction->save();

                $substore_inventory = $this->substore_inventory_item($substore_transaction->substore_id, $transaction_product->product_id);
                if($transaction_type=="CREDIT")
                {
                    $substore_inventory->quantity = $substore_inventory->quantity + $transaction_product->product_quantity;
                    $substore_inventory->save();
                }
                elseif($transaction_type=="DEBIT") {
                    $substore_inventory->quantity = $substore_inventory->quantity - $transaction_product->product_quantity;
                    $substore_inventory->save();
                }
                else {
                    throw $e;
                }

        }
        return true;
        
            
    }
}