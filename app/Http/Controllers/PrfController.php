<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Warehouse;
use App\Models\Prf;
use App\Models\Approval;
use App\Helpers\PostStatusHelper;
use App\User;

use App\Notifications\PrfNotification;

use App\Http\Controllers\Custom\CommitOrderTransaction;

class PrfController extends Controller
{
    //
    
    public function createPrf( Request $request){
        $view_data = [];
        $view_data['products'] = Product::all();
        $view_data['warehouses'] = Auth::user()->allowedWarehouses();
        $view_data['customers'] = Customer::all();
        $post_status = "NONE";
        $post_status_message = "NONE";
        $view_data['post_status'] = $post_status;
        $view_data['post_status_message'] = $post_status_message;
        
        

        if( $request->isMethod('post')){
            $validation_array = [
                    'warehouse' => 'required',
                    'customer' => 'required',
                    'payment' => 'required',
                    'customer' => 'required',
                    'payment' => 'required',
                ];
                $validation_error_message_array = [

                ];
                
                

                $request->validate($validation_array,$validation_error_message_array);
                
                $warehouse = Warehouse::find($request->input('warehouse'));
                $n = count($request->get('products'));
                
               
                for($m=0; $m < $n ; $m++ ) {
                   // print_r($request->input('quantity.'.$m));
                    if( !empty($request->input('products.'.$m)) && !empty($request->input('quantity.'.$m)) )
                    {
                        $validation_array['quantity.'.$m] = 'max:'.$warehouse->productInventory($request->input('products.'.$m));
                        $validation_error_message_array['quantity.'.$m.'.max'] = 'There are '.$warehouse->productInventory($request->input('products.'.$m)).' units of '.Product::find($request->input('products.'.$m))->name().' left in warehouse '.$warehouse->name;
                        
                    }
                    
                }
                $request->validate($validation_array,$validation_error_message_array);
                


                $order_snapshot = [];    
                $customer = Customer::find($request->get('customer'));
                $order_total = 0;
               
                $n = count($request->get('products'));
                
               
                for($m=0; $m < $n ; $m++ ) {
                   // print_r($request->input('quantity.'.$m));
                    if( !empty($request->input('products.'.$m)) && !empty($request->input('quantity.'.$m)) )
                    {
                        //loop selected poduct used to collect produc code value
                        $loop_selected_product = Product::find($request->input('products.'.$m));
                        $product = $customer->productScheme($request->input('products.'.$m));
                        $order_snapshot[] = ["product_id"=>$request->input('products.'.$m),"product_code"=>$loop_selected_product->product_code,"product_name"=> $product->product_name,"product_quantity"=>$request->input('quantity.'.$m),"product_price"=>$product->price];
                        $order_total += $request->input('quantity.'.$m) * $product->price;
                    }
                    
                }

                //  special items feature
                
                $n = count($request->input('special_item_products'));
                
                for($m=0; $m < $n ; $m++ ) {
                    
                    if( !empty($request->input('special_item_products.'.$m)) && !empty($request->input('special_item_product_quantity.'.$m)) )
                    {
                        //loop selected poduct used to collect produc code value
                        $loop_selected_product = Product::find($request->input('special_item_products.'.$m));
                        
                        $product = $customer->productScheme($request->input('special_item_products.'.$m));
                        $order_snapshot[] = ["product_id"=>$request->input('special_item_products.'.$m),"product_code"=>$loop_selected_product->product_code,"product_name"=> $product->name(),"product_quantity"=>$request->input('special_item_product_quantity.'.$m),"product_price"=>$request->input('special_item_product_price.'.$m)];
                        $order_total += $request->input('special_item_product_quantity.'.$m) * $request->get('special_item_product_price.'.$m);
                    }
                }
                
           
            $order_snapshot = json_encode($order_snapshot);
            
           
            $payment = Customer::find($request->input('payment'));
            
            $new_prf = new Prf;

            $new_prf->transaction_id = rand(100,999).time();
            $new_prf->client_id =  $customer->id;
            $new_prf->client_type =  $customer->customer_type;
            $new_prf->order_snapshot = $order_snapshot;
            $new_prf->order_total = $order_total;
            $new_prf->payment = $request->input('payment');
            $new_prf->payment_date = $request->input('payment_date');
            $new_prf->sales_rep = Auth::user()->id;
            $new_prf->warehouse_id = $request->input('warehouse');
            
            if($payment=="CREDIT" && ($customer->balance - $order_total  <= $customer->credit_limit) )
            {
                $new_prf->current_approval ="l0" ;
                $new_prf->final_approval = "l2";
                $new_prf->approval_status = "INITIATED";
            }
            else {
                $new_prf->current_approval ="l0" ;
                $new_prf->final_approval = "l1";
                $new_prf->approval_status = "INITIATED";
            }

            DB::beginTransaction();
            try
            {                
                $new_prf->save();
                $new_approval_tracker = new Approval;

                $new_approval_tracker->process_type = "PRF";
                $new_approval_tracker->process_id = $new_prf->id;
                $new_approval_tracker->l0 = Auth::user()->id;
                $new_approval_tracker->save();

                $post_status = "SUCCESS";
                $post_status_message = " a new PRF  with Id ".$new_prf->transaction_id." has been raised is is awaiting approval";
                
                Notification::send(User::permission('approve_prf_l1')->get(), new PrfNotification($prf = $new_prf));
            }
            catch(\Exception $e)
            {

                DB::rollback();
                $post_status = "FAILED";
                // $post_status_message = $e->getMessage;
                

                $view_data['post_status'] = $post_status;
                $view_data['post_status_message'] = $post_status_message;
            
                return view('prf',$view_data);
            }
            DB::commit();

            $view_data['prf'] = $new_prf;
            $view_data['post_status'] = $post_status;
            $view_data['post_status_message'] = $post_status_message;
            
            return view('prf_invoice',$view_data);
            




        }
           

    
        return view('prf',$view_data);
    }

