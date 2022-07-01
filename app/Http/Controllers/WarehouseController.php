<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


use Illuminate\Http\Request;
use App\Models\StockTransaction;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\State;
use App\Models\StockTransfer;
use App\Helpers\PostStatusHelper;
use App\Models\Approval;


use App\Http\Controllers\Custom\CommitOrderTransaction;


class WarehouseController extends Controller
{
    //
    public function productBincard(Warehouse $warehouse, Product  $product, Request $request ){
        $stock_transactions = StockTransaction::where('warehouse_id',$warehouse->id)->where('product_id',$product->id)->get() ;// StockTransaction::all() ;

        //
        
        $view_data['stock_transactions'] = $stock_transactions;
        $view_data['product'] = $product;
        $view_data['warehouse'] = $warehouse;
        return view('warehouse_product_bincard', $view_data);
    }

    public function stockTransfer(Request $request){
        $post_status = new PostStatusHelper;   
        $view_data = [];
        $view_data['products'] = Product::all();
       $view_data['warehouses'] = Auth::user()->allowedWarehouses();
        $post_status = "NONE";

        $post_status_message = "NONE";
        $view_data['post_status'] = $post_status;
        $view_data['post_status_message'] = $post_status_message;
        
        

        if( $request->isMethod('post')){
            $validation_array = [
                    'origin_warehouse' => 'required',
                    'recipient_warehouse' => 'required',
                    
                    
                ];
                $validation_error_message_array = [

                ];
                
                

                $request->validate($validation_array,$validation_error_message_array);
                
                $origin_warehouse = Warehouse::find($request->input('origin_warehouse'));
                $recipient_warehouse = Warehouse::find($request->input('recipient_warehouse'));

                
                $n = count($request->get('products'));
            
            
                for($m=0; $m < $n ; $m++ ) {
                // print_r($request->input('quantity.'.$m));
                    if( !empty($request->input('products.'.$m)) && !empty($request->input('quantity.'.$m)) )
                    {
                        $validation_array['quantity.'.$m] = 'max:'.$origin_warehouse->productInventory($request->input('products.'.$m));
                        $validation_error_message_array['quantity.'.$m.'.max'] = 'There are '.$origin_warehouse->productInventory($request->input('products.'.$m)).' units of '.Product::find($request->input('products.'.$m))->name().' left in warehouse '.$origin_warehouse->name;
                        
                    }
                    
                }
                $request->validate($validation_array,$validation_error_message_array);
               
                
                


                $stock_transfer_snapshot = [];    
                
                $order_total = 0;
               
                $n = count($request->get('products'));
                
               
                for($m=0; $m < $n ; $m++ ) {
                   // print_r($request->input('quantity.'.$m));
                    if( !empty($request->input('products.'.$m)) && !empty($request->input('quantity.'.$m)) )
                    {
                        //loop selected poduct used to collect produc code value
                        $loop_selected_product = Product::find($request->input('products.'.$m));
                        $stock_transfer_snapshot[] = ["product_id"=>$request->input('products.'.$m),"product_code"=>$loop_selected_product->product_code,"product_name"=> $loop_selected_product->name(),"product_quantity"=>$request->input('quantity.'.$m),"product_price"=>$loop_selected_product->productPrice(2)];
                        $order_total += $request->input('quantity.'.$m) * $loop_selected_product->productPrice(2);
                    }
                    
                }

                $stock_transfer_snapshot = json_encode($stock_transfer_snapshot);
            
            
                $new_stock_transfer = new StockTransfer;
    
                $new_stock_transfer->originating_entity_id =  $request->input('origin_warehouse');
                $new_stock_transfer->recieving_entity_id =  $request->input('recipient_warehouse');
                $new_stock_transfer->transfer_snapshot = $stock_transfer_snapshot;
                $new_stock_transfer->type = 'W2W';
                $new_stock_transfer->user_id = Auth::user()->id;
                
                
                $new_stock_transfer->current_approval ="l0" ;
                $new_stock_transfer->final_approval = "l1";
                $new_stock_transfer->approval_status = "INITIATED";
               
                DB::beginTransaction();
                try
                {                
                    $new_stock_transfer->save();
                    $new_approval_tracker = new Approval;
    
                    $new_approval_tracker->process_type = "STOCK_TRANSFER";
                    $new_approval_tracker->process_id = $new_stock_transfer->id;
                    $new_approval_tracker->l0 = Auth::user()->id;
                    $new_approval_tracker->save();
    
                    $post_status = "SUCCESS";
                    $post_status_message = " a new stock_transfer  with Id ".$new_stock_transfer->id." has been raised is is awaiting approval";
                    
                   // Notification::send(User::permission('approve_stock_transfer_l1')->get(), new stock_transferNotification($stock_transfer = $new_stock_transfer));
                }
                catch(Exception $e)
                {
    
                    DB::rollback();
                    $post_status = "FAILED";
                    $post_status_message = "stock_transfer generation failed";
                    throw $e;
    
                    $view_data['post_status'] = $post_status;
                    $view_data['post_status_message'] = $post_status_message;
                
                    return view('stock_transfer',$view_data);
                }
                DB::commit();
    
                $view_data['stock_transfer'] = $new_stock_transfer;
                $view_data['post_status'] = $post_status;
                $view_data['post_status_message'] = $post_status_message;
                
                
            // coppies drom pro 
        }
        return view('warehouse_transfers',$view_data);

            
    } 

