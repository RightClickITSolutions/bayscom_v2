<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
Use Illuminate\Support\Collection ;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;

use App\Models\Service;
use App\Models\Customer;
use App\Models\Substore;
use App\Models\SubstoreTransaction;
use App\Models\Lubebay;
use App\Models\LubebayTransaction;
use App\Models\LubebayServiceTransaction;
use App\Models\Approval;
use App\Models\LubebayExpense;
use App\Models\LubebayExpenseType;
use App\Helpers\PostStatusHelper;
use App\Http\Controllers\Custom\CommitLubebayTransaction;
use App\Http\Controllers\Custom\AccountTransactionClass;

class LubebayController extends Controller
{
    //
     //
     public function transactionsEntry( Request $request){
        $view_data = [];
        $view_data['services'] = Service::all();
        $view_data['lubebays'] = Auth::user()->allowedLubebays();
        
        $post_status = "NONE";
        $post_status_message = "NONE";
        $view_data['post_status'] = $post_status;
        $view_data['post_status_message'] = $post_status_message;
        

        if( $request->isMethod('post')){

            $order_snapshot = [];    
            $lubebay = Lubebay::find($request->get('lubebay'))->customerProfile;
            $order_total = 0;
           
            $n = count($request->get('services'));
            
           
            for($m=0; $m < $n ; $m++ ) {
               // print_r($request->input('quantity.'.$m));
                if( !empty($request->input('services.'.$m)) && !empty($request->input('quantity.'.$m)) )
                {
                    $service = Service::find($request->input('services.'.$m));
                    $order_snapshot[] = ["service_id"=>$request->input('services.'.$m),"service_name"=> $service->service_name,"service_quantity"=>$request->input('quantity.'.$m),"service_price"=>$service->price];
                    $order_total += $request->input('quantity.'.$m) * $service->price;
                }
                
            }
            
            $n = count($request->input('special_item_services'));
            for($m=0; $m < $n ; $m++ ) {
                
                if( !empty($request->input('special_item_services.'.$m)) && !empty($request->input('special_item_service_quantity.'.$m)) )
                {
                    $service = $customer->serviceScheme($request->input('special_item_services.'.$m));
                    $order_snapshot[] = ["service_id"=>$request->input('special_item_services.'.$m),"service_name"=>" $service->service_name","service_quantity"=>$request->input('special_item_service_quantity.'.$m),"service_price"=>$request->input('special_item_service_price.'.$m)];
                    $order_total += $request->input('special_item_service_quantity.'.$m) * $request->get('special_item_service_price.'.$m);
                }
            }
            
       
            $order_snapshot = json_encode($order_snapshot);
        

            $lubebay = Lubebay::find($request->input('lubebay'));
            $payment = $request->input('payment');
            
            $new_lst = new LubebayServiceTransaction;

            $new_lst->user_id = Auth::user()->id;
            $new_lst->comment = $request->input('comment');
            $new_lst->lubebay_id = $lubebay->id;
            $new_lst->total_amount = $order_total;
            $new_lst->bank_reference = $request->input('bank_reference');
            $new_lst->order_snapshot = $order_snapshot;
            
            
            $new_lst->current_approval ='l0';
            $new_lst->final_approval = "l1";
            $new_lst->approval_status = "AWAITING_CONFIRMATION";
           
            //automatically l1 apporove
            // $new_lst->current_approval ="l1" ; 
            // $new_lst->final_approval = "l1";
            // $new_lst->approval_status = 'CONFIRMED';

            DB::beginTransaction();
            try
            {                
                $new_lst->save();
                $new_approval_tracker = new Approval;

                $new_approval_tracker->process_type = "LST";
                $new_approval_tracker->process_id = $new_lst->id;
                $new_approval_tracker->l0 = Auth::user()->id;
                //automatically approve li
                //$new_approval_tracker->l1 = Auth::user()->id;
                $new_approval_tracker->save();

                $post_status = "SUCCESS";
                $post_status_message = " Daily transaction has been submitted with id:".$new_lst->id." an is currently awaiting approval awaiting approval";
            }
            catch(Exception $e)
            {

                DB::rollback();
                $post_status = "FAILED";
                $post_status_message = "LST generation failed";
                throw $e;
                $view_data['post_status'] = $post_status;
                $view_data['post_status_message'] = $post_status_message;
                
                return view('lst',$view_data);
                
            }
            DB::commit();

            $view_data['lst'] = $new_lst;
            $view_data['post_status'] = $post_status;
            $view_data['post_status_message'] = $post_status_message;
            
            return view('view_lst_details',$view_data);
            




        }
           

    
        return view('lst',$view_data);
    }