    public function viewApproved(Request $request){
        //debug
        //$prfs = Prf::find(2);
        if (  $request->session()->get('post_status') ) {
            $view_data['post_status'] = $request->session()->get('post_status');
            $view_data['post_status_message'] = $request->session()->get('post_status_message');
             
        }
        $prf_list = Prf::withTrashed()->whereIn('warehouse_id',json_decode(Auth::user()->accessibleEntities()->warehouses))->where('approval_status', 'APPROVED_COLLECTED')->limit(200)->get();
        $view_data['prf_list'] = $prf_list;

        // return $view_data['prf_list'];
        //debug
        //return $prf->createdBy;
        return view('view_approve_prf',$view_data);
    }

    public function view(Request $request)
    {
        //debug
        //$prfs = Prf::find(2);
        if (  $request->session()->get('post_status') ) {
            $view_data['post_status'] = $request->session()->get('post_status');
            $view_data['post_status_message'] = $request->session()->get('post_status_message');
             
        }
        $prf_list = Prf::all();
        $view_data['prf_list'] = $prf_list;
        
        return view('admin_reverse_prf',$view_data);
    }

    public function prfPayment(Request $request, Prf $prf){
        $post_status = new PostStatusHelper;
        $view_data['prf'] = $prf;
        if($request->isMethod('post')){
            //add check for accidental double post / additional paymment fter amount is covered.
            $request->validate([
                'payment_amount' => 'required |numeric',
                'teller_no' => 'required'
            ]
            
            );
        $payment_amount = $request->get('payment_amount') ;
        //die("prf payment class jsut befor thecommmit order trnsaction class");
        $order_transaction = new CommitOrderTransaction;
        if($order_transaction->prfPayment($prf->id,"CREDIT",$payment_amount,"payment for order",$reference_number=$request->get('teller_no')))
        {
            $post_status->success();
            $view_data['post_status'] = $post_status->post_status;
            $view_data['post_status_message'] = $post_status->post_status_message;
            $view_data['prf'] = $prf;
            $view_data['customer'] = $prf->customer;
            //return view('customer_transactions', $view_data);
            return view('prf_payment_history',$view_data);
        }
        else {
            $post_status->failed();
            
        }

        $view_data['post_status'] = $post_status->post_status;
        $view_data['post_status_message'] = $post_status->post_status_message;
        return view('prf_payment',$view_data);

        }
    
        
        return view('prf_payment',$view_data);
    }

    public function prfPaymentList(){
        $view_data['prf_list'] = Prf::where('approval_status','APPROVED_COLLECTED')->whereIn('warehouse_id',json_decode(Auth::user()->accessibleEntities()->warehouses))->get();
        
        return view('prf_payment_list',$view_data);

       
    }

    public function paymentHistory(Prf $prf){
        $view_data['prf'] =  $prf;
        $view_data['customer'] = Customer::find($prf->customer->id);
         //return $prf->payments;
        return view('prf_payment_history', $view_data);
    }

