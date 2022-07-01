<?php

namespace App\Http\Controllers\Custom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use App\Models\Pro;
use App\Models\Prf;
use App\Models\Approval;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\CustomerTransaction;
use App\Models\WarehouseInventory;
use App\Models\Substore;
use App\Models\SubstoreInventory;
use App\Models\SubstoreStockTransaction;

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
                
                catch (Exception $e) {
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
    public function prfPayment($prf_id,$transaction_type,$payment_amount, $payment_comment="", $reference_number=NULL){
        //die("prf payment commmit order trnsaction class");
        $prf = Prf::find($prf_id);
        $customer_payment = new CustomerTransaction;
        $customer = $prf->customer;
            $customer_payment->customer_id = $prf->client_id;
            $customer_payment->comment = $payment_comment;
            $customer_payment->warehouse_id = $prf->warehouse_id;
            $customer_payment->transaction_type = $transaction_type;
            $customer_payment->amount = $payment_amount; 
            $customer_payment->reference_number = $reference_number;
            $customer_payment->order_id = $prf->id;
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
                die("prf payment commmit order trnsaction class db commit returned false");
            }
            DB::commit();
           return true;
            
    }

    public function customerPayment($customer, $transaction_type,$payment_amount, $payment_comment="", $reference_number=NULL){
        
        $customer_payment = new CustomerTransaction;
        
            $customer_payment->customer_id = $customer->id;
            $customer_payment->comment = $payment_comment;
            $customer_payment->transaction_type = $transaction_type;
            $customer_payment->amount = $payment_amount; 
            $customer_payment->reference_number = $reference_number;
            $customer_payment->order_id = null;
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
                //die("prf payment commmit order trnsaction class db commit returned false");
            }
            DB::commit();
           return $customer_payment->id;
            
    }

    public function prfStockCollection($prf_id){
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

                                   
                                }
                                elseif($transaction_type=="DEBIT") {
                                    $warehouse_inventory->quantity = $warehouse_inventory->quantity - $order_product->product_quantity;
                                    $warehouse_inventory->save();
                                    
                                }
                                else {
                                    throw $e;
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
                    catch(Exception $e)
                    {
        
                        DB::rollback();
                        $post_status = "FAILED";
                        $post_status_message = "Operation failed";
                        DB::commit();
                        throw $e;
                        return false;
                    }
                    DB::commit();
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
                                }
                                elseif($transaction_type=="DEBIT") {
                                    $warehouse_inventory->quantity = $warehouse_inventory->quantity - $order_product->product_quantity;
                                    $warehouse_inventory->save();
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
                    catch(Exception $e)
                    {
        
                        DB::rollback();
                        $post_status = "FAILED";
                        $post_status_message = "Operation failed";
                        throw $e;
                        return false;
                    }
                    DB::commit();
                    return true;
            }
            

        }
        return false;
        
        
    }
}
