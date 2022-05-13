<?php

namespace App\Http\Controllers\Custom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Models\Pro;
use App\Models\Prf;
use App\Models\Approval;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\CustomerTransaction;
use App\Models\Warehouse;
use App\Models\WarehouseInventory;
use App\Models\Substore;
use App\Models\SubstoreInventory;
use App\Models\SubstoreStockTransaction;
use App\Models\StockTransfer;


class CommitOrderTransaction 
{
    private function substore_inventoy_item($substore_id , $product_id){
        $substore_inventoy_item = SubstoreInventory::where('substore_id', $substore_id)->where('product_id', $product_id)->first();
        if(!$substore_inventoy_item){
            $substore_inventoy_item = new SubstoreInventory;
            $substore_inventoy_item->quantity = 0;
            $substore_inventoy_item->product_id = $product_id;
            $substore_inventoy_item->substore_id = $substore_id;
            $substore_inventoy_item->save();
            
        }
        return $substore_inventoy_item;
    }
    
    private function warehouse_inventory_item($warehouse_id , $product_id){
        $warehouse_inventoy_item = WarehouseInventory::where('warehouse_id', $warehouse_id)->where('product_id', $product_id)->first();
        if(!$warehouse_inventoy_item){
            $warehouse_inventoy_item = new WarehouseInventory;
            $warehouse_inventoy_item->quantity = 0;
            $warehouse_inventoy_item->product_id = $product_id;
            $warehouse_inventoy_item->warehouse_id = $warehouse_id;
            $warehouse_inventoy_item->save();
            
        }
        return $warehouse_inventoy_item;
    }
    
    
    public function proStockCollection($pro_id,$product_id,$product_quantity,$order_type="PRO"){
        $pro = Pro::find($pro_id);
        $all_general_products = Product::all();
        if($pro->approval_status=="APPROVED_NOT_COLLECTED")
        {
            $transaction_type = "CREDIT";
            DB::beginTransaction();
            try {
                $warehouse_inventory = $this->warehouse_inventory_item($pro->warehouse_id,$product_id);
                //$warehouse_inventory = WarehouseInventory::where('warehouse_id', $pro->warehouse_id)->where('product_id', $product_id)->first();
                $stock_transaction = new StockTransaction;
                    $stock_transaction->product_id = $product_id;
                    $stock_transaction->warehouse_id = $pro->warehouse_id;
                    $stock_transaction->waybill_number =  $pro->waybill_number;
                    $stock_transaction->quantity = $product_quantity;
                    $stock_transaction->order_id = $pro->id;
                    $stock_transaction->order_type = $order_type;
                    $stock_transaction->warehouse_id = $pro->warehouse_id;
                    $stock_transaction->cost_price = $all_general_products->firstWhere('id',$product_id)->cost_price;
                    $stock_transaction->sale_price = $all_general_products->firstWhere('id',$product_id)->cost_price;
                    $stock_transaction->transaction_type = $transaction_type;
                    $stock_transaction->save();
                    
                    if($transaction_type=="CREDIT")
                    {
                        $warehouse_inventory->quantity = $warehouse_inventory->quantity + $product_quantity;
                        $warehouse_inventory->save();
                        $stock_transaction->stock_balance = $warehouse_inventory->quantity;
                        $stock_transaction->save();
                    }
                    elseif($transaction_type=="DEBIT") {
                        $warehouse_inventory->quantity = $warehouse_inventory->quantity - $product_quantity;
                        $warehouse_inventory->save();
                        $stock_transaction->stock_balance = $warehouse_inventory->quantity;
                        $stock_transaction->save();
                    }
                    else {
                        throw $e;
                    }

                    $return_value = true;
                } 
                
                catch (\Exception $e) {
                    DB::rollback();
                    //throw $th;
                    
                    $return_value = false;
                }
                DB::commit();

                return $return_value;
            
        }
        else{
            die("returned approval false");
            return false;
        }
        

    }

