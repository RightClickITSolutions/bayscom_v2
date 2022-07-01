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
use App\Models\Lubebay;
use App\Models\LubebayServiceTransaction;
use App\Models\LubebayTransaction;

use App\Models\CustomerTransaction;
use App\Models\WarehouseInventory;

class CommitLubebayTransaction {

     /**
       * 
       * Commits lubebay cash/moeny transactions a tranasaction 
       *
       * @param string $process_type  type of process (LST_LODGMENT/EXPENSE/..etc)
       * @param string $process_id  Process ID of process
       * @param integer $lubebay_id  lubebay id
       * @param integer $transaction_type  CREDIT/DEBIT
       * @param string $transaction_amount  transaction amount
       * @param string $payment_comment  comment on transaction
       * @param string $bank_reference  bank ref/teller no
       * @return boolean
       */
    public function lubebayTransaction($process_type,$process_id,$lubebay_id,$transaction_type,$transaction_amount,$payment_comment="",$bank_reference=""){

        $transaction_type = "DEBIT";
        DB::beginTransaction();
        try {
            //code...
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
        DB::commit(); 
        
            
                $new_lubebay_transaction = new LubebayTransaction;
                $new_lubebay_transaction->lubebay_id = $lubebay_id;
                $new_lubebay_transaction->bank_reference = $bank_reference;
                $new_lubebay_transaction->process_type = $process_type;
                $new_lubebay_transaction->process_id= $process_id;
                $new_lubebay_transaction->comment = $payment_comment;
                $new_lubebay_transaction->amount = $transaction_amount;
                $new_lubebay_transaction->transaction_type = $transaction_type;
                $new_lubebay_transaction->user_id = Auth::user()->id;
                $new_lubebay_transaction->save();
                
                

        

        
        return true;
        
            
    }

    public function lubebayServicesPayments($lst_id,$transaction_type,$payment_amount, $payment_comment=""){
        //die("prf payment commmit order trnsaction class");
        $lubebay_service_transaction = LubebayServiceTransaction::find($lubebay_transction_id);
        
        
            $new_lubebay_transaction = new LubebayTransaction;
                $new_lubebay_transaction->lubebay_id = $lubebay_service_transaction->lubebay_id;
                $new_lubebay_transaction->transaction_id = $lubebay_service_transaction->id;
                $new_lubebay_transaction->process_type = $process_type;
                $new_lubebay_transaction->process_id= $lubebay_service_transaction->id;
                //$new_lubebay_transaction->lst_id = $lubebay_service_transaction->id;
                $new_lubebay_transaction->amount = $lubebay_service_transaction->total_amount;
                $new_lubebay_transaction->transaction_type = $transaction_type;
                $new_lubebay_transaction->user_id = Auth::user()->id;
                $new_lubebay_transaction->save();
            
    }
}