    public function prfStorekeeper(Request $request ){
        
        if($request->isMethod('post'))
        {
            $post_status = new PostStatusHelper;
            //Storage::put($request->get('order_id').'_prf_stock_collection.lock', '');
            if(!Storage::exists($request->get('order_id').'_prf_stock_collection.lock'))
            {
                $prf_id = $request->get('order_id') ;
                $selected_prf = Prf::findOrFail($prf_id);
                // if statement check for accidental double post
                if($selected_prf->approval_status =='APPROVED_NOT_COLLECTED')
                {
                    $stock_collection = new CommitOrderTransaction;
                    
                    if($stock_collection->prfStockCollection($prf_id))
                    {
                        $post_status->success();
                    }
                    else{
                        $post_status->failed();
                    }
                    $view_data['post_status'] = $post_status->post_status;
                    $view_data['post_status_message'] = $post_status->post_status_message;
                    $prf_list = $prf_list = Prf::all()->where('approval_status','APPROVED_NOT_COLLECTED')->whereIn('warehouse_id',json_decode(Auth::user()->accessibleEntities()->warehouses));
                    $view_data['prf_list'] = $prf_list;
                    return view('prf_store_keeper',$view_data);
                }
                else{
                    $post_status->failed();
                    $view_data['post_status'] = $post_status->post_status;
                    $view_data['post_status_message'] = "order has already been issued. refreshing page.";
                }
            }
            else
            {
                return abort(403);
            }
                
            
            
        }
        
        $prf_list = Prf::all()->where('approval_status','APPROVED_NOT_COLLECTED')->whereIn('warehouse_id',json_decode(Auth::user()->accessibleEntities()->warehouses));
        $view_data['prf_list'] = $prf_list;

        // foreach ($prf_list as $list) {
        //     return $list->client_id;
        // }

        return view('prf_store_keeper',$view_data);
    }

    public function storekeeperIssueHistory(Request $request ){
        $prf_list = Prf::all()->where('approval_status','APPROVED_COLLECTED')->whereIn('warehouse_id',json_decode(Auth::user()->accessibleEntities()->warehouses));
        $view_data['prf_list'] = $prf_list;

        
        //return Auth::user()->accessibleEntities()->warehouses;
        return view('storekeeper_prf_issue_history',$view_data);
    }

    public function prfInvoice(Prf $prf){
        $view_data['prf'] = $prf;
        return view('prf_invoice', $view_data);
    }

    public function prfWaybill(Prf $prf){
        $view_data['prf'] = $prf;
        return view('prf_waybill', $view_data);
    }

    public function selecetPrfReversalCustomer(Request $request){
        
        $prf_list = Prf::where('APPROVAL_STATUS','APPROVED_COLLECTED')->get();
        $view_data['prf_list'] = $prf_list;
        
        return view('admin_reverse_prf',$view_data);





    }

    public function prfReversal(Prf $prf, Request $request){

        $prf_list = Prf::where('APPROVAL_STATUS','APPROVED_COLLECTED')->get();
        $view_data['prf_list'] = $prf_list;
        $commit_order_transactions = New CommitOrderTransaction;
        $post_status =  New PostStatusHelper;
        if($commit_order_transactions->prfStockCollectionReversal($prf->id)){

            $post_status->success();
        }
        else{
            $post_status->failed();
        }
        $delete_prf  = Prf::withTrashed()->where('id', $prf->id)->whereIn('warehouse_id',json_decode(Auth::user()->accessibleEntities()->warehouses))->delete();

        if ($delete_prf) {

            $view_data['post_status'] = $post_status->post_status;
            $view_data['post_status_message'] = $post_status->post_status_message;
            $request->session()->flash('deleted', '');
            $request->session()->flash('delete_row', '');
            return redirect('/view-prf');

        }else {

            $view_data['post_status'] = $post_status->post_status;
            $view_data['post_status_message'] = $post_status->post_status_message;
            $request->session()->flash('not-deleted', '');
            return redirect('/view-prf');

        }

    }