    public function stockTransfer($stock_transfer_id,$order_type="STOCK_TRANSFER"){
        Storage::put($stock_transfer_id.'_stock_transfer.lock', '');
       
        $stock_transfer = StockTransfer::find($stock_transfer_id);
        $all_general_products = Product::all();
        if($stock_transfer->approval_status=="APPROVED_NOT_COLLECTED")
        {
            $origin_warehouse =  Warehouse::find($stock_transfer->originating_entity_id);
            $recipient_warehouse =  Warehouse::find($stock_transfer->recieving_entity_id);
            $origin_warehouse_transaction_type = "DEBIT";
            $recipient_warehouse_transaction_type = "CREDIT";
            $stock_transfer_products = $stock_transfer->transfer_snapshot();
            $all_general_products = Product::all();
            $order_type = 'STOCK_TRANSFER';

            DB::beginTransaction();
                try
                {    
                    foreach($stock_transfer_products as $stock_transfer_product)
                    {
                        $origin_warehouse_stock_transaction = new StockTransaction;
                            $origin_warehouse_stock_transaction->product_id = $stock_transfer_product->product_id;
                            $origin_warehouse_stock_transaction->warehouse_id = $stock_transfer->originating_entity_id;
                            $origin_warehouse_stock_transaction->quantity = $stock_transfer_product->product_quantity;
                            $origin_warehouse_stock_transaction->cost_price = $all_general_products->firstWhere('id',$stock_transfer_product->product_id)->cost_price;
                            $origin_warehouse_stock_transaction->sale_price = $stock_transfer_product->product_price;
                            $origin_warehouse_stock_transaction->transaction_type = $origin_warehouse_transaction_type;
                            $origin_warehouse_stock_transaction->order_type = $order_type;

                            $origin_warehouse_stock_transaction->order_id = $stock_transfer->id;
                            
                            $origin_warehouse_stock_transaction->save();


                        $recipient_warehouse_stock_transaction = new StockTransaction;
                            $recipient_warehouse_stock_transaction->product_id = $stock_transfer_product->product_id;
                            $recipient_warehouse_stock_transaction->warehouse_id = $stock_transfer->recieving_entity_id;
                            $recipient_warehouse_stock_transaction->quantity = $stock_transfer_product->product_quantity;
                            $recipient_warehouse_stock_transaction->cost_price = $all_general_products->firstWhere('id',$stock_transfer_product->product_id)->cost_price;
                            $recipient_warehouse_stock_transaction->sale_price = $stock_transfer_product->product_price;
                            $recipient_warehouse_stock_transaction->transaction_type = $recipient_warehouse_transaction_type;
                            $recipient_warehouse_stock_transaction->order_type = $order_type;

                            $recipient_warehouse_stock_transaction->order_id = $stock_transfer->id;
                            
                            $recipient_warehouse_stock_transaction->save();

                            $origin_warehouse_inventory = $this->warehouse_inventory_item($origin_warehouse->id, $stock_transfer_product->product_id);
                            $recipient_warehouse_inventory = $this->warehouse_inventory_item($recipient_warehouse->id, $stock_transfer_product->product_id);
                            //$origin_warehouse_inventory = WarehouseInventory::where('warehouse_id', $prf->warehouse_id)->where('product_id', $stock_transfer_product->product_id)->first();
                            if($origin_warehouse_transaction_type=="CREDIT")
                            {
                                $origin_warehouse_inventory->quantity = $origin_warehouse_inventory->quantity + $stock_transfer_product->product_quantity;
                                $origin_warehouse_inventory->save();

                                $origin_warehouse_stock_transaction->stock_balance = $origin_warehouse_inventory->quantity;
                                $origin_warehouse_stock_transaction->save();

                                //if origin transaction is credir recipent transaction is Debit

                                $recipient_warehouse_inventory->quantity = $recipient_warehouse_inventory->quantity - $stock_transfer_product->product_quantity;
                                $recipient_warehouse_inventory->save();

                                $recipient_warehouse_stock_transaction->stock_balance = $recipient_warehouse_inventory->quantity;
                                $recipient_warehouse_stock_transaction->save();

                               
                            }
                            elseif($origin_warehouse_transaction_type=="DEBIT") {
                                $origin_warehouse_inventory->quantity = $origin_warehouse_inventory->quantity - $stock_transfer_product->product_quantity;
                                $origin_warehouse_inventory->save();

                                $origin_warehouse_stock_transaction->stock_balance = $origin_warehouse_inventory->quantity;
                                $origin_warehouse_stock_transaction->save();

                                //if origin transaction is debit recipent transaction is credit

                                $recipient_warehouse_inventory->quantity = $recipient_warehouse_inventory->quantity + $stock_transfer_product->product_quantity;
                                $recipient_warehouse_inventory->save();

                                $recipient_warehouse_stock_transaction->stock_balance = $recipient_warehouse_inventory->quantity;
                                $recipient_warehouse_stock_transaction->save();
                            }
                            else {
                                throw new \Exception("Unknown trnasaction type");
                            }
                            
                    }
                    //updte new status
                    $stock_transfer->approval_status = "APPROVED_COLLECTED";
                    $stock_transfer->save();
                    
                }
                catch(Throwable $e)
                {
    
                    DB::rollback();
                    $post_status = "FAILED";
                    $post_status_message = "Operation failed";
                    DB::commit();
                    Storage::delete($stock_transfer_id.'_stock_transfer.lock');
                    return false;
                }
                DB::commit();
                Storage::delete($stock_transfer_id.'_stock_transfer.lock');
                return true;
            }
        else{
            //die("returned approval false");
            return false;
        }
        

    }

