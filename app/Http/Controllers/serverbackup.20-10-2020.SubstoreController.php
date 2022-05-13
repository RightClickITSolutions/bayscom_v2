<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
Use Illuminate\Support\Collection ;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Substore;
use App\Models\Lubebay;
use App\Models\SubstoreTransaction;
use App\Models\SubstoreStockTransaction;
use App\Models\Approval;
use App\Models\Account;
use App\Models\SubstoreInventory;
use App\Helpers\PostStatusHelper;

use App\Http\Controllers\Custom\AccountTransactionClass;
class SubstoreController extends Controller
{
    //
    public function transactionsEntry( Request $request){
        $view_data = [];
        $view_data['products'] = Product::all()->whereIn('id',SubstoreInventory::all()->pluck('product_id')->toArray());
        //$view_data['products'] = Product::all();
        $view_data['substores'] =  Auth::user()->allowedSubstores()->where('type',2);
        //$view_data['customers'] = Customer::where();
        $post_status = "NONE";
        $post_status_message = "NONE";
        $view_data['post_status'] = $post_status;
        $view_data['post_status_message'] = $post_status_message;
        

        if( $request->isMethod('post')){

            $validation_array = [
                    'substore' => ' required',
                    'payment' => 'required'
                ];
                $validation_error_message_array = [

                ];
                
                $request->validate($validation_array,$validation_error_message_array);
                
                $substore = Substore::find($request->input('substore'));
                $n = count($request->get('products'));
                               
                for($m=0; $m < $n ; $m++ ) {
                   // print_r($request->input('quantity.'.$m));
                    if( !empty($request->input('products.'.$m)) && !empty($request->input('quantity.'.$m)) )
                    {
                        $validation_array['quantity.'.$m] = 'max:'.$substore->productInventory($request->input('products.'.$m));
                        $validation_error_message_array['quantity.'.$m.'.max'] = 'There are '.$substore->productInventory($request->input('products.'.$m)).' units of '.Product::find($request->input('products.'.$m))->name().' left in '.$substore->name;
                        
                    }
                    
                }
                $request->validate($validation_array,$validation_error_message_array);
        
           
            $order_snapshot = [];    
            $customer = Substore::find($request->get('substore'))->customerProfile;
            $order_total = 0;
           
            $n = count($request->get('products'));
            
           
            for($m=0; $m < $n ; $m++ ) {
               // print_r($request->input('quantity.'.$m));
                if( !empty($request->input('products.'.$m)) && !empty($request->input('quantity.'.$m)) )
                {
                    $product = $customer->productScheme($request->input('products.'.$m));
                    $order_snapshot[] = ["product_id"=>$request->input('products.'.$m),"product_name"=> $product->product_name,"product_quantity"=>$request->input('quantity.'.$m),"product_price"=>$product->price];
                    $order_total += $request->input('quantity.'.$m) * $product->price;
                }
                
            }
            
            $n = count($request->input('special_item_products'));
            for($m=0; $m < $n ; $m++ ) {
                
                if( !empty($request->input('special_item_products.'.$m)) && !empty($request->input('special_item_product_quantity.'.$m)) )
                {
                    $product = $customer->productScheme($request->input('special_item_products.'.$m));
                    $order_snapshot[] = ["product_id"=>$request->input('special_item_products.'.$m),"product_name"=>" $product->product_name","product_quantity"=>$request->input('special_item_product_quantity.'.$m),"product_price"=>$request->input('special_item_product_price.'.$m)];
                    $order_total += $request->input('special_item_product_quantity.'.$m) * $request->get('special_item_product_price.'.$m);
                }
            }
            
       
            $order_snapshot = json_encode($order_snapshot);
        

            $substore = Substore::find($request->input('substore'));
            $payment = $request->input('payment');
            
            $new_sst = new SubstoreTransaction;

            $new_sst->user_id = Auth::user()->id;
            $new_sst->comment = $request->input('comment');
            $new_sst->substore_id = $substore->id;
            $new_sst->substore_type =  $substore->type;
            $new_sst->transaction_type =  'CREDIT';
            $new_sst->amount = $order_total;
            $new_sst->bank_reference = $request->input('bank_reference');
            $new_sst->sales_snapshot = $order_snapshot;
            
            
            $new_sst->current_approval ="l0" ;
            $new_sst->final_approval = "l1";
            $new_sst->approval_status = "AWAITING_CONFIRMATION";
           

            DB::beginTransaction();
            try
            {                
                $new_sst->save();
                $new_approval_tracker = new Approval;

                $new_approval_tracker->process_type = "SST";
                $new_approval_tracker->process_id = $new_sst->id;
                $new_approval_tracker->l0 = Auth::user()->id;
                $new_approval_tracker->save();

                $post_status = "SUCCESS";
                $post_status_message = " Daily transaction has been submitted with id:".$new_sst->id." an is currently awaiting approval awaiting approval";
            }
            catch(Exception $e)
            {

                DB::rollback();
                $post_status = "FAILED";
                $post_status_message = "SST generation failed";
                throw $e;
                $view_data['post_status'] = $post_status;
                $view_data['post_status_message'] = $post_status_message;
                
                return view('sst',$view_data);
                
            }
            DB::commit();

            $view_data['sst'] = $new_sst;
            $view_data['post_status'] = $post_status;
            $view_data['post_status_message'] = $post_status_message;
            
            return view('view_sst_details',$view_data);
            




        }
           

    
        return view('sst',$view_data);
    }