    // stock return feature developement halted
    public function stockReturn( Request $request){
        $view_data = [];
        $view_data['products'] = Product::all();
        $view_data['warehouses'] = Auth::user()->allowedWarehouses();
        $view_data['customers'] = Customer::all()->whereIn('type',[2,3]);
        $post_status = "NONE";
        $post_status_message = "NONE";
        $view_data['post_status'] = $post_status;
        $view_data['post_status_message'] = $post_status_message;
        
        

        if( $request->isMethod('post')){
            $validation_array = [
                    'warehouse' => 'required',
                    'customer' => 'required',
                    'payment' => 'required',
                    
                ];
                $validation_error_message_array = [

                ];
                
                

                $request->validate($validation_array,$validation_error_message_array);
                
                $warehouse = Warehouse::find($request->input('warehouse'));
                $customer = Customer::find($request->get('customer'));

                if($customer->type=2)
                {
                    $n = count($request->get('products'));
                
               
                    for($m=0; $m < $n ; $m++ ) {
                    // print_r($request->input('quantity.'.$m));
                        if( !empty($request->input('products.'.$m)) && !empty($request->input('quantity.'.$m)) )
                        {
                            $validation_array['quantity.'.$m] = 'max:'.$warehouse->productInventory($request->input('products.'.$m));
                            $validation_error_message_array['quantity.'.$m.'.max'] = 'There are '.$warehouse->productInventory($request->input('products.'.$m)).' units of '.Product::find($request->input('products.'.$m))->name().' left in warehouse '.$warehouse->name;
                            
                        }
                        
                    }
                    $request->validate($validation_array,$validation_error_message_array);
                }
                
                


                $stock_return_snapshot = [];    
                
                $order_total = 0;
               
                $n = count($request->get('products'));
                
               
                for($m=0; $m < $n ; $m++ ) {
                   // print_r($request->input('quantity.'.$m));
                    if( !empty($request->input('products.'.$m)) && !empty($request->input('quantity.'.$m)) )
                    {
                        //loop selected poduct used to collect produc code value
                        $loop_selected_product = Product::find($request->input('products.'.$m));
                        $product = $customer->productScheme($request->input('products.'.$m));
                        $stock_return_snapshot[] = ["product_id"=>$request->input('products.'.$m),"product_code"=>$loop_selected_product->product_code,"product_name"=> $product->product_name,"product_quantity"=>$request->input('quantity.'.$m),"product_price"=>$product->price];
                        $order_total += $request->input('quantity.'.$m) * $product->price;
                    }
                    
                }

                //  special items feature
                
                $n = count($request->input('special_item_products'));
                
                for($m=0; $m < $n ; $m++ ) {
                    
                    if( !empty($request->input('special_item_products.'.$m)) && !empty($request->input('special_item_product_quantity.'.$m)) )
                    {
                        //loop selected poduct used to collect produc code value
                        $loop_selected_product = Product::find($request->input('special_item_products.'.$m));
                        
                        $product = $customer->productScheme($request->input('special_item_products.'.$m));
                        $stock_return_snapshot[] = ["product_id"=>$request->input('special_item_products.'.$m),"product_code"=>$loop_selected_product->product_code,"product_name"=> $product->name(),"product_quantity"=>$request->input('special_item_product_quantity.'.$m),"product_price"=>$request->input('special_item_product_price.'.$m)];
                        $order_total += $request->input('special_item_product_quantity.'.$m) * $request->get('special_item_product_price.'.$m);
                    }
                }
                
           
            $stock_return_snapshot = json_encode($stock_return_snapshot);
            
           
            $payment = Customer::find($request->input('payment'));
            
            $new_stock_return = new StockTransfer;

            $new_stock_return->originating_entity_id =  $customer->substore->id;
            $new_stock_return->recieving_entity_id =  $request->input('warehouse');
            $new_stock_return->stock_return_snapshot = $stock_return_snapshot;
            $new_stock_return->payment = $request->input('payment');
            $new_stock_return->user_id = Auth::user()->id;
            
            
            $new_stock_return->current_approval ="l0" ;
            $new_stock_return->final_approval = "l1";
            $new_stock_return->approval_status = "INITIATED";
           
            DB::beginTransaction();
            try
            {                
                $new_stock_return->save();
                $new_approval_tracker = new Approval;

                $new_approval_tracker->process_type = "STOCK_RETURN";
                $new_approval_tracker->process_id = $new_stock_return->id;
                $new_approval_tracker->l0 = Auth::user()->id;
                $new_approval_tracker->save();

                $post_status = "SUCCESS";
                $post_status_message = " a new stock_return  with Id ".$new_stock_return->transaction_id." has been raised is is awaiting approval";
                
               // Notification::send(User::permission('approve_stock_return_l1')->get(), new stock_returnNotification($stock_return = $new_stock_return));
            }
            catch(\Exception $e)
            {

                DB::rollback();
                $post_status = "FAILED";
                $post_status_message = "stock_return generation failed";
                

                $view_data['post_status'] = $post_status;
                $view_data['post_status_message'] = $post_status_message;
            
                return redirect('stock_return',$view_data);
            }
            DB::commit();

            $view_data['stock_return'] = $new_stock_return;
            $view_data['post_status'] = $post_status;
            $view_data['post_status_message'] = $post_status_message;
            
            return view('view_approve_stock_return',$view_data);
            




        }
           

    
        return view('prf',$view_data);
    }

    public function viewApproveStockReturn( Request $request){
        //debug
        //$prfs = Prf::find(2);
        if (  $request->session()->get('post_status') ) {
            $view_data['post_status'] = $request->session()->get('post_status');
            $view_data['post_status_message'] = $request->session()->get('post_status_message');
             
        }
        $prf_list = StockTransfer::where('type','STOCK_RETURN')->get();
        $view_data['stock_return_list'] = $stock_return_list;
        //debug
        //return $prf->createdBy;
        return view('view_approve_stock_return',$view_data);
    }

    // end of stock return feature

}