    //prf payment now exclusively for substore ccustomer account debiting after substore prf
    public function prfPayment($prf_id,$transaction_type,$payment_amount, $payment_comment="", $reference_number=NULL){
        //die("prf payment commmit order trnsaction class");
        $prf = Prf::find($prf_id);
        $customer_payment = new CustomerTransaction;
        $customer = $prf->customer;
            $customer_payment->customer_id = $prf->client_id;
            $customer_payment->comment = $payment_comment;
            $customer_payment->warehouse_id = $prf->warehouse_id;
            $customer_payment->transaction_type = $transaction_type;
            $customer_payment->created_by = Auth::user()->id;
            $customer_payment->amount = $payment_amount; 
            $customer_payment->reference_number = $reference_number;
            $customer_payment->order_id = $prf->id;

            $new_approval_tracker = new Approval; 
            $new_approval_tracker->l0 = Auth::user()->id;
            $new_approval_tracker->l1 = Auth::user()->id;

            $new_approval_tracker->process_type = "CUSTOMER_LODGEMENT";
            $customer_payment->balance = null;
            $customer_payment->current_approval = 'l1';
            $customer_payment->final_approval = 'l1';
            $customer_payment->approval_status = 'CONFIRMED';
            
           


            if($transaction_type=="DEBIT")
            { 
                //add updated balance on apprval confirmation
                $customer_payment->balance = $customer->balance - $payment_amount;
               
                $customer->balance = $customer_payment->balance;
            }
            elseif($transaction_type=="CREDIT")
            {
                //add updated balance on apprval confirmation
                $customer_payment->balance = $customer->balance + $payment_amount;
                $customer->balance = $customer_payment->balance;
            }
            else {
                throw $e;
            }
            DB::beginTransaction();
            try {
                $customer_payment->save();
                $new_approval_tracker->process_id = $customer_payment->id;
                $new_approval_tracker->save();
                $customer->save();
            } catch (\exception $e) {
                DB::rollback;
                throw $e;
                return false;
                die("prf payment commmit order trnsaction class db commit returned false");
            }
            DB::commit();
           return true;
            
    }

    public function prfPaymentReversal($prf_id,$transaction_type,$payment_amount, $payment_comment="", $reference_number="PRF_REVERSAL"){
        //die("prf payment commmit order trnsaction class");
        $prf = Prf::find($prf_id);
        $customer_payment = new CustomerTransaction;
        $customer = $prf->customer;
            $customer_payment->customer_id = $prf->client_id;
            $customer_payment->comment = $payment_comment;
            $customer_payment->warehouse_id = $prf->warehouse_id;
            $customer_payment->transaction_type = $transaction_type;
            $customer_payment->created_by = Auth::user()->id;
            $customer_payment->amount = $payment_amount; 
            $customer_payment->reference_number = $reference_number;
            $customer_payment->order_id = null;

            $new_approval_tracker = new Approval; 
            $new_approval_tracker->l0 = Auth::user()->id;
            $new_approval_tracker->l1 = Auth::user()->id;

            $new_approval_tracker->process_type = "CUSTOMER_LODGEMENT";
            $customer_payment->current_approval = 'l1';
            $customer_payment->final_approval = 'l1';
            $customer_payment->approval_status = 'CONFIRMED';
            
           


            if($transaction_type=="DEBIT")
            { 
                
                $customer_payment->balance = $customer->balance - $payment_amount;
               
                $customer->balance = $customer_payment->balance;
            }
            elseif($transaction_type=="CREDIT")
            {
                
                $customer_payment->balance = $customer->balance + $payment_amount;
                $customer->balance = $customer_payment->balance;
            }
            else {
                throw $e;
            }
            DB::beginTransaction();
            try {
                $customer_payment->save();
                $new_approval_tracker->process_id = $customer_payment->id;
                $new_approval_tracker->save();
                $customer->save();
            } catch (exceprion $e) {
                DB::rollback;
                throw $e;
                return false;
                die("prf payment commmit order trnsaction class db commit returned false");
            }
            DB::commit();
           return true;
            
    }