    public function lubebaySubstoreTransactionsEntry( Request $request){
        $view_data = [];
      
        //$view_data['products'] = Product::all()->whereIn('id',SubstoreInventory::all()->pluck('id')->toArray());
        $view_data['products'] = Product::all();
        $view_data['substores'] = Auth::user()->allowedSubstores()->where('type',3);
        //$view_data['customers'] = Customer::where();
        $post_status = "NONE";
        $post_status_message = "NONE";
        $view_data['post_status'] = $post_status;
        $view_data['post_status_message'] = $post_status_message;
        

        if( $request->isMethod('post')){
            $validation_array = [
                'substore' => ' required',
                'payment' => 'required'
            ];
            $validation_error_message_array = [

            ];
            
            
            $request->validate($validation_array,$validation_error_message_array);
            
            $substore = Substore::find($request->input('substore'));
            $n = count($request->get('products'));
                           
            for($m=0; $m < $n ; $m++ ) {
               // print_r($request->input('quantity.'.$m));
                if( !empty($request->input('products.'.$m)) && !empty($request->input('quantity.'.$m)) )
                {
                    $validation_array['quantity.'.$m] = 'max:'.$substore->productInventory($request->input('products.'.$m));
                    $validation_error_message_array['quantity.'.$m.'.max'] = 'There are '.$substore->productInventory($request->input('products.'.$m)).' units of '.Product::find($request->input('products.'.$m))->name().' left in '.$substore->name;
                    
                }
                
            }
            $request->validate($validation_array,$validation_error_message_array);
    

            $order_snapshot = [];    
            $customer = Substore::find($request->get('substore'))->customerProfile;
            $order_total = 0;
           
            $n = count($request->get('products'));
            
           
            for($m=0; $m < $n ; $m++ ) {
               // print_r($request->input('quantity.'.$m));
                if( !empty($request->input('products.'.$m)) && !empty($request->input('quantity.'.$m)) )
                {
                    $product = $customer->productScheme($request->input('products.'.$m));
                    $order_snapshot[] = ["product_id"=>$request->input('products.'.$m),"product_name"=> $product->product_name,"product_quantity"=>$request->input('quantity.'.$m),"product_price"=>$product->price];
                    $order_total += $request->input('quantity.'.$m) * $product->price;
                }
                
            }
            
            $n = count($request->input('special_item_products'));
            for($m=0; $m < $n ; $m++ ) {
                
                if( !empty($request->input('special_item_products.'.$m)) && !empty($request->input('special_item_product_quantity.'.$m)) )
                {
                    $product = $customer->productScheme($request->input('special_item_products.'.$m));
                    $order_snapshot[] = ["product_id"=>$request->input('special_item_products.'.$m),"product_name"=>" $product->product_name","product_quantity"=>$request->input('special_item_product_quantity.'.$m),"product_price"=>$request->input('special_item_product_price.'.$m)];
                    $order_total += $request->input('special_item_product_quantity.'.$m) * $request->get('special_item_product_price.'.$m);
                }
            }
            
       
            $order_snapshot = json_encode($order_snapshot);
        

            $substore = Substore::find($request->input('substore'));
            $payment = $request->input('payment');
            
            $new_sst = new SubstoreTransaction;

            $new_sst->user_id = Auth::user()->id;
            $new_sst->comment = $request->input('comment');
            $new_sst->substore_id = $substore->id;
            $new_sst->substore_type =  $substore->type;
            $new_sst->transaction_type =  'CREDIT';
            $new_sst->amount = $order_total;
            $new_sst->bank_reference = $request->input('bank_reference');
            $new_sst->sales_snapshot = $order_snapshot;
            
            
            $new_sst->current_approval ="l0" ;
            $new_sst->final_approval = "l1";
            $new_sst->approval_status = "AWAITING_CONFIRMATION";
           

            DB::beginTransaction();
            try
            {                
                $new_sst->save();
                $new_approval_tracker = new Approval;

                $new_approval_tracker->process_type = "SST";
                $new_approval_tracker->process_id = $new_sst->id;
                $new_approval_tracker->l0 = Auth::user()->id;
                $new_approval_tracker->save();

                $post_status = "SUCCESS";
                $post_status_message = " Daily transaction has been submitted with id:".$new_sst->id." an is currently awaiting approval awaiting approval";
            }
            catch(Exception $e)
            {

                DB::rollback();
                $post_status = "FAILED";
                $post_status_message = "SST generation failed";
                throw $e;
                $view_data['post_status'] = $post_status;
                $view_data['post_status_message'] = $post_status_message;
                
                return view('sst',$view_data);
                
            }
            DB::commit();

            $view_data['sst'] = $new_sst;
            $view_data['post_status'] = $post_status;
            $view_data['post_status_message'] = $post_status_message;
            
            return view('view_sst_details',$view_data);
            




        }
           

    
        return view('sst',$view_data);
    }

