<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Custom\CommitOrderTransaction;
use App\Http\Controllers\Custom\CommitSubstoreTransaction;
use App\Models\Product;
use App\Models\Substore;
use App\Models\Warehouse;
use App\Helpers\PostStatusHelper;


use Illuminate\Http\Request;

class StockInventoryController extends Controller
{
    //
    public function substoreStockAdjustment (Substore $substore,  $product, Request $request){
        
        $product = Product::find($product);
        $view_data['substore'] = $substore;
        $view_data['product'] = $product;
        $post_status = new PostStatusHelper;
        if ($request->isMethod('post')) {
            $request->validate([
                'quantity' => 'required',
                'transaction_type' => 'required'
            ]);

            $commit_substore_transaction = new CommitSubStoreTransaction;
            if($commit_substore_transaction->substoreStockAdjustment($substore->id,$product->id,$request->quantity,$request->input('transaction_type'))){
                $post_status->success();

            }
            else{
                $post_status->failed();

            }
            
        }

        $view_data['post_status'] = $post_status->post_status;
        $view_data['post_status_message'] = $post_status->post_status_message;


        return view('admin_adjust_substore_stock',$view_data);


    }
    public function warehouseStockAdjustment (Warehouse $warehouse, $product, Request $request){
        
        $product = Product::find($product);
        $view_data['warehouse'] = $warehouse;
        $view_data['product'] = $product;
        $post_status = new PostStatusHelper;
        if ($request->isMethod('post')) {
            $request->validate([
                'quantity' => 'required',
                'transaction_type' => 'required'
            ]);

            $commit_warehouse_transaction = new CommitOrderTransaction;
            if($commit_warehouse_transaction->warehouseStockAdjustment($warehouse->id,$product->id,$request->quantity,$request->input('transaction_type'))){
                $post_status->success();

            }
            else{
                $post_status->failed();

            }
            
        }

        return view('admin_adjust_warehouse_stock',$view_data);

    }

    public function InventoryAdjustmetSelectionPage(Request $request){
        $view_data['substores'] = Substore::all();
        $view_data['warehouses'] = Warehouse::all();
        $view_data['products'] = Product::all();
        if ($request->isMethod('post')) {
            if($request->input('adjustment_type')=='substore'){
                return redirect('admin/substore/inventory-adjustment/'.$request->input('substore').'/'.$request->input('product'));
            }
            elseif($request->input('adjustment_type')=='warehouse'){
                return redirect('admin/warehouse/inventory-adjustment/'.$request->input('warehouse').'/'.$request->input('product'));
            }
        }

        return  view('admin_inventory_adjustment_selection_page', $view_data);

    }


}