    public function prfStockCollectionAccountTransaction($prf_id,$transaction_type,$payment_amount, $payment_comment="", $reference_number=NULL){
        //die("prf payment commmit order trnsaction class");
        $prf = Prf::find($prf_id);
        $customer_payment = new CustomerTransaction;
        $customer = $prf->customer;
            $customer_payment->customer_id = $prf->client_id;
            $customer_payment->comment = $payment_comment;
            $customer_payment->warehouse_id = $prf->warehouse_id;
            $customer_payment->transaction_type = $transaction_type;
            $customer_payment->created_by = $prf->sales_rep;
            $customer_payment->amount = $payment_amount; 
            $customer_payment->reference_number = $reference_number;
            $customer_payment->order_id = $prf->id;

            // $new_approval_tracker = new Approval; 
            // $new_approval_tracker->l0 = Auth::user()->id;

            // $new_approval_tracker->process_type = "CUSTOMER_LODGEMENT";
            // $customer_payment->balance = null;
            // $customer_payment->current_approval = 'l0';
            // $customer_payment->final_approval = 'l1';
            // $customer_payment->approval_status = 'NOT_CONFIRMED';
            
           


            if($transaction_type=="DEBIT")
            { 
               
                $customer_payment->balance = $customer->balance - $payment_amount;
               
                $customer->balance = $customer_payment->balance;
            }
            elseif($transaction_type=="CREDIT")
            {
                
                $customer_payment->balance = $customer->balance + $payment_amount;
                $customer->balance = $customer_payment->balance;
            }
            else {
                throw $e;
            }
            DB::beginTransaction();
            try {
                $customer_payment->save();
                
                $customer->save();
            } catch (exceprion $e) {
                DB::rollback;
                throw $e;
                return false;
               // die("prf payment commmit order trnsaction class db commit returned false");
            }
            DB::commit();
           return true;
            
    }

    public function prfStockCollectionAccountTransactionReversal($prf_id,$transaction_type,$payment_amount, $payment_comment="", $reference_number="PRF_REVERSAL"){
        //die("prf payment commmit order trnsaction class");
        $prf = Prf::find($prf_id);
        $customer_payment = new CustomerTransaction;
        $customer = $prf->customer;
            $customer_payment->customer_id = $prf->client_id;
            $customer_payment->comment = $payment_comment;
            $customer_payment->warehouse_id = $prf->warehouse_id;
            $customer_payment->transaction_type = $transaction_type;
            $customer_payment->created_by = $prf->sales_rep;
            $customer_payment->amount = $payment_amount; 
            $customer_payment->reference_number = $reference_number;
            $customer_payment->order_id = null;

            $new_approval_tracker = new Approval; 
            $new_approval_tracker->l0 = Auth::user()->id;
            $new_approval_tracker->l1 = Auth::user()->id;

            $new_approval_tracker->process_type = "CUSTOMER_LODGEMENT";
            $customer_payment->balance = null;
            $customer_payment->current_approval = 'l1';
            $customer_payment->final_approval = 'l1';
            $customer_payment->approval_status = 'CONFIRMED';
            
           


            if($transaction_type=="DEBIT")
            { 
               
                $customer_payment->balance = $customer->balance - $payment_amount;
               
                $customer->balance = $customer_payment->balance;
            }
            elseif($transaction_type=="CREDIT")
            {
                
                $customer_payment->balance = $customer->balance + $payment_amount;
                $customer->balance = $customer_payment->balance;
            }
            else {
                throw $e;
            }
            DB::beginTransaction();
            try {
                $customer_payment->save();
                
                $customer->save();
            } catch (exceprion $e) {
                DB::rollback;
                throw $e;
                return false;
               // die("prf payment commmit order trnsaction class db commit returned false");
            }
            DB::commit();
           return true;
            
    }

    public function customerPayment($customer, $transaction_type,$payment_amount, $payment_comment="", $reference_number=NULL){
        
        $customer_payment = new CustomerTransaction;
        
            $customer_payment->customer_id = $customer->id;
            $customer_payment->comment = $payment_comment;
            $customer_payment->transaction_type = $transaction_type;
            $customer_payment->created_by = Auth::user()->id;
            $customer_payment->amount = $payment_amount; 
            $customer_payment->reference_number = $reference_number;
            $customer_payment->order_id = null;

            $new_approval_tracker = new Approval; 
            $new_approval_tracker->l0 = Auth::user()->id;
            $new_approval_tracker->process_type = "CUSTOMER_LODGEMENT";

            $customer_payment->balance = null;
            $customer_payment->current_approval = 'l0';
            $customer_payment->final_approval = 'l1';
            $customer_payment->approval_status = 'NOT_CONFIRMED';

            if($transaction_type=="DEBIT")
            {
                // $customer_payment->balance = $customer->balance - $payment_amount;
                // $customer->balance = $customer_payment->balance;
            }
            elseif($transaction_type=="CREDIT")
            {
                // $customer_payment->balance = $customer->balance + $payment_amount;
                // $customer->balance = $customer_payment->balance;
            }
            else {
                throw $e;
            }
            DB::beginTransaction();
            try {
                $customer_payment->save();
                $new_approval_tracker->process_id = $customer_payment->id;
                $new_approval_tracker->save();
                //$customer->save();
            } catch (exceprion $e) {
                DB::rollback;
                throw $e;
                return false;
                //die("prf payment commmit order trnsaction class db commit returned false");
            }
            DB::commit();
           return $customer_payment->id;
            
    }