    public function viewTransactions(){
        $view_data = [];
        $view_data['services'] = Service::all();
        //$view_data['lst_list'] = LubebayServiceTransaction::where('APPROVAL_STATUS','AWAITING_CONFIRMATION')->get();
        $lubebays = Auth::user()->allowedLubebays();
        $lst_list = new Collection();
        foreach ($lubebays as $lubebay) {
            foreach ($lubebay->lsts as $lst) {
                $lst_list->push($lst);
            }
           
        }
       // return $lst_list;
        $view_data['lst_list'] = $lst_list;
        $view_data['lubebays']  = $lubebays;
        //$view_data['customers'] = Customer::where();
        $post_status = "NONE";
        $post_status_message = "NONE";
        $view_data['post_status'] = $post_status;
        $view_data['post_status_message'] = $post_status_message;
        return view('view_approve_lst',$view_data);
    }

    public function lstDetails(LUbebayServiceTransaction $lst){
        $view_data['lst'] = $lst;
        return view('view_lst_details', $view_data);
        
    }

    public function lubebayLodgement(Request $request, Lubebay $lubebay){
        $post_status = new PostStatusHelper;
        $view_data['lubebay'] = $lubebay;
        $view_data['expense_types'] = LubebayExpenseType::all();
        if($request->isMethod('post')){
            //add check for accidental double post / additional paymment fter amount is covered.
            $request->validate([
                'payment_amount' => 'required |numeric',
                'bank_reference' => 'required',
                'related_lsts' => 'required|array|min:1'
            ],[
                'related_lsts.required' => "Select the Date(s) this lodgeent for"
            ]);
        $payment_amount = $request->get('payment_amount') ;
        //die("lst payment class jsut befor thecommmit order trnsaction class");
        // part of the old lubaby transaction classssssss
       // $lubebay_transaction = new CommitLubebayTransaction;
       DB::beginTransaction();
       try {
                $account_transaction = new AccountTransactionClass;
                $account_transaction_id = $account_transaction->new_transaction($lubebay->account->id, $related_process="LST_LODGEMENT", $related_process_id=null ,$transaction_type="CREDIT",$transaction_amount=$payment_amount,$payment_comment="",$bank_reference=$request->input('bank_reference'), $approved=false);
                // return '-'.$account_transaction_id;
                // die();
                if($account_transaction_id)
                {
                    foreach(LubebayServiceTransaction::find($request->input('related_lsts')) as $lst){
                    // print('before'.$sst->transaction_id.'<br>');
                    $lst->transaction_id = $account_transaction_id;
                    $lst->save();
                    // print('after'.$sst->transaction_id.'<br>');
                    // die();
                    }
                    $post_status->success();
                    
                    

                }
                else {  
                    $post_status->failed();
                    $view_data['post_status'] = $post_status->post_status;
                    $view_data['post_status_message'] = $post_status->post_status_message;
                    throw Exception('accont transaction failed');

                }
        
                $n = count($request->get('expense'));
                
                for($m=0; $m < $n ; $m++ ) {
                // print_r($request->input('quantity.'.$m));
                    if( !empty($request->input('expense.'.$m)) && !empty($request->input('expense_type.'.$m)) && !empty($request->input('expense_amount.'.$m))  )
                    {
                        //die(print_r( $request->input('expense_type.'.$m) ));
                        $new_expense = new LubebayExpense;
                        $new_expense->name = $request->input('expense.'.$m);
                        $new_expense->amount = $request->input('expense_amount.'.$m);
                        $new_expense->lubebay_id = $lubebay->id;
                        $new_expense->user_id = Auth::user()->id;
                        $new_expense->expense_type_id = $request->input('expense_type.'.$m);
                        $new_expense->related_process = "LST_LODGEMEMNT";
                        $new_expense->process_id = $account_transaction_id;
                        $new_expense->expense_type = LubebayExpenseType::find( $request->input('expense_type.'.$m) )->name;
                        
                        //auto approve
                        $new_expense->current_approval = "l1";
                        $new_expense->final_approval = "l1";
                        $new_expense->approval_status = "APPROVED";
                        //new code above to auto approve
                        // $new_expense->current_approval = "l0";
                        // $new_expense->final_approval = "l1";
                        // $new_expense->approval_status = "AWAITING_APPROVAL";
                        $new_expense->save();

                        $new_expense_approval_tracker = new Approval;
                        $new_expense_approval_tracker->process_type = "LUBEBAY_EXPENSE";
                        $new_expense_approval_tracker->process_id = $new_expense->id;
                        $new_expense_approval_tracker->l0 = Auth::user()->id;
                        $new_expense_approval_tracker->l1 = Auth::user()->id;
                        $new_expense_approval_tracker->save();
                    }
                    
                }
            } 
            catch (Exceptrion $e) {
                DB::rollback();
                DB:commit();
                throw $e;
                return view('lubebay_lodgement',$view_data);
            }
            DB::commit();
            return view('lubebay_lodgement_history',$view_data);
        }

       
        

        $view_data['post_status'] = $post_status->post_status;
        $view_data['post_status_message'] = $post_status->post_status_message;
        return view('lubebay_lodgement',$view_data);
        // Old lube transactions entry
         // if($lubebay_transaction->lubebayTransaction("LST_LODGEMENT",$lst->id, $lst->lubebay_id, "CREDIT",$payment_amount,"lodgemnt for services",$request->input('bank_reference') ))
        // {
        //     $post_status->success();
        // }
        // else {
        //     $post_status->failed();
            
        // }

        // $view_data['post_status'] = $post_status->post_status;
        // $view_data['post_status_message'] = $post_status->post_status_message;
        // return view('lst_lodgement',$view_data);

        // }
    
        
        // return view('lst_lodgement',$view_data);
    }
    public function lubebayLodgementHistory(Lubebay $lubebay){
        $view_data['lubebay'] = $lubebay;

        return view('lubebay_lodgement_history',$view_data);
        //return $lubebay->lodgements();
    }
    public function lubebaySalesLodgementHistory(Lubebay $lubebay){
        $start_time= now()->startOfMonth()->startOfDay() ;
        $end_time = now();
        $view_data['lubebay'] = $lubebay;

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
                'sales'=>$lubebay->total_sales($start_of_day, $end_of_day ),
                'lodgement'=>$lubebay->total_lodgements($start_of_day, $end_of_day ),
                'underlodgement' =>  $lubebay->total_sales($start_time,$end_of_day) - $lubebay->total_lodgements($start_time,$end_of_day)
                ]
            );

        }
        $view_data['sales_lodgement_history'] = $sales_lodgement_history;

        return view('lubebay_sales_lodgement_history',$view_data);
        //return $lubebay->ssts->where('created_at', '>=', $start_time)->where('created_at', '<=', $end_time;
    }
    public function lubebayLodgementLubebays(){
        $view_data['lubebays_list'] = Auth::user()->allowedLubebays();
        return view('lubebay_lodgement_lubebays',$view_data);
    }

    public function lstLodgementList(){
        $view_data = [];
        $view_data['services'] = Service::all();
        $view_data['substores'] = Lubebay::all();
        $view_data['lst_list'] = LubebayServiceTransaction::all();//LubebayServiceTransaction::where('APPROVAL_STATUS','AWAITING_CONFIRMATION')->get();
        
        //$view_data['customers'] = Customer::where();
        $post_status = "NONE";
        $post_status_message = "NONE";
        $view_data['post_status'] = $post_status;
        $view_data['post_status_message'] = $post_status_message;
        return view('lst_lodgement_list',$view_data);
    }

    public function viewLubebays(){
        $view_data['lubebays_list'] = Auth::user()->allowedLubebays();
        return view('stations_lubebays_summery_cards',$view_data);
    } 

    public function viewlubebay(Lubebay $lubebay){
        $view_data['lst_list'] =  LubebayServiceTransaction::where('lubebay_id',$lubebay->id)->whereBetween('created_at',[now()->startOfMonth , now()->endOfMonth])->get();
    }

    public function lubebays()
    {
        $view_data['lubebay_list'] = Lubebay::all();

        return view('view_lubebay', $view_data);
    }

    public function deleteLubebay($lid)
    {
        $view_data['lubebay_delete_data'] = Lubebay::where('id', $lid)->get();
        return view('lubebay_delete_prompt', $view_data);
    }

    public function instDeleteLubebay($cid, Request $request)
    {
        $lubebay_delete = Lubebay::where('id', $cid)->delete();
        if ($lubebay_delete) {
            $request->session()->flash('status', 'Lubebay Deleted!');
            return redirect('/lubebays/view');
        }else{
            $request->session()->flash('status', 'Error Deleting!');
            return redirect('/lubebays/view');
        }
    }
}