    public function viewTransactions(){
        $view_data = [];
        $view_data['products'] = Product::all();
        $substores = Auth::user()->allowedSubstores()->where('type',2);
        $sst_list = new Collection();
        foreach ($substores as $substore) {
            foreach ($substore->ssts as $sst) {
                $sst_list->push($sst);
            }
           
        }
       // return $sst_list;
        $view_data['sst_list'] = $sst_list;
        $view_data['substores']  = $substores;
        //$view_data['customers'] = Customer::where();
        $post_status = "NONE";
        $post_status_message = "NONE";
        $view_data['post_status'] = $post_status;
        $view_data['post_status_message'] = $post_status_message;
        return view('view_approve_sst',$view_data);
    }

    public function viewLubebaySubstoreTransactions(){
        $view_data = [];
        $view_data['products'] = Product::all();
        $substores = Auth::user()->allowedSubstores()->where('type',3);
        $sst_list = new Collection();
        foreach ($substores as $substore) {
            foreach ($substore->ssts as $sst) {
                $sst_list->push($sst);
            }
           
        }
       // return $sst_list;
        $view_data['sst_list'] = $sst_list;
        $view_data['substores']  = $substores;
        $post_status = "NONE";
        $post_status_message = "NONE";
        $view_data['post_status'] = $post_status;
        $view_data['post_status_message'] = $post_status_message;
        return view('view_approve_sst',$view_data);
    }

    public function sstDetails(SubstoreTransaction $sst){
        $view_data['sst'] = $sst;
        return view('view_sst_details', $view_data);
    }