    public function substoreLodgementCustomerPayment($customer, $transaction_type,$payment_amount, $payment_comment="", $reference_number=NULL){
        
        $customer_payment = new CustomerTransaction;
        
            $customer_payment->customer_id = $customer->id;
            $customer_payment->comment = $payment_comment;
            $customer_payment->transaction_type = $transaction_type;
            $customer_payment->created_by = Auth::user()->id;
            $customer_payment->amount = $payment_amount; 
            $customer_payment->reference_number = $reference_number;
            $customer_payment->order_id = null;

            $new_approval_tracker = new Approval; 
            $new_approval_tracker->l0 = Auth::user()->id;
            $new_approval_tracker->l1 = Auth::user()->id;
            $new_approval_tracker->process_type = "CUSTOMER_LODGEMENT";

            $customer_payment->balance = null;
            $customer_payment->current_approval = 'l1';
            $customer_payment->final_approval = 'l1';
            $customer_payment->approval_status = 'CONFIRMED';

            if($transaction_type=="DEBIT")
            {
                $customer_payment->balance = $customer->balance - $payment_amount;
                $customer->balance = $customer_payment->balance;
            }
            elseif($transaction_type=="CREDIT")
            {
                $customer_payment->balance = $customer->balance + $payment_amount;
                $customer->balance = $customer_payment->balance;
            }
            else {
                throw $e;
            }
            DB::beginTransaction();
            try {
                $customer_payment->save();
                $new_approval_tracker->process_id = $customer_payment->id;
                $new_approval_tracker->save();
                //$customer->save();
            } catch (exceprion $e) {
                DB::rollback;
                throw $e;
                return false;
                //die("prf payment commmit order trnsaction class db commit returned false");
            }
            DB::commit();
           return $customer_payment->id;
            
    }

