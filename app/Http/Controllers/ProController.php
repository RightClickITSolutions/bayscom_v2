<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\Custom\AccountTransactionClass;
use Illuminate\Validation\ValidationException;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\Pro;
use App\Models\Approval;
use App\Models\Customer;
use App\Models\WarehouseInventory;
use App\Http\Controllers\Custom\CommitOrderTransaction;
use App\Helpers\PostStatusHelper;
use App\Models\Account;
use App\Models\Prf;
use App\User;

use App\Notifications\ProNotification;

class ProController extends Controller
{
    //
    public function createPro( Request $request){
        $view_data = [];
        $view_data['products'] = Product::all();
        $view_data['warehouses'] = Auth::user()->allowedWarehouses();
        $view_data['customers'] = Customer::all();
        $post_status = "NONE";
        $post_status_message = "NONE";
        $view_data['post_status'] = $post_status;
        $view_data['post_status_message'] = $post_status_message;
        
       
        if( $request->isMethod('post')){
            $request->validate([
               'warehouse'=>'required',
               'products.0'=>'required',
               'quantity.0'=>'required'
           ]);

            $order_snapshot = [];    
            $order_snapshot_product_ids = [];
            $order_total = 0;
           
            $n = count($request->get('products'));
            
           
            for($m=0; $m < $n ; $m++ ) {
                //print_r($request->input('products'));
                if(!in_array($request->input('products.'.$m),$order_snapshot_product_ids))
                {
                    if( !empty($request->input('products.'.$m)) && !empty($request->input('quantity.'.$m)) )
                    {
                        $product = Product::find($request->input('products.'.$m));
                        $order_snapshot[] = ["product_id"=>$request->input('products.'.$m),"product_code"=> $product->product_code,"product_name"=> $product->name(),"product_quantity"=>$request->input('quantity.'.$m),"product_price"=>$product->cost_price];
                        $order_total += $request->input('quantity.'.$m) * $product->cost_price;

                        //for checking repeated pro product entry. error will be thrown in the event of a repeated product
                        $order_snapshot_product_ids[] = $request->input('products.'.$m);
                
                    }
                }
                else {
                    
                    throw ValidationException::withMessages(['Product' => Product::find($request->input('products.'.$m))->name()." was enetered multiple times in the PRO. please make sure there is only one entry of each item"]);
                    
                    return view('pro',$view_data);
                }
                    
                
            }

            $order_snapshot = json_encode($order_snapshot);
            
            $new_pro = new Pro;

            $new_pro->warehouse_id = $request->input('warehouse');
            //po number issued by supplier wont be available untl order is placed
            //$new_pro->waybill_number = $request->input('waybill_number');
            $new_pro->transaction_id = rand(100000,9999999).time();
            //additional reference ids if required in the future
            //$new_pro->refference_number = $request->input('reference_number');
            $new_pro->order_snapshot = $order_snapshot;
            $new_pro->order_total = $order_total;
            $new_pro->user_id = Auth::user()->id;

            $new_pro->current_approval ="l0" ;
            $new_pro->final_approval = "l2";
            $new_pro->approval_status = "INITIATED";

            DB::beginTransaction();
            try
            {                
                $new_pro->save();
                $new_approval_tracker = new Approval;

                $new_approval_tracker->process_type = "PRO";
                $new_approval_tracker->process_id = $new_pro->id;
                $new_approval_tracker->l0 = Auth::user()->id;
                $new_approval_tracker->save();

                $post_status = "SUCCESS";
                $post_status_message = " a new PRO with Id".$new_pro->transaction_id." has been raised is is awaiting approval";
                Notification::send(User::permission('approve_pro_l1')->get(), new ProNotification($pro = $new_pro));

            }
            catch(Exception $e)
            {

                DB::rollback();
                $post_status = "FAILED";
                $post_status_message = "PRO generation failed";
                throw $e;
                $view_data['post_status'] = $post_status;
                $view_data['post_status_message'] = $post_status_message;
            
                return view('pro',$view_data);
            }

            DB::commit();

            $view_data['pro'] = $new_pro;
            $view_data['post_status'] = $post_status;
            $view_data['post_status_message'] = $post_status_message;
            
            return view('view_pro_details',$view_data);
            




        }
           

    
        return view('pro',$view_data);
    }

    public function view(Request $request){
        //$pros = Pro::find(2);
        //return $request->session()->all();
        if (  $request->session()->get('post_status') ) {
            $view_data['post_status'] = $request->session()->get('post_status');
            $view_data['post_status_message'] = $request->session()->get('post_status_message');
             
        }
        $pro_list = Pro::all()->whereIn('warehouse_id',json_decode(Auth::user()->accessibleEntities()->warehouses));
        $view_data['pro_list'] = $pro_list;
        //return $pros->createdBy;
        return view('view_approve_pro',$view_data);
    }