    public function createSubstoreLubebay(Request $request){
        $view_data = [];
        $post_status = new PostStatusHelper;
        $view_data['states'] = [
            ["id"=>1,'name'=>'Kano'],
            ["id"=>2,'name'=>'Abuja']

        ];

        $view_data['locations'] = [
            ["id"=>1,'name'=>'Wuse'],
            ["id"=>2,'name'=>'Katampe']

        ];
        if($request->isMethod('post')){
                
                $request->validate([
                'name'=>'string|max:50|required',
                'address'=>'string|max:50|required',
                'state'=>'numeric',
            ]);
            $new_lubebay_successfully_created = '';
            $new_station_successfully_created = '';
            DB::beginTransaction();
            try {
                if ($request->input('station')=='true' ) {
                    $new_station_customer_account = new Customer;
                        $customer_type = 2; //type two is the retail custome substore type
                        $new_station_customer_account->name = $request->input('name')." -STATION";;
                        $new_station_customer_account->address = $request->input('address');
                        $new_station_customer_account->email = $request->input('manager_email');
                        $new_station_customer_account->phone = $request->input('manager_phone');
                        $new_station_customer_account->state = $request->input('state');
                        $new_station_customer_account->customer_type = $customer_type;
                        $new_station_customer_account->price_scheme_id = $customer_type;
                        $new_station_customer_account->customer_creator = Auth::user()->id;
                        $new_station_customer_account->save();
                        
                    $new_station = new Substore;
                        $substore_type = 2; //type two is the retail custome substore type
                        $new_station->name = $request->input('name')." -STATION";
                        $new_station->customer_id = $new_station_customer_account->id;
                        $new_station->type = $substore_type;
                        $new_station->location = $request->input('location');
                        $new_station->state = $request->input('state');
                        $new_station->save();
                                       
                    $new_station_account = new Account;
                        $new_station_account->account_name   =  $request->input('name')." -STATION";
                        $new_station_account->account_type   =  'STATION_SUBSTORE';
                        $new_station_account->owner_id   = $new_station->id;
                        $new_station_account->balance = 0;
                        $new_station_account->save();
                    
                    $new_station_successfully_created = ' Station:'. $request->input('name').' -STATION';
                }
                if($request->input('lubebay')=='true'){
                    $new_lubebay_substore_customer_account = new Customer;
                        $customer_type = 2; //type two is the retail custome substore type
                        $new_lubebay_substore_customer_account->name = $request->input('name')." -LUBEBAY-STORE";
                        $new_lubebay_substore_customer_account->address = $request->input('address');
                        $new_lubebay_substore_customer_account->email = $request->input('substore_email');
                        $new_lubebay_substore_customer_account->phone = $request->input('substore_phone');
                        $new_lubebay_substore_customer_account->state = $request->input('state');
                        $new_lubebay_substore_customer_account->customer_type = $customer_type;
                        $new_lubebay_substore_customer_account->price_scheme_id = $customer_type;
                        $new_lubebay_substore_customer_account->customer_creator = Auth::user()->id;
                        $new_lubebay_substore_customer_account->save();
    
                    $new_lubebay_substore = new Substore;
                        $substore_type = 3; //type two is the lubebay custome substore type
                        $new_lubebay_substore->name = $request->input('name')." -LUBEBAY-STORE";
                        $new_lubebay_substore->customer_id = $new_lubebay_substore_customer_account->id;
                        $new_lubebay_substore->type = $substore_type;
                        $new_lubebay_substore->location = $request->input('location');
                        $new_lubebay_substore->state = $request->input('state');
                        $new_lubebay_substore->save();
    
                     $new_lubebay = new Lubebay;
                        $new_lubebay->name = $request->input('name')." -LUBEBAY";
                        $new_lubebay->substore_id = $new_lubebay_substore->id;
                        $new_lubebay->address = $request->input('address');
                        $new_lubebay->location = $request->input('location');
                        $new_lubebay->state = $request->input('state');
                        $new_lubebay->save();
    
                                                       
                    $new_lubebay_substore_account = new Account;
                        $new_lubebay_substore_account->account_name   =  $request->input('name')." -LUBEBAY-STORE";
                        $new_lubebay_substore_account->account_type   =  'LUBEBAY_SUBSTORE';
                        $new_lubebay_substore_account->owner_id   = $new_lubebay_substore->id;
                        $new_lubebay_substore_account->balance = 0;
                        $new_lubebay_substore_account->save();
    
                    $new_lubebay_account = new Account;
                        $new_lubebay_account->account_name   =  $request->input('name')." -LUBEBAY";
                        $new_lubebay_account->account_type   =  'LUBEBAY';
                        $new_lubebay_account->owner_id   = $new_lubebay->id;
                        $new_lubebay_account->balance = 0;
                        $new_lubebay_account->save();
                        
                        $new_lubebay_successfully_created = ' Lubebay:'. $request->input('name').'-LUBEBAY ';
                }
                $post_status->success();
                $post_status->post_status_message = "successfully Created: ".$new_lubebay_successfully_created.$new_station_successfully_created." ";
            } catch (Exception $e) {
                DB::rollback();
                $post_status->failed();
                throw $e;
            }
            DB::commit();
            
        }
        $view_data['post_status'] =  $post_status->post_status;
        $view_data['post_status_message'] =  $post_status->post_status_message;
        return view('admin_create_station_lubebay',$view_data);
       
    }
    