    public function prfStockCollection($prf_id){
        Storage::put($prf_id.'_prf_stock_collection.lock', '');
        //Collection of order itmems from store keeper
        $prf =  Prf::find($prf_id);
        $order_type="PRF";
        $customer = $prf->customer;
        //die ($customer);
        if($prf->approval_status=="APPROVED_NOT_COLLECTED")
        {
            //internal customers(substations and lube bays)
            if($prf->client_type==2 || $prf->client_type==3 )
            {
                $transaction_type = "DEBIT";
                $substore_transaction_type = "CREDIT";
                $order_products = json_decode($prf->order_snapshot);
                $all_general_products = Product::all();

                DB::beginTransaction();
                    try
                    {    
                        foreach($order_products as $order_product)
                        {
                            $stock_transaction = new StockTransaction;
                                $stock_transaction->product_id = $order_product->product_id;
                                $stock_transaction->warehouse_id = $prf->warehouse_id;
                                //may not be necessary for deliveries
                                //$stock_transaction->waybill_number = $waybill_number;
                                $stock_transaction->quantity = $order_product->product_quantity;
                                $stock_transaction->cost_price = $all_general_products->firstWhere('id',$order_product->product_id)->cost_price;
                                $stock_transaction->sale_price = $order_product->product_price;
                                $stock_transaction->transaction_type = $transaction_type;
                                
                                $stock_transaction->order_id = $prf->id;
                                $stock_transaction->order_type = $order_type;
                                $stock_transaction->save();
                            $substore_stock_transaction = new SubstoreStockTransaction;
                                $substore_stock_transaction->product_id = $order_product->product_id;
                                $substore_stock_transaction->substore_id = $prf->customer->substore->id;
                                $substore_stock_transaction->transaction_id = $prf->transaction_id;
                                //may not be necessary for deliveries
                                //$substore_stock_transaction->waybill_number = $waybill_number;
                                $substore_stock_transaction->quantity = $order_product->product_quantity;
                                $substore_stock_transaction->cost_price = $all_general_products->firstWhere('id',$order_product->product_id)->cost_price;
                                $substore_stock_transaction->sale_price = $order_product->product_price;
                                $substore_stock_transaction->transaction_type = $substore_transaction_type;
                                $substore_stock_transaction->user_id = $prf->sales_rep;
                                $substore_stock_transaction->save();

                                $warehouse_inventory = $this->warehouse_inventory_item($prf->warehouse_id, $order_product->product_id);
                                //$warehouse_inventory = WarehouseInventory::where('warehouse_id', $prf->warehouse_id)->where('product_id', $order_product->product_id)->first();
                                if($transaction_type=="CREDIT")
                                {
                                    $warehouse_inventory->quantity = $warehouse_inventory->quantity + $order_product->product_quantity;
                                    $warehouse_inventory->save();

                                    $stock_transaction->stock_balance = $warehouse_inventory->quantity;
                                    $stock_transaction->save();

                                   
                                }
                                elseif($transaction_type=="DEBIT") {
                                    $warehouse_inventory->quantity = $warehouse_inventory->quantity - $order_product->product_quantity;
                                    $warehouse_inventory->save();

                                    $stock_transaction->stock_balance = $warehouse_inventory->quantity;
                                    $stock_transaction->save();
                                }
                                else {
                                    throw new \Exception("Unknown trnasaction type");
                                }
                                $substore_inventory = $this->substore_inventoy_item($customer->substore->id, $order_product->product_id);
                                //$substore_inventory = SubstoreInventory::where('substore_id', $customer->substore->id)->where('product_id', $order_product->product_id)->first();
                                if($substore_transaction_type=="CREDIT")
                                {
                                    $substore_inventory->quantity = $substore_inventory->quantity + $order_product->product_quantity;
                                    $substore_inventory->save();

                                    $substore_stock_transaction->stock_balance = $substore_inventory->quantity;
                                    $substore_stock_transaction->save();
                                }
                                elseif($substore_transaction_type=="DEBIT") {
                                    $substore_inventory->quantity = $substore_inventory->quantity - $order_product->product_quantity;
                                    $substore_inventory->save();
                                    
                                    $substore_stock_transaction->stock_balance = $substore_inventory->quantity;
                                    $substore_stock_transaction->save();
                                }
                                else {
                                    throw $e;
                                }
                        }
                        //updte new status
                        $prf->approval_status = "APPROVED_COLLECTED";
                        $prf->save();
                        //Debit Cutomer Account
                        $this->prfPayment($prf->id,$transaction_type,$prf->order_total,"Order Collected");
            
                    }
                    catch(\Exception $e)
                    {
        
                        DB::rollback();
                        $post_status = "FAILED";
                        $post_status_message = "Operation failed";
                        DB::commit();
                        Storage::delete($prf_id.'_prf_stock_collection.lock');
                        return false;
                    }
                    DB::commit();
                    Storage::delete($prf_id.'_prf_stock_collection.lock');
                    return true;
            }
            else{
                $transaction_type = "DEBIT";
                $order_products = json_decode($prf->order_snapshot);
                $all_general_products = Product::all();

                DB::beginTransaction();
                    try
                    {    
                        foreach($order_products as $order_product)
                        {
                            $stock_transaction = new StockTransaction;
                                $stock_transaction->product_id = $order_product->product_id;
                                $stock_transaction->warehouse_id = $prf->warehouse_id;
                                //may not be necessary for deliveries
                                //$stock_transaction->waybill_number = $waybill_number;
                                $stock_transaction->quantity = $order_product->product_quantity;
                                $stock_transaction->cost_price = $all_general_products->firstWhere('id',$order_product->product_id)->cost_price;
                                $stock_transaction->sale_price = $order_product->product_price;
                                $stock_transaction->transaction_type = $transaction_type;
                                $stock_transaction->order_type = "PRF";
                                $stock_transaction->order_id = $prf->id;
                                $stock_transaction->save();
                        
                                $warehouse_inventory = WarehouseInventory::where('warehouse_id', $prf->warehouse_id)->where('product_id', $order_product->product_id)->first();
                                if($transaction_type=="CREDIT")
                                {
                                    $warehouse_inventory->quantity = $warehouse_inventory->quantity + $order_product->product_quantity;
                                    $warehouse_inventory->save();

                                    
                                    $stock_transaction->stock_balance = $warehouse_inventory->quantity;
                                    $stock_transaction->save();
                                }
                                elseif($transaction_type=="DEBIT") {
                                    $warehouse_inventory->quantity = $warehouse_inventory->quantity - $order_product->product_quantity;
                                    $warehouse_inventory->save();

                                    $stock_transaction->stock_balance = $warehouse_inventory->quantity;
                                    $stock_transaction->save();
                                }
                                else {
                                    throw new \Exception('transaction is neither credit nor debit');
                                }
                        }
                        //updte new status
                        $prf->approval_status = "APPROVED_COLLECTED";
                        $prf->save();
                        //Debit Cutomer Account
                        $this->prfStockCollectionAccountTransaction($prf->id,$transaction_type,$prf->order_total,"Order Collected");
            
                    }
                    catch(\Exception $e)
                    {
        
                        DB::rollback();
                        $post_status = "FAILED";
                        $post_status_message = "Operation failed";
                        DB::commit();
                        Storage::delete($prf_id.'_prf_stock_collection.lock');
                        return false;
                    }
                    DB::commit();
                    Storage::delete($prf_id.'_prf_stock_collection.lock');
                    return true;
            }
            

        }
        Storage::delete($prf_id.'_prf_stock_collection.lock');
        return false;
        
        
    }

