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
use App\Models\Product;
use App\Models\CustomerTransaction;
use App\Models\WarehouseInventory;

class CommitSubstoreTransaction {

    private function substore_inventory_item($substore_id , $product_id){
        $substore_inventoy_item = SubstoreInventory::where('substore_id', $substore_id)->where('product_id', $product_id)->first();
        if($substore_inventoy_item == null){
            $substore_inventoy_item = new SubstoreInventory;
            $substore_inventoy_item->quantity = 0;
            $substore_inventoy_item->product_id = $product_id;
            $substore_inventoy_item->substore_id = $substore_id;
            $substore_inventoy_item->save();
            
        }
        return $substore_inventoy_item;
    }

    public function stockTransaction($substore_transction_id,$transaction_type = "DEBIT"){

        
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

                    $new_substore_stock_transaction->stock_balance = $substore_inventory->quantity;
                    $new_substore_stock_transaction->save();
                }
                elseif($transaction_type=="DEBIT") {
                    $substore_inventory->quantity = $substore_inventory->quantity - $transaction_product->product_quantity;
                    $substore_inventory->save();
                    
                    $new_substore_stock_transaction->stock_balance = $substore_inventory->quantity;
                    $new_substore_stock_transaction->save();
                }
                else {
                    throw $e;
                }

        }
        return true;
        
            
    }

    public function sstStockTransactionReversal($substore_transction_id,$transaction_type = "DEBIT"){

        
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
                $new_substore_stock_transaction->transaction_id = 'SST_REV-'.$substore_transaction->id;
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

                    $new_substore_stock_transaction->stock_balance = $substore_inventory->quantity;
                    $new_substore_stock_transaction->save();
                }
                elseif($transaction_type=="DEBIT") {
                    $substore_inventory->quantity = $substore_inventory->quantity - $transaction_product->product_quantity;
                    $substore_inventory->save();
                    
                    $new_substore_stock_transaction->stock_balance = $substore_inventory->quantity;
                    $new_substore_stock_transaction->save();
                }
                else {
                    throw $e;
                }

        }
        return true;
        
            
    }

    public function substoreStockAdjustment($substore_id, $product_id, $quantity, $transaction_type ){
        $product = Product::find($product_id);
        DB::beginTransaction();
        try {
             
            $new_substore_stock_transaction = new SubstoreStockTransaction;
                $new_substore_stock_transaction->substore_id = $substore_id;
                $new_substore_stock_transaction->transaction_id = "INV-ADJ";
                $new_substore_stock_transaction->product_id = $product_id;
                $new_substore_stock_transaction->cost_price = $product->cost_price;
                $new_substore_stock_transaction->sale_price = $product->productPrice(2);
                $new_substore_stock_transaction->quantity = $quantity;
                $new_substore_stock_transaction->transaction_type = $transaction_type;
                $new_substore_stock_transaction->user_id = Auth::user()->id;;
                $new_substore_stock_transaction->save();

                $substore_inventory = $this->substore_inventory_item($substore_id, $product_id);
                if($transaction_type=="CREDIT")
                {
                    $substore_inventory->quantity = $substore_inventory->quantity + $quantity;
                    $substore_inventory->save();

                    $new_substore_stock_transaction->stock_balance = $substore_inventory->quantity;
                    $new_substore_stock_transaction->save();
                }
                elseif($transaction_type=="DEBIT") {
                    $substore_inventory->quantity = $substore_inventory->quantity - $quantity;
                    $substore_inventory->save();
                    
                    $new_substore_stock_transaction->stock_balance = $substore_inventory->quantity;
                    $new_substore_stock_transaction->save();
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