    public function viewStations(){
        $view_data['stations_list'] = Auth::user()->allowedSubstores()->where('type',2);
        return view('stations_lubebays_summery_cards',$view_data);
    } 
    public function viewLubebayStores(){
        $view_data['stations_list'] = Auth::user()->allowedSubstores()->where('type',3);
        return view('stations_lubebays_summery_cards',$view_data);
    } 

    public function substoreLodgementHistory(Substore $substore){
        $view_data['substore'] = $substore;
        

        return view('substore_lodgement_history',$view_data);
        //return $substore->ssts->where('created_at', '>=', $start_time)->where('created_at', '<=', $end_time;
    }

    public function substoreSalesLodgementHistory(Substore $substore){
        $start_time= now()->startOfMonth()->startOfDay() ;
        $end_time = now();
        $view_data['substore'] = $substore;

        $sales_lodgement_history  = new Collection();
        $dateinterval = new CarbonPeriod(
            $start_time,
            '1 day',
            $end_time
        );
        foreach ($dateinterval as $date) {
           
            $start_of_day = Carbon::createFromTimestamp($date->timestamp)->startOfDay() ;
            $end_of_day = Carbon::createFromTimestamp($date->timestamp)->endOfDay();

            $sales_lodgement_history->push( 
                (object) [
                'date'=>$start_of_day->startOfDay(),
                'sales'=>$substore->total_sales($start_of_day, $end_of_day ),
                'lodgement'=>$substore->total_lodgements($start_of_day, $end_of_day ),
                'underlodgement' =>  $substore->total_sales($start_time,$end_of_day) - $substore->total_lodgements($start_time,$end_of_day)
                ]
            );

        }
        $view_data['sales_lodgement_history'] = $sales_lodgement_history;

        return view('substore_sales_lodgement_history',$view_data);
        //return $substore->ssts->where('created_at', '>=', $start_time)->where('created_at', '<=', $end_time;
    }
    
    public function substoreDashboard(Substore $substore){
        $start_time= now()->startOfMonth();
        $end_time = now();
        $view_data['substore'] = $substore;
        $sales_lodgement  = new Collection();        
        $sales_lodgement->push( 
            (object) [
            'sales'=>$substore->total_sales($start_time,$end_time),
            'lodgement'=>$substore->total_lodgements($start_time,$end_time ),
            'underlodgement' =>  $substore->total_sales($start_time,$end_time) - $substore->total_lodgements($start_time,$end_time)
            ]
        );        
        $view_data['sales_lodgement'] = $sales_lodgement;

        $sales_lodgement_history  = new Collection();
        $dateinterval = new CarbonPeriod(
            $start_time,
            '1 day',
            $end_time
        );
        foreach ($dateinterval as $date) {
            $start_of_day = $date->startOfDay() ;
            $end_of_day = $date->endOfDay();

            $sales_lodgement_history->push( 
                (object) [
                'date'=>$start_of_day,
                'sales'=>$substore->total_sales($start_of_day, $end_of_day ),
                'lodgement'=>$substore->total_lodgements($start_of_day, $end_of_day ),
                'underlodgement' =>  $substore->total_sales($start_time,$end_time) - $substore->total_lodgements($start_time,$end_time)
                ]
            );

        }
        $view_data['sales_lodgement_history'] = $sales_lodgement_history;

        return view('substore_sales_lodgement_history',$view_data);
        //return $substore->ssts->where('created_at', '>=', $start_time)->where('created_at', '<=', $end_time;
    }