    public function prfStockCollectionReversal($prf_id){

        //Collection of order itmems from store keeper
        $prf =  Prf::find($prf_id);
        $order_type="PRF_REVERSAL";
        $customer = $prf->customer;
        //die ($customer);
        if($prf->approval_status=="APPROVED_COLLECTED")
        {
            //internal customers(substations and lube bays)
            if($prf->client_type==2 || $prf->client_type==3 )
            {
                $transaction_type = "CREDIT";
                $substore_transaction_type = "DEBIT";
                $order_products = json_decode($prf->order_snapshot);
                $all_general_products = Product::withTrashed()->get();

                DB::beginTransaction();
                    try
                    {    
                        foreach($order_products as $order_product)
                        {
                            $stock_transaction = new StockTransaction;
                                $stock_transaction->product_id = $order_product->product_id;
                                $stock_transaction->warehouse_id = $prf->warehouse_id;
                                //may not be necessary for deliveries
                                //$stock_transaction->waybill_number = $waybill_number;
                                $stock_transaction->quantity = $order_product->product_quantity;
                                $stock_transaction->cost_price = $all_general_products->firstWhere('id',$order_product->product_id)->cost_price;
                                $stock_transaction->sale_price = $order_product->product_price;
                                $stock_transaction->transaction_type = $transaction_type;
                                
                                $stock_transaction->order_id = null;
                                $stock_transaction->order_type = $order_type;
                                $stock_transaction->save();
                            $substore_stock_transaction = new SubstoreStockTransaction;
                                $substore_stock_transaction->product_id = $order_product->product_id;
                                $substore_stock_transaction->substore_id = $prf->customer->substore->id;
                                $substore_stock_transaction->transaction_id = "REV-".$prf->transaction_id;
                                //may not be necessary for deliveries
                                //$substore_stock_transaction->waybill_number = $waybill_number;
                                $substore_stock_transaction->quantity = $order_product->product_quantity;
                                $substore_stock_transaction->cost_price = $all_general_products->firstWhere('id',$order_product->product_id)->cost_price;
                                $substore_stock_transaction->sale_price = $order_product->product_price;
                                $substore_stock_transaction->transaction_type = $substore_transaction_type;
                                $substore_stock_transaction->user_id = $prf->sales_rep;
                                $substore_stock_transaction->save();

                                $warehouse_inventory = $this->warehouse_inventory_item($prf->warehouse_id, $order_product->product_id);
                                //$warehouse_inventory = WarehouseInventory::where('warehouse_id', $prf->warehouse_id)->where('product_id', $order_product->product_id)->first();
                                if($transaction_type=="CREDIT")
                                {
                                    $warehouse_inventory->quantity = $warehouse_inventory->quantity + $order_product->product_quantity;
                                    $warehouse_inventory->save();

                                    $stock_transaction->stock_balance = $warehouse_inventory->quantity;
                                    $stock_transaction->save();

                                   
                                }
                                elseif($transaction_type=="DEBIT") {
                                    $warehouse_inventory->quantity = $warehouse_inventory->quantity - $order_product->product_quantity;
                                    $warehouse_inventory->save();

                                    $stock_transaction->stock_balance = $warehouse_inventory->quantity;
                                    $stock_transaction->save();
                                }
                                else {
                                    throw new \Exception('transaction is neither credit nor debit');
                                }
                                $substore_inventory = $this->substore_inventoy_item($customer->substore->id, $order_product->product_id);
                                //$substore_inventory = SubstoreInventory::where('substore_id', $customer->substore->id)->where('product_id', $order_product->product_id)->first();
                                if($substore_transaction_type=="CREDIT")
                                {
                                    $substore_inventory->quantity = $substore_inventory->quantity + $order_product->product_quantity;
                                    $substore_inventory->save();

                                    $substore_stock_transaction->stock_balance = $substore_inventory->quantity;
                                    $substore_stock_transaction->save();
                                }
                                elseif($substore_transaction_type=="DEBIT") {
                                    $substore_inventory->quantity = $substore_inventory->quantity - $order_product->product_quantity;
                                    $substore_inventory->save();
                                    
                                    $substore_stock_transaction->stock_balance = $substore_inventory->quantity;
                                    $substore_stock_transaction->save();
                                }
                                else {
                                    throw new \Exception('transaction is neither credit nor debit');
                                }
                        }
                        //on reversal no need for status updates    
                        //$prf->approval_status = "APPROVED_COLLECTED";
                        //$prf->save();
                        //Debit Cutomer Account
                        $this->prfPaymentReversal($prf->id,$transaction_type,$prf->order_total,"PRF_REVERSAL");
            
                    }
                    catch(\Exception $e)
                    {
        
                        DB::rollback();
                        $post_status = "FAILED";
                        $post_status_message = "Operation failed";
                        DB::commit();
                        throw new \Exception('transaction is neither credit nor debit');
                        return false;
                    }
                    DB::commit();
                    return true;
            }
            else{
                $transaction_type = "CREDIT";
                $order_products = json_decode($prf->order_snapshot);
                $all_general_products = Product::withTrashed()->get();

                DB::beginTransaction();
                    try
                    {    
                        foreach($order_products as $order_product)
                        {
                            $stock_transaction = new StockTransaction;
                                $stock_transaction->product_id = $order_product->product_id;
                                $stock_transaction->warehouse_id = $prf->warehouse_id;
                                //may not be necessary for deliveries
                                //$stock_transaction->waybill_number = $waybill_number;
                                $stock_transaction->quantity = $order_product->product_quantity;
                                $stock_transaction->cost_price = $all_general_products->firstWhere('id',$order_product->product_id)->cost_price;
                                $stock_transaction->sale_price = $order_product->product_price;
                                $stock_transaction->transaction_type = $transaction_type;
                                $stock_transaction->order_type = $order_type;
                                $stock_transaction->order_id = null;
                                $stock_transaction->save();
                        
                                $warehouse_inventory = WarehouseInventory::where('warehouse_id', $prf->warehouse_id)->where('product_id', $order_product->product_id)->first();
                                if($transaction_type=="CREDIT")
                                {
                                    $warehouse_inventory->quantity = $warehouse_inventory->quantity + $order_product->product_quantity;
                                    $warehouse_inventory->save();

                                    
                                    $stock_transaction->stock_balance = $warehouse_inventory->quantity;
                                    $stock_transaction->save();
                                }
                                elseif($transaction_type=="DEBIT") {
                                    $warehouse_inventory->quantity = $warehouse_inventory->quantity - $order_product->product_quantity;
                                    $warehouse_inventory->save();

                                    $stock_transaction->stock_balance = $warehouse_inventory->quantity;
                                    $stock_transaction->save();
                                }
                                else {
                                    throw new \Exception('an error occured');
                                }
                        }
                        //on reversal no need for status updates    
                        //$prf->approval_status = "APPROVED_COLLECTED";
                        //$prf->save();

                        //Debit Cutomer Account
                        $this->prfStockCollectionAccountTransactionReversal($prf->id,$transaction_type,$prf->order_total,"PRF_REVERSAL");
            
                    }
                    catch(\Exception $e)
                    {
        
                        DB::rollback();
                        $post_status = "FAILED";
                        $post_status_message = "Operation failed";
                        throw new \Exception('transaction is neither credit nor debit');
                        return false;
                    }
                    DB::commit();
                    return true;
            }
            

        }
        return false;
        
        
    }