    public function warehouseTransferStorekeeper(Request $request ){
        
        if($request->isMethod('post'))
        {
            //Storage::put($request->get('stock_transfer_id').'_stock_transfer_stock_collection.lock', '');
            if(!Storage::exists($request->get('stock_transfer_id').'_stock_transfer.lock'))
            {
                $stock_transfer_id = $request->get('stock_transfer_id') ;
                $selected_stock_transfer = StockTransfer::findOrFail($stock_transfer_id);
                // if statement check for accidental double post
                if($selected_stock_transfer->approval_status =='APPROVED_NOT_COLLECTED')
                {
                    $stock_movement = new CommitOrderTransaction;
                    $post_status = new PostStatusHelper;
                    if($stock_movement->stockTransfer($stock_transfer_id))
                    {
                        $post_status->success();
                    }
                    else{
                        $post_status->failed();
                    }
                    $view_data['post_status'] = $post_status->post_status;
                    $view_data['post_status_message'] = $post_status->post_status_message;
                    $stock_transfer_list = $stock_transfer_list = StockTransfer::all()->where('approval_status','APPROVED_NOT_COLLECTED')->whereIn('originating_entity_id',json_decode(Auth::user()->accessibleEntities()->warehouses));
                    $view_data['stock_transfer_list'] = $stock_transfer_list;
                    return view('store_keeper_issue_stock_transfer',$view_data);
                }
            }
            else
            {
                return abort(403);
            }
                
            
            
        }
        
        $stock_transfer_list = StockTransfer::all()->where('approval_status','APPROVED_NOT_COLLECTED')->whereIn('originating_entity_id',json_decode(Auth::user()->accessibleEntities()->warehouses));
        //return $stock_transfer_list;
        $view_data['stock_transfer_list'] = $stock_transfer_list;

        return view('stock_transfer_store_keeper',$view_data);
    }

    public function viewStockTransfer( Request $request){
        //debug
        //$stock_transfers = stock_transfer::find(2);
        if (  $request->session()->get('post_status') ) {
            $view_data['post_status'] = $request->session()->get('post_status');
            $view_data['post_status_message'] = $request->session()->get('post_status_message');
             
        }
        $stock_transfer_list = StockTransfer::whereIn('originating_entity_id',json_decode(Auth::user()->accessibleEntities()->warehouses))->get();
        $view_data['stock_transfer_list'] = $stock_transfer_list;
        //debug
        //return $stock_transfer->createdBy;
        //return $stock_transfer_list->first();
        return view('view_approve_stock_transfer',$view_data);
    }

    public function createWarehouse(Request $request ){
        $view_data = [];
        $view_data['states'] = State::all();

        if($request->isMethod('post')){

            $post_status = new PostStatusHelper;
            $validation_array = [
                'warehouse_name' => 'required',
                'state' => 'required'
                
            ];
            $validation_error_message_array = [ ];
            
            $request->validate($validation_array,$validation_error_message_array);
            $post_status->success();
            $view_data['post_status'] = $post_status->post_status;
            $view_data['post_status_message'] = $post_status->post_status_message;

            $new_warehouse =  new Warehouse;

            $new_warehouse->name = $request->input('warehouse_name');
            $new_warehouse->state = $request->input('state');
            $new_warehouse->type = "MAIN";
            $new_warehouse->location = State::find($request->input('state'))->name;
            $new_warehouse->save();

        }

        return view('admin_create_warehouse',$view_data);



    }

    function editWarehouse($wid)
    {
        $view_data['warehouse_data'] = Warehouse::where('id', $wid)->get();

        return view('edit_warehouse', $view_data);
    }

    public function instEditWarehouse(Request $request)
    {
        $new_state = '';
        $wid = $request->input('edit_id');
        $warehouse_edit_name = $request->input('edit_name');
        $warehouse_edit_state = strtoupper($request->input('edit_state'));
        $warehouse_edit_address = $request->input('edit_location');
        
        if ($warehouse_edit_state == 'ABUJA') {
            $new_state = 1;
        }elseif($warehouse_edit_state == 'KANO'){
            $new_state = 2;
        }

        $edit_warehouse = Warehouse::where('id', $wid)->update([
            "name" => $warehouse_edit_name,
            "state" => $new_state,
            "location" => $warehouse_edit_address,
        ]);

        if ($edit_warehouse) {
            $request->session()->flash('warehouse_edit', 'Warehouse Edited!');
            return redirect('/view/warehouses');
        }else{
            $request->session()->flash('warehouse_edit_error', 'Error editing warehouse!');
            return redirect('/view/warehouses');
        }

    }

    public function deleteWarehouse($wid)
    {
         $view_data['warehouse_data'] = Warehouse::where('id', $wid)->get();

        return view('delete_prompt_warehouse', $view_data);
    }

    public function instDeleteWarehouse(Request $request)
    {
        $wid = $request->input('wid');

        $delete_warehouse = Warehouse::where('id', $wid)->delete();

        if ($delete_warehouse) {
            $request->session()->flash('warehouse_delete', 'Warehouse Deleted!');
            return redirect('/view/warehouses');
        }else{
            $request->session()->flash('warehouse_delete_error', 'Error deleting warehouse!');
            return redirect('/view/warehouses');
        }

    }

    public function AuthVerify()
    {
        return Auth::user()->accessibleEntities();
    }
}