    public function substoreLodgement(Request $request , Substore $substore){
        $view_data['substore'] = $substore;
        $post_status = new PostStatusHelper;

        if($request->isMethod('post')){
            $request->validate([
                'payment_amount' => 'required |numeric',
                'bank_reference' => 'required',
                'related_ssts' => 'required|array|min:1'
            ],
            []
            
            );
            DB::beginTransaction();
            try {

                $payment_amount = $request->get('payment_amount') ;
                $account_transaction = new AccountTransactionClass;
                $account_transaction_id = $account_transaction->new_transaction($substore->account->id, $related_process="SST_LODGEMENT", $related_process_id=null ,$transaction_type="CREDIT",$transaction_amount=$payment_amount,$payment_comment="",$bank_reference=$request->input('bank_reference'), $approved=false);
                // return '-'.$account_transaction_id;
                // die();
                if($account_transaction_id)
                {
                    foreach(SubstoreTransaction::find($request->input('related_ssts')) as $sst){
                    // print('before'.$sst->transaction_id.'<br>');
                    $sst->transaction_id = $account_transaction_id;
                    $sst->save();
                    // print('after'.$sst->transaction_id.'<br>');
                    // die();
                    }
                    $post_status->success();
                    $view_data['post_status'] = $post_status->post_status;
                    $view_data['post_status_message'] = $post_status->post_status_message;
                    

                }
                else {  
                    $post_status->failed();
                    $view_data['post_status'] = $post_status->post_status;
                    $view_data['post_status_message'] = $post_status->post_status_message;
                    throw Exception('accont transaction failed');

                }
            } 
            catch (Exceptrion $e) {
                DB::rollback();
                DB:commit();
                throw $e;
                return view('substore_lodgement',$view_data);
            }
            DB::commit();
            return view('substore_lodgement_history',$view_data);
        }

       
        

        $view_data['post_status'] = $post_status->post_status;
        $view_data['post_status_message'] = $post_status->post_status_message;
        return view('substore_lodgement',$view_data);

    }

    public function substoreLodgementStations(){
        $view_data['substore_station_list'] = Auth::user()->allowedSubstores()->where('type',2);
        return view('substore_lodgement_stations',$view_data);
    }
    public function substoreLodgementLubebays(){
        $view_data['substore_station_list'] = Auth::user()->allowedSubstores()->where('type',3);
        return view('substore_lodgement_stations',$view_data);
    }
    public function substoreInventory(Substore $substore){
        $view_data['substore'] = $substore;
        $substore_products_array = [];
        foreach ($substore->inventory as $substore_inventory_item) {
            $substore_products_array[] = $substore_inventory_item->product_id;

        }

       
        $view_data['products_list'] = Product::find($substore_products_array);
        return view('substore_products_inventory',$view_data);
    }
    public function substoreInventoryStoresList(){
        $view_data['substores_list'] = Auth::user()->allowedSubstores();
        return view('substores_inventory_stores_list',$view_data);
    }

    public function substoreProductBincard(Substore $substore, Product  $product, Request $request ){
        $substore_stock_transactions = SubstoreStockTransaction::where('substore_id',$substore->id)->where('product_id',$product->id)->get() ;       //SubstoreStockTransaction::all() ;

                
        $view_data['substore_stock_transactions'] = $substore_stock_transactions;
        $view_data['product'] = $product;
        $view_data['substore'] = $substore;
        return view('substore_product_bincard', $view_data);
    }
}