    public function warehouseStockAdjustment($warehouse_id, $product_id, $quantity, $transaction_type ){
        $product = Product::find($product_id);
        DB::beginTransaction();
        try {
             
            $new_warehouse_stock_transaction = new StockTransaction;
                $new_warehouse_stock_transaction->warehouse_id = $warehouse_id;
                $new_warehouse_stock_transaction->order_id = null;
                $new_warehouse_stock_transaction->order_type = "INV-ADJ";
                $new_warehouse_stock_transaction->product_id = $product_id;
                $new_warehouse_stock_transaction->cost_price = $product->cost_price;
                $new_warehouse_stock_transaction->sale_price = $product->productPrice(2);
                $new_warehouse_stock_transaction->quantity = $quantity;
                $new_warehouse_stock_transaction->transaction_type = $transaction_type;
                //$new_warehouse_stock_transaction->user_id = Auth::user()->id;;
                $new_warehouse_stock_transaction->save();

                $warehouse_inventory = $this->warehouse_inventory_item($warehouse_id, $product_id);
                if($transaction_type=="CREDIT")
                {
                    $warehouse_inventory->quantity = $warehouse_inventory->quantity + $quantity;
                    $warehouse_inventory->save();

                    $new_warehouse_stock_transaction->stock_balance = $warehouse_inventory->quantity;
                    $new_warehouse_stock_transaction->save();
                }
                elseif($transaction_type=="DEBIT") {
                    $warehouse_inventory->quantity = $warehouse_inventory->quantity - $quantity;
                    $warehouse_inventory->save();
                    
                    $new_warehouse_stock_transaction->stock_balance = $warehouse_inventory->quantity;
                    $new_warehouse_stock_transaction->save();
                }
                else {
                    throw new \Exception("Unknown trnasaction type");
                }


        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
            return false;
            DB::commit();
        }
        DB::commit();
        return true;



        


    }


}