    private function proCheckOrderCompletion($pro){
        $status = true;
        foreach ($pro->order_snapshot() as $order_product) {
            if($pro->received_product_quantity($order_product->product_id) < $order_product->product_quantity )
            {
                $status = false;
                
                
            }

        }
        if($status == true)
        {
            print_r('check completion');
            $pro->approval_status = 'APPROVED_COLLECTED';
            $pro->save();
            return true;
        }

        return false;


        

        
    }

    public function proReceiveGoods(Request $request, Pro $pro){
        //$pros = Pro::find(2);
        $post_status = new PostStatusHelper;   
        if($request->isMethod('POST')){

            $product_order_quantity = 0;
            //return  $request->input('product');
            foreach ($pro->order_snapshot() as $order_product) {
                if($order_product->product_id == $request->input('product'))
                {
                    $product_order_quantity = $order_product->product_quantity;
                    
                }

            }

            $product_remainging_unreceived_quantity = $product_order_quantity - $pro->received_product_quantity($request->input('product'));
            //return $product_remainging_unreceived_quantity;
            $result = $request->validate(
                [
                'product'=>'required',
                'quantity'=>'numeric|max:'.$product_remainging_unreceived_quantity.'',
                ],
                [
                    'product.required'=>'Please selet the product you are receiving',
                    'quantity.max'=>'the product quantity you entered exceeds the order quantity: '.$product_order_quantity,
                ]);

           //return print_r($result);
           //die();
            //TODO
            //add validation
            //return post confirmation

            $pro_id = $pro->id;
            $product_id = $request->get('product');
            $product_quantity = $request->get('quantity');
            // $invitem = WarehouseInventory::where('warehouse_id', 2)->where('product_id', $product_id);
            // return(($invitem)->first());
            $receivegoods = new CommitOrderTransaction;
            if($receivegoods->proStockCollection($pro_id,$product_id, $product_quantity) )
            {
                $post_status->success();
            }
            else{
                $post_status->failed();
            }
            $this->proCheckOrderCompletion($pro);
        }
        
        $this->proCheckOrderCompletion($pro);
        $view_data['post_status'] = $post_status->post_status;
        $view_data['post_status_message'] = $post_status->post_status_message;
        $view_data['pro'] = $pro;
        $view_data['products'] = Product::all();
        //return $pros->createdBy;
        return view('pro_receive_goods',$view_data);
    }

    public function proStorekeeper(Request $request)
    {
        //$pros = Pro::find(2);
               
        $pro_list = Pro::all()->where('approval_status','APPROVED_NOT_COLLECTED')->whereIn('warehouse_id',json_decode(Auth::user()->accessibleEntities()->warehouses));
        $view_data['pro_list'] = $pro_list;
        //return $pros->createdBy;
        return view('pro_store_keeper',$view_data);
    }
    
    public function storekeeperReceiveHistory(Request $request)
    {
        //$pros = Pro::find(2);
              
       
        $pro_list = Pro::all()->where('approval_status','APPROVED_COLLECTED')->whereIn('warehouse_id',json_decode(Auth::user()->accessibleEntities()->warehouses));
        $view_data['pro_list'] = $pro_list;
        //return $pros->createdBy;
        return view('storekeeper_pro_receive_history',$view_data);

    }

    public function viewProDetails(Pro $pro){
        $view_data['pro'] = $pro;
        return view('view_pro_details', $view_data);
    }


    public function reversePro($pro_id, Request $request)
    {
        $account = Account::where('account_name', 'MOFAD_SAGE')->where('account_type','MAIN')->first();
        $current_pro_amount = $request->input('reverse_price');
        $new_current_balance = $current_pro_amount + $account->balance;

        $new_account = Account::where('account_name', 'MOFAD_SAGE')->where('account_type', 'MAIN')->update([
            'balance' => $new_current_balance,
        ]);

        if ($new_account) { 

            $account_transaction = new AccountTransactionClass;
            $account_transaction_id = $account_transaction->new_transaction(
                $account->id,
                $related_process="ADMIN_POST",
                $related_process_id=null,
                $transaction_type=$request->input('transaction_type'),
                $transaction_amount=$current_pro_amount,
                $payment_comment="PRO Reversal",
                $bank_reference="",
                $approved=true);
            if ($account_transaction_id) {

                $reverse_pro = Pro::where('id', $pro_id)->delete();

                if ($reverse_pro) {
                    $request->session()->flash('status', 'PRO Reverse successfully.');
                    return redirect('/view-pro');
                }else{
                    $request->session()->flash('status_error', 'PRO Reverse not successfully.');
                    return redirect('/view-pro');
                }
                
            }
        }

    }

    // public function instReversePro($pro_id, Request $request)
    // {
    //     $current_pro_amount = $request->input('reverse_price');
    //     return $current_pro_amount . " " .$pro_id;

    // }
}
