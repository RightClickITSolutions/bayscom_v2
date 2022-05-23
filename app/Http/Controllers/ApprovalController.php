<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
Use Illuminate\Support\Collection ;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;

                    
use App\User;
use App\Models\Pro;
use App\Models\Prf;
use App\Models\Substore;
use App\Models\Warehouse;
use App\Models\SubstoreTransaction;
use App\Models\LubebayServiceTransaction;
use App\Models\Approval;
use App\Models\Expense;
use App\Models\LubebayExpense;
use App\Models\CustomerTransaction;
use App\Models\AccountTransaction;
use App\Models\Account;
use App\Models\StockTransfer;

use App\Http\Controllers\Custom\CommitSubstoreTransaction;
use App\Http\Controllers\Custom\CommitLubebayTransaction;
use App\Http\Controllers\Custom\AccountTransactionClass;
use App\Http\Controllers\Custom\CommitOrderTransaction;

use App\Helpers\PostStatusHelper;
use App\Notifications\PrfNotification;
use App\Notifications\ProNotification;


class ApprovalController extends Controller
{

    public function substoreInvetoryAlailability($sst){
        $sst_products = json_decode($sst->sales_snapshot);
        $low_inventory_items = [];
        $errors = new MessageBag();
        foreach($sst_products as $sst_product){
            $sst_product_inventory = Substore::find($sst->substore_id)->productInventory($sst_product->product_id);
            if($sst_product_inventory < $sst_product->product_quantity ){
                //$low_inventory_items[$sst_product->product_name] = 'The quntity of '.$sst_product->product_name. 'cannot be satisfied by the inventory. available qty:'.$sst_product_inventory.' sales qty: '.$sst_product->product_id.' ';
              $errors->add($sst_product->product_name, 'The quntity of '.$sst_product->product_name. ' cannot be fulfiled by the inventory. ( Available qty: '.$sst_product_inventory.' | Sales qty: '.$sst_product->product_id.' )');
            }
        }
        if(count($errors)==0){
            return true;
        }
        else{
            
            return $errors;
        }
    }

    public function warehouseInvetoryAlailability($prf){
        $prf_products = json_decode($prf->order_snapshot);
        $low_inventory_items = [];
        $errors = new MessageBag();
        foreach($prf_products as $prf_product){
            $prf_product_inventory = Warehouse::find($prf->warehouse_id)->productInventory($prf_product->product_id);
            if($prf_product_inventory < $prf_product->product_quantity ){
                //$low_inventory_items[$prf_product->product_name] = 'The quntity of '.$prf_product->product_name. 'cannot be satisfied by the inventory. available qty:'.$prf_product_inventory.' sales qty: '.$prf_product->product_id.' ';
              $errors->add($prf_product->product_name, 'The quntity of '.$prf_product->product_name. ' cannot be fulfiled by the inventory. ( Available qty: '.$prf_product_inventory.' | Order qty: '.$prf_product->product_quantity.' )');
            }
        }
        if(count($errors)==0){
            return true;
        }
        else{
            
            return $errors;
        }
    }
    public function warehouseTransferInvetoryAlailability($stock_transfer){
        $stock_transfer_products = json_decode($stock_transfer->transfer_snapshot);
        $low_inventory_items = [];
        $errors = new MessageBag();
        foreach($stock_transfer_products as $stock_transfer_product){
            $stock_transfer_product_inventory = Warehouse::find($stock_transfer->originating_entity_id)->productInventory($stock_transfer_product->product_id);
            if($stock_transfer_product_inventory < $stock_transfer_product->product_quantity ){
                //$low_inventory_items[$stock_transfer_product->product_name] = 'The quntity of '.$stock_transfer_product->product_name. 'cannot be satisfied by the inventory. available qty:'.$stock_transfer_product_inventory.' sales qty: '.$stock_transfer_product->product_id.' ';
              $errors->add($stock_transfer_product->product_name, 'The quntity of '.$stock_transfer_product->product_name. ' cannot be fulfiled by the inventory. ( Available qty: '.$stock_transfer_product_inventory.' | Order qty: '.$stock_transfer_product->product_quantity.' )');
            }
        }
        if(count($errors)==0){
            return true;
        }
        else{
            
            return $errors;
        }
    }

    public function proSageBalanceAvailability($pro){
        $sage_account = Account::where('account_name','MOFAD_SAGE')->where('account_type','MAIN')->first();
        $sage_account_balance = $sage_account->balance;
        $low_inventory_items = [];
        $errors = new MessageBag();
        if($sage_account_balance < $pro->order_total){
            $errors->add("Sage Balance", 'Insufficent funsds in sage account to process order| Order Amount: '.$pro->order_total.'  | Sage Balance: '.$sage_account_balance);
        }
        
        if(count($errors)==0){
            return true;
        }
        else{
            
            return $errors;
        }
    }
   
    //
    public function pro(Request $request){
        $view_data = [];
        $pro = Pro::find($request->get('process_id'));
        //approval/permission name and level syntax 
        // "approve_pro_".$level
        $level = $request->get('level');
        //return Auth::user()->getPermissionNames();
            if(Auth::user()->hasPermissionTo('approve_pro_'.$level ) && $level > $pro->current_approval){
                
                
                if($request->get('approval')=='APPROVE')
                {
                   

                    if($this->proSageBalanceAvailability($pro)===true){
                        $sage_account = Account::where('account_name','MOFAD_SAGE')->where('account_type','MAIN')->first();
                    
                        DB::beginTransaction();
                        try
                        {   
                            

                            //case swith for approval status depending on the approval level
                            if($level == $pro->final_approval){
                                $approval_status="APPROVED_NOT_COLLECTED";
                                $debit_sage_account =  new AccountTransactionClass;

                                if(!$debit_sage_account->new_transaction($account_id=$sage_account->id, $related_process="PRO", $related_process_id=$pro->id,$transaction_type="DEBIT",$pro->order_total,$payment_comment="PRO",$bank_reference="", true)){
                                    throw new Exception('Sage Account could not be debited');
                                }
                            }
                            elseif($level=='l1'){$approval_status="PROCESSING";}
                            elseif($level=='l2'){$approval_status="APPROVED_NOT_COLLECTED";}
                            else{$approval_status="UNKNOWN";}
                            
                            $pro->current_approval=$level;
                            $pro->approval_status = $approval_status;
                            $pro->save();
                            $pro_approval = Approval::where('process_id',$pro->id)->where('process_type',$request->get('process_type'))->first();
                            $pro_approval->{$level}= Auth::user()->id;             
                            $pro_approval->save();
                            $post_status = "SUCCESS";
                            $post_status_message = " Succesfully updated";
                            
                            if($level == $pro->final_approval){
                                $storekeepers  = User::permission('storekeeper')->get();
                                foreach($storekeepers as $key => $storekeeper){
                                    if(!$storekeeper->canAccessWarehouse($pro->warehouse_id)){
                                        $storekeepers->forget($key);
                                    }
                                }

                                $storekeepers->push(User::find($pro->user_id));
                                Notification::send($storekeepers, new ProNotification($pro));
                            }
                            elseif($level=='l1'){ Notification::send(User::permission('approve_pro_l2')->get(), new ProNotification($pro));}
                            elseif($level=='l2'){ }
                            else{}
                        }
                        catch(Exception $e)
                        {
            
                            DB::rollback();
                            $post_status = "FAILED";
                            $post_status_message = "Operation failed";
                            throw $e;
                        }
                        DB::commit();
                    }    
                    else{

                        $post_status = "FAILED";
                        $post_status_message = "Insufficient funds in sage Account";
                        $view_data['errors'] = $this->proSageBalanceAvailability($pro);
                    }
                    $view_data['post_status'] = $post_status;
                    $view_data['post_status_message'] = $post_status_message;
                    $view_data['pro_list'] = Pro::all();
                    return redirect('view-pro')->with($view_data );
                }
                elseif($request->get('approval')=='DECLINE'){
                    DB::beginTransaction();
                    try
                    {   $pro = Pro::find($request->get('process_id'));
                        $pro->current_approval=$level;
                        $pro->approval_status='DECLINED';
                        $pro->save();
                        $pro_approval = Approval::where('process_id',$pro->id)->where('process_type',$request->get('process_type'))->first();
                        $pro_approval->{$level} = Auth::user()->id;             
                        $pro_approval->save();
                        $pro->delete();
                        $post_status = "SUCCESS";
                        $post_status_message = " Succesfully updated";
                    }
                    catch(Exception $e)
                    {
        
                        DB::rollback();
                        $post_status = "FAILED";
                        $post_status_message = "Operation failed";
                        throw $e;
                    }
                    DB::commit();
                    $view_data['post_status'] = $post_status;
                    $view_data['post_status_message'] = $post_status_message;
                    $view_data['pro_list'] = Pro::all();
                    return redirect('view-pro')->with('view_data',$view_data) ;
                }    
            }
            else{
                 abort(403);
            }

        
    }

    public function prf(Request $request){
        $view_data = [];

        //approval/permission name and level syntax 
        // "approve_prf_".$level
        $level = $request->get('level');
        

            if(Auth::user()->hasPermissionTo('approve_prf_'.$level)){
                if($request->get('approval')=='APPROVE')
                {
                    $prf = Prf::find($request->get('process_id'));
                    //to make sure that after storekeeper isses it is not re approved from a ligereing page renderig it unissued again
                    if($prf->approval_status != "APPROVED_COLLECTED")
                        if($this->warehouseInvetoryAlailability($prf)===true){

                            DB::beginTransaction();
                            try
                            {   
                                $prf = Prf::find($request->get('process_id'));
                                
                                //case swith for approval status depending on the approval level
                                if($level == $prf->final_approval){$approval_status="APPROVED_NOT_COLLECTED";}
                                elseif($level=='l1'){$approval_status="PROCESSING";}
                                elseif($level=='l2'){$approval_status="APPROVED_NOT_COLLECTED";}
                                else{$approval_status="UNKNOWN";}

                                $prf->current_approval = $level;
                                $prf->approval_status = $approval_status;
                                $prf->save();
                                $prf_approval = Approval::where('process_id',$prf->id)->where('process_type',$request->get('process_type'))->first();
                                $prf_approval->{$level}= Auth::user()->id;             
                                $prf_approval->save();
                                $post_status = "SUCCESS";
                                $post_status_message = " Succesfully updated";

                                if($level == $prf->final_approval){
                                    $storekeepers  = User::permission('storekeeper')->get();
                                    foreach($storekeepers as $key => $storekeeper){
                                        if(!$storekeeper->canAccessWarehouse($prf->warehouse_id)){
                                            $storekeepers->forget($key);
                                        }
                                    }
                                    $storekeepers->push(User::find($prf->sales_rep));
                                    Notification::send($storekeepers, new PrfNotification($prf));
                                }
                                elseif($level=='l1'){ Notification::send(User::permission('approve_prf_l2')->get(), new PrfNotification($prf));}
                                elseif($level=='l2'){ }
                                else{}
                            
                            }
                            catch(Exception $e)
                            {
                
                                DB::rollback();
                                $post_status = "FAILED";
                                $post_status_message = "Operation failed";
                                throw $e;
                            }
                            DB::commit();
                        }
                        else{

                            $post_status = "FAILED";
                            $post_status_message = "Please Decline, order Exceeds Inventory";
                            $view_data['errors'] = $this->warehouseInvetoryAlailability($prf);
                        }
                    else{

                        $post_status = "FAILED";
                        $post_status_message = "This PRF Has Already Been Approved and Issued";
                        
                    }
                    $view_data['post_status'] = $post_status;
                    $view_data['post_status_message'] = $post_status_message;
                    $prf_list = Prf::all()->whereIn('warehouse_id',json_decode(Auth::user()->accessibleEntities()->warehouses));
                    $view_data['prf_list'] = $prf_list;
                    

                    return view('view_approve_prf',$view_data);
                }
                elseif($request->get('approval')=='DECLINE'){
                    DB::beginTransaction();
                    try
                    {   $prf = Prf::find($request->get('process_id'));
                        $prf->current_approval= $level;
                        $prf->approval_status='DECLINED';
                        $prf->save();
                        $prf_approval = Approval::where('process_id',$prf->id)->where('process_type',$request->get('process_type'))->first();
                        $prf_approval->{$level} = Auth::user()->id;             
                        $prf_approval->save();
                        $prf->delete();
                        $post_status = "SUCCESS";
                        $post_status_message = " Succesfully updated";
                    }
                    catch(Exception $e)
                    {
        
                        DB::rollback();
                        $post_status = "FAILED";
                        $post_status_message = "Operation failed";
                        throw $e;
                    }
                    DB::commit();

                    $view_data['post_status'] = $post_status;
                    $view_data['post_status_message'] = $post_status_message;
                    $view_data['prf_list'] = Prf::all();
                    return redirect('view-prf')->with('view_data', $view_data) ;
                }    
            }
            else{
                return abort(403);
            }

        
    }

    public function warehouseTransfer(Request $request){
        $view_data = [];

        //approval/permission name and level syntax 
        // "approve_prf_".$level
        $level = $request->get('level');
        

            if(Auth::user()->hasPermissionTo('approve_prf_'.$level)){
                if($request->get('approval')=='APPROVE')
                {
                    $stock_transfer = StockTransfer::find($request->get('process_id'));

                    if($this->warehouseTransferInvetoryAlailability($stock_transfer)===true){

                        DB::beginTransaction();
                        try
                        {   
                            $stock_transfer = StockTransfer::find($request->get('process_id'));
                            
                            //case swith for approval status depending on the approval level
                            if($level == $stock_transfer->final_approval){$approval_status="APPROVED_NOT_COLLECTED";}
                            elseif($level=='l1'){$approval_status="PROCESSING";}
                            elseif($level=='l2'){$approval_status="APPROVED_NOT_COLLECTED";}
                            else{$approval_status="UNKNOWN";}

                            $stock_transfer->current_approval = $level;
                            $stock_transfer->approval_status = $approval_status;
                            $stock_transfer->save();
                            $stock_transfer_approval = Approval::where('process_id',$stock_transfer->id)->where('process_type',$request->get('process_type'))->first();
                            $stock_transfer_approval->{$level}= Auth::user()->id;             
                            $stock_transfer_approval->save();
                            $post_status = "SUCCESS";
                            $post_status_message = " Succesfully updated";

                            if($level == $stock_transfer->final_approval){
                                $storekeepers  = User::permission('storekeeper')->get();
                                foreach($storekeepers as $key => $storekeeper){
                                    if(!$storekeeper->canAccessWarehouse($stock_transfer->originating_warehouse)){
                                        $storekeepers->forget($key);
                                    }
                                }
                                $storekeepers->push(User::find($stock_transfer->user_id));
                                //Notification::send($storekeepers, new stock_transferNotification($stock_transfer));
                            }
                            elseif($level=='l1'){ Notification::send(User::permission('approve_stock_transfer_l2')->get(), new stock_transferNotification($stock_transfer));}
                            elseif($level=='l2'){ }
                            else{}
                        
                        }
                        catch(Exception $e)
                        {
            
                            DB::rollback();
                            $post_status = "FAILED";
                            $post_status_message = "Operation failed";
                            throw $e;
                        }
                        DB::commit();
                    }
                    else{

                        $post_status = "FAILED";
                        $post_status_message = "Please Decline, order Exceeds Inventory";
                        $view_data['errors'] = $this->warehouseTransferInvetoryAlailability($stock_transfer);
                    }
                
                    $view_data['post_status'] = $post_status;
                    $view_data['post_status_message'] = $post_status_message;
                    $stock_transfer_list = StockTransfer::all()->whereIn('originating_entity_id',json_decode(Auth::user()->accessibleEntities()->warehouses));
                    $view_data['stock_transfer_list'] = $stock_transfer_list;
                    

                    return view('view_approve_stock_transfer',$view_data);
                }
                elseif($request->get('approval')=='DECLINE'){
                    DB::beginTransaction();
                    try
                    {   $stock_transfer = StockTransfer::find($request->get('process_id'));
                        $stock_transfer->current_approval= $level;
                        $stock_transfer->approval_status='DECLINED';
                        $stock_transfer->save();
                        $stock_transfer_approval = Approval::where('process_id',$stock_transfer->id)->where('process_type',$request->get('process_type'))->first();
                        $stock_transfer_approval->{$level} = Auth::user()->id;             
                        $stock_transfer_approval->save();
                        $stock_transfer->delete();
                        $post_status = "SUCCESS";
                        $post_status_message = " Succesfully updated";
                    }
                    catch(Exception $e)
                    {
        
                        DB::rollback();
                        $post_status = "FAILED";
                        $post_status_message = "Operation failed";
                        throw $e;
                    }
                    DB::commit();

                    $view_data['post_status'] = $post_status;
                    $view_data['post_status_message'] = $post_status_message;
                    $view_data['stock_transfer_list'] = StockTransfer::all();
                    return redirect('view-stock-transfer')->with('view_data', $view_data) ;
                }    
            }
            else{
                return abort(403);
            }

        
    }


    public function sst(Request $request){
        $view_data = [];

        //approval/permission name and level syntax 
        // "approve_pro_".$level
            $level = $request->input('level');
            //debug
            $permission_name = 'approve_sst_'.$level;
            //die($permission_name);
            if(Auth::user()->hasPermissionTo('approve_sst_l1')){
                $sst = SubstoreTransaction::find($request->get('process_id'));
                if($sst->approval_status == 'CONFIRMED')
                {
                   throw ValidationException::withMessages(['Approval' => 'This sales entry Has Already been confirmed']);
                }
                elseif($sst->approval_status == 'DECLINED'){
                    throw ValidationException::withMessages(['Approval' => 'This sales entry Has already been declined']);

                }
                else{
                    if($request->get('approval')=='APPROVE')
                    {

                        if($this->substoreInvetoryAlailability($sst)===true){

                        
                            DB::beginTransaction();
                            try
                            {   
                                $sst = SubstoreTransaction::find($request->get('process_id'));

                                //case swith for approval status depending on the approval level
                                if($level == $sst->final_approval){$approval_status="CONFIRMED";}
                                elseif($level='l1'){$approval_status="CONFIRMED";}
                                else{$approval_status="UNKNOWN";}
                                
                                $sst->current_approval=$level;
                                $sst->approval_status = $approval_status;
                                $sst->save();
                                $sst_approval = Approval::where('process_id',$sst->id)->where('process_type',$request->get('process_type'))->first();
                                $sst_approval->{$level}= Auth::user()->id;             
                                $sst_approval->save();
                                $post_status = "SUCCESS";
                                $post_status_message = " Succesfully updated";

                                $new_stock_transaction = new CommitSubstoreTransaction;
                                $new_stock_transaction->stockTransaction($sst->id,"DEBIT");
                            }
                            catch(Exception $e)
                            {
                
                                DB::rollback();
                                $post_status = "FAILED";
                                $post_status_message = "Operation failed";
                                throw $e;
                            }
                            DB::commit();
                        }
                        else{

                            $post_status = "FAILED";
                            $post_status_message = "Please Decline. Sales order Exceeds Inventory";
                            $view_data['errors'] = $this->substoreInvetoryAlailability($sst);
                        }
                        

                        $view_data['post_status'] = $post_status;
                        $view_data['post_status_message'] = $post_status_message;
                        $view_data['sst_list'] = SubstoreTransaction::all();
                        return view('view_approve_sst',$view_data);
                        //return $this->substoreInvetoryAlailability($sst);
                    }
                    elseif($request->get('approval')=='DECLINE'){
                        DB::beginTransaction();
                        try
                        {   $sst = SubstoreTransaction::find($request->get('process_id'));
                            $sst->current_approval=$level;
                            $sst->approval_status='DECLINED';
                            $sst->save();
                            $sst_approval = Approval::where('process_id',$sst->id)->where('process_type',$request->get('process_type'))->first();
                            $sst_approval->{$level} = Auth::user()->id;             
                            $sst_approval->save();
                            $sst->delete();
                            $post_status = "SUCCESS";
                            $post_status_message = " Succesfully updated";
                        }
                        catch(Exception $e)
                        {
            
                            DB::rollback();
                            $post_status = "FAILED";
                            $post_status_message = "Operation failed";
                            throw $e;
                        }
                        DB::commit();
                        $view_data['post_status'] = $post_status;
                        $view_data['post_status_message'] = $post_status_message;
                        $view_data['sst_list'] = SubstoreTransaction::all();
                        return view('view_approve_sst',$view_data) ;
                    }    
                }
                    
            }
            else{
                return abort(403);
            }

        
    }

    public function expense(Request $request){
        $view_data = [];

        //approval/permission name and level syntax 
        // "approve_pro_".$level
            $level = $request->get('level');
            //debug
            //die('approve_sst_'.$level);
            if(Auth::user()->hasPermissionTo('approve_expense_'.$level)){
                
                
                if($request->get('approval')=='APPROVE')
                {
                    DB::beginTransaction();
                    try
                    {   
                        $expense = Expense::find($request->get('process_id'));

                        //case swith for approval status depending on the approval level
                        if($level == $expense->final_approval){$approval_status="APPROVED";}
                        elseif($level='l1'){$approval_status="APPROVED";}
                        else{$approval_status="UNKNOWN";}
                        
                        $expense->current_approval=$level;
                        $expense->approval_status = $approval_status;
                        $expense->save();
                        $expense_approval = Approval::where('process_id',$expense->id)->where('process_type',$request->get('process_type'))->first();
                        $expense_approval->{$level}= Auth::user()->id;             
                        $expense_approval->save();
                        $post_status = "SUCCESS";
                        $post_status_message = " Succesfully updated";

                    }
                    catch(Exception $e)
                    {
        
                        DB::rollback();
                        $post_status = "FAILED";
                        $post_status_message = "Operation failed";
                        throw $e;
                    }
                    DB::commit();
                    $view_data['post_status'] = $post_status;
                    $view_data['post_status_message'] = $post_status_message;
                    $view_data['expense_list'] = Expense::all();
                    return redirect('/expense/view-expenses')->with($view_data );
                }
                elseif($request->get('approval')=='DECLINE'){
                    DB::beginTransaction();
                    try
                    {   $expense = Expense::find($request->get('process_id'));
                        $expense->current_approval=$level;
                        $expense->approval_status='DECLINED';
                        $expense->save();
                        $expense_approval = Approval::where('process_id',$expense->id)->where('process_type',$request->get('process_type'))->first();
                        $expense_approval->{$level} = Auth::user()->id;             
                        $expense_approval->save();
                        $expense->delete();
                        $post_status = "SUCCESS";
                        $post_status_message = " Succesfully updated";
                    }
                    catch(Exception $e)
                    {
        
                        DB::rollback();
                        $post_status = "FAILED";
                        $post_status_message = "Operation failed";
                        throw $e;
                    }
                    DB::commit();
                    $view_data['post_status'] = $post_status;
                    $view_data['post_status_message'] = $post_status_message;
                    $view_data['expense_list'] = Expense::all();
                    return redirect('/expense/view-expenses')->with($view_data) ;
                }    
            }
            else{
                return error(403);
            }

        
    }

    public function lubebayExpense(Request $request){
        $view_data = [];

        //approval/permission name and level syntax 
        // "approve_pro_".$level
            $level = $request->get('level');
            //debug
            //die('approve_sst_'.$level);
            if(Auth::user()->hasPermissionTo('approve_sst_'.$level)){
                
                
                if($request->get('approval')=='APPROVE')
                {
                    DB::beginTransaction();
                    try
                    {   
                        $lubebay_expense = LubebayExpense::find($request->get('process_id'));

                        //case swith for approval status depending on the approval level
                        if($level == $lubebay_expense->final_approval){$approval_status="APPROVED";}
                        elseif($level='l1'){$approval_status="APPROVED";}
                        else{$approval_status="UNKNOWN";}
                        
                        $lubebay_expense->current_approval=$level;
                        $lubebay_expense->approval_status = $approval_status;
                        $lubebay_expense->save();
                        $lubebay_expense_approval = Approval::where('process_id',$lubebay_expense->id)->where('process_type',$request->get('process_type'))->first();
                        $lubebay_expense_approval->{$level}= Auth::user()->id;             
                        $lubebay_expense_approval->save();
                        $post_status = "SUCCESS";
                        $post_status_message = " Succesfully updated";

                    }
                    catch(Exception $e)
                    {
        
                        DB::rollback();
                        $post_status = "FAILED";
                        $post_status_message = "Operation failed";
                        throw $e;
                    }
                    DB::commit();
                    $view_data['post_status'] = $post_status;
                    $view_data['post_status_message'] = $post_status_message;
                    $view_data['expense_list'] = Expense::all();
                    return redirect('/lubebay/expense/view-expenses')->with($view_data );
                }
                elseif($request->get('approval')=='DECLINE'){
                    DB::beginTransaction();
                    try
                    {   $expense = LubebayExpense::find($request->get('process_id'));
                        $expense->current_approval=$level;
                        $expense->approval_status='DECLINED';
                        $expense->save();
                        $expense_approval = Approval::where('process_id',$expense->id)->where('process_type',$request->get('process_type'))->first();
                        $expense_approval->{$level} = Auth::user()->id;             
                        $expense_approval->save();
                        $expense->delete();
                        $post_status = "SUCCESS";
                        $post_status_message = " Succesfully updated";
                    }
                    catch(Exception $e)
                    {
        
                        DB::rollback();
                        $post_status = "FAILED";
                        $post_status_message = "Operation failed";
                        throw $e;
                    }
                    DB::commit();
                    $view_data['post_status'] = $post_status;
                    $view_data['post_status_message'] = $post_status_message;
                    $view_data['expense_list'] = Expense::all();
                    return redirect('/expense/view-expenses')->with($view_data) ;
                }    
            }
            else{
                return abort(403);
            }

        
    }

    public function lst(Request $request){
        $view_data = [];

        //approval/permission name and level syntax 
        // "approve_pro_".$level
            $level = $request->input('level');
            //debug
            //die('approve_lst_'.$level);
            if(Auth::user()->hasPermissionTo('approve_lst_l1')){
                
                
                if($request->input('approval')=='APPROVE')
                {
                    DB::beginTransaction();
                    try
                    {   
                        $lst = LubebayServiceTransaction::find($request->get('process_id'));

                        //case swith for approval status depending on the approval level
                        if($level == $lst->final_approval){$approval_status="CONFIRMED";}
                        elseif($level='l1'){$approval_status="CONFIRMED";}
                        else{$approval_status="UNKNOWN";}
                        
                        $lst->current_approval=$level;
                        $lst->approval_status = $approval_status;
                        $lst->save();
                        $lst_approval = Approval::where('process_id',$lst->id)->where('process_type',$request->get('process_type'))->first();
                        $lst_approval->{$level}= Auth::user()->id;             
                        $lst_approval->save();
                        $post_status = "SUCCESS";
                        $post_status_message = " Succesfully updated";

                        $new_stock_transaction = new CommitLubebayTransaction;
                        $new_stock_transaction->lubebayTransaction('LST',$lst->id,$lst->lubebay_id,"CREDIT",$lst->total_amount,"Confirmed sales");
                    }
                    catch(Exception $e)
                    {
        
                        DB::rollback();
                        $post_status = "FAILED";
                        $post_status_message = "Operation failed";
                        throw $e;
                        die('error caught');
                    }
                    DB::commit();
                    $view_data['post_status'] = $post_status;
                    $view_data['post_status_message'] = $post_status_message;
                    
                    ///accessible lsts
                    $lubebays = Auth::user()->allowedLubebays();                  
                    $lst_list = new Collection();
                    foreach ($lubebays as $lubebay) {
                        foreach ($lubebay->lsts as $lst) {
                            $lst_list->push($lst);
                        }
                    
                    }
                    $view_data['lst_list'] = $lst_list;

                    //old, shows all atransactions after approval
                    //$view_data['lst_list'] = LubebayServiceTransaction::all();
                    return view('view_approve_lst',$view_data );
                }
                elseif($request->get('approval')=='DECLINE'){
                    DB::beginTransaction();
                    try
                    {   $lst = LubebayServiceTransaction::find($request->get('process_id'));
                        $lst->current_approval=$level;
                        $lst->approval_status='DECLINED';
                        $lst->save();
                        $lst_approval = Approval::where('process_id',$lst->id)->where('process_type',$request->get('process_type'))->first();
                        $lst_approval->{$level} = Auth::user()->id;             
                        $lst_approval->save();
                        $lst->delete();
                        $post_status = "SUCCESS";
                        $post_status_message = " Succesfully updated";
                    }
                    catch(Exception $e)
                    {
        
                        DB::rollback();
                        $post_status = "FAILED";
                        $post_status_message = "Operation failed";
                        throw $e;
                    }
                    DB::commit();
                    $view_data['post_status'] = $post_status;
                    $view_data['post_status_message'] = $post_status_message;
                    $view_data['lst_list'] = LubebayServiceTransaction::all();
                    return view('view_approve_lst',$view_data) ;
                }    
            }
            else{
                return abort(403);
            }

        
    }

    public function lubebayLodgemnt(Request $request){
        $view_data = [];

        //approval/permission name and level syntax 
        // "approve_prf_".$level
        $level = $request->get('level');
        

            if(Auth::user()->hasPermissionTo('confirm_lodgment_'.$level)){
                if($request->get('approval')=='APPROVE')
                {
                    

                    DB::beginTransaction();
                    try
                    {   
                        $account_transaction = AccountTransaction::find($request->get('transaction_id'));
                        $account = Account::findOrFail($account_transaction->account_id);
                        //case swith for approval status depending on the approval level
                        if($level == $account_transaction->final_approval){$approval_status="CONFIRMED";}
                        elseif($level=='l1'){$approval_status="CONFIRMED";}
                        else{$approval_status="UNKNOWN";}

                        if ($account_transaction->transaction_type == 'CREDIT') {
                            $account->balance += $transaction_amount;
                        }
                        elseif ($account_transaction->transaction_type == 'DEBIT') {
                            $account->balance -= $transaction_amount;
                            
                        }
                        
                        else{
                            throw new Exception('invalid transaction_type');
                        }
                        $account_transaction->balance = $account->balance;
                        $account_transaction->save();
                        $account->save();
                    }
                    catch(Exception $e)
                    {
        
                        DB::rollback();
                        $post_status = "FAILED";
                        $post_status_message = "Operation failed";
                        throw $e;
                    }
                    DB::commit();
                    $view_data['post_status'] = $post_status;
                    $view_data['post_status_message'] = $post_status_message;
                    $view_data['prf_list'] = Prf::all();
                    return redirect('view-prf')->with($view_data );
                }
                elseif($request->get('approval')=='DECLINE'){
                    DB::beginTransaction();
                    try
                    {   $account_transaction = AccountTransaction::find($request->get('transaction_id'));
                        
                        $account_transaction->current_approval='$level';
                        $account_transaction->approval_status='DECLINED';
                        $account_transaction->save();
                        $account_transaction_approval = Approval::where('process_id',$account_transaction->id)->where('process_type','ACCOUNT_TRANSACTION')->first();
                        $account_transaction_approval->{$level} = Auth::user()->id;             
                        $account_transaction_approval->save();
                        $account_transaction->delete();
                        $post_status = "SUCCESS";
                        $post_status_message = " Succesfully updated";
                    }
                    catch(Exception $e)
                    {
        
                        DB::rollback();
                        $post_status = "FAILED";
                        $post_status_message = "Operation failed";
                        throw $e;
                    }
                    DB::commit();
                    $view_data['post_status'] = $post_status;
                    $view_data['post_status_message'] = $post_status_message;
                    $view_data['prf_list'] = Prf::all();
                    return redirect('view-prf')->with('view_data', $view_data) ;
                }    
            }
            else{
                return abort(403);
            }
    }

    public function substoreLodgement(Request $request){
        $view_data = [];
        $post_status  = new PostStatusHelper;

        //approval/permission name and level syntax 
        // "approve_prf_".$level
        $level = $request->input('level');
        
            $account_transaction = AccountTransaction::find($request->input('process_id'));
                        
            if(Auth::user()->hasPermissionTo('approve_lodgement_'.$level) && $level > $account_transaction->current_approval){
                if($request->get('approval')=='APPROVE')
                {
                    

                    DB::beginTransaction();
                    try
                    {   
                        $account = Account::find($account_transaction->account_id);
                        $substore =  Substore::find($account->owner_id); 
                        $prf_customer_account = $substore->customerProfile;
                        $substore_customer_lodgement = new CommitOrderTransaction;
                        //case swith for approval status depending on the approval level
                        if($level == $account_transaction->final_approval){
                            $approval_status="CONFIRMED";
                            $substore_customer_lodgement->substoreLodgementCustomerPayment($prf_customer_account, 'CREDIT',$account_transaction->amount, $payment_comment="Customer payment ", $account_transaction->bank_reference);
                        }
                        elseif($level=='l1'){$approval_status="CONFIRMED";}
                        else{$approval_status="UNKNOWN";}
                        $transaction_amount = $account_transaction->amount ;

                        if ($account_transaction->transaction_type == 'CREDIT') {
                            $account->balance += $transaction_amount;
                        }
                        elseif ($account_transaction->transaction_type == 'DEBIT') {
                            $account->balance -= $transaction_amount;
                            
                        }
                        
                        else{
                            throw new Exception('invalid transaction_type');
                        }
                        $account_transaction->balance = $account->balance;
                        $account_transaction->approval_status ='CONFIRMED' ;

                        $account_transaction_approval = Approval::where('process_id',$account_transaction->id)->where('process_type',$request->get('process_type'))->first();
                        $account_transaction_approval->{$level}= Auth::user()->id; 

                        $account_transaction_approval->save();
                        $account_transaction->save();
                        $account->save();
                        $post_status->success();
                    }
                    catch(Exception $e)
                    {
        
                        DB::rollback();
                        $post_status->failed();
                        $post_status_message = "Operation failed";
                        DB::commit();
                        throw $e;
                    }
                    DB::commit();
                    $view_data['post_status'] = $post_status->post_status;
                    $view_data['post_status_message'] = $post_status->post_status_message;
                    $view_data['substore_station_list'] = Auth::user()->allowedSubstores()->where('type',2);
                    return redirect('substore/lodgement/confirmation/'.$account->owner_id);
                }
                elseif($request->get('approval')=='DECLINE'){
                    DB::beginTransaction();
                    try
                    {   $account_transaction = AccountTransaction::find($request->input('process_id'));
                        $account = Account::find($account_transaction->account_id);
                        
                        $account_transaction->current_approval= $level;
                        $account_transaction->approval_status= 'DECLINED';
                        $account_transaction->save();
                        $account_transaction_approval = Approval::where('process_id',$account_transaction->id)->where('process_type','ACCOUNT_TRANSACTION')->first();
                        $account_transaction_approval->{$level} = Auth::user()->id;             
                        $account_transaction_approval->save();
                        $account_transaction->delete();
                        $post_status->success();
                        
                    }
                    catch(Exception $e)
                    {
        
                        DB::rollback();
                        $post_status->failed();
                        
                        throw $e;
                    }
                    DB::commit();
                    $view_data['post_status'] = $post_status->post_status;
                    $view_data['post_status_message'] = $post_status->post_status_message;
                    $view_data['substore_station_list'] = Auth::user()->allowedSubstores()->where('type',2);
                    return redirect('substore/lodgement/confirmation/'.$account->owner_id);
                }    
            }
            else{
                return abort(403);
            }
    }

    public function lubebayLodgement(Request $request){
        $view_data = [];
        $post_status  = new PostStatusHelper;

        //approval/permission name and level syntax 
        // "approve_prf_".$level
        $level = $request->input('level');
        

            if(Auth::user()->hasPermissionTo('approve_lodgement_'.$level)){
                if($request->get('approval')=='APPROVE')
                {
                    

                    DB::beginTransaction();
                    try
                    {   
                        $account_transaction = AccountTransaction::find($request->input('process_id'));
                        $account = Account::find($account_transaction->account_id);
                        //case swith for approval status depending on the approval level
                        if($level == $account_transaction->final_approval){$approval_status="CONFIRMED";}
                        elseif($level=='l1'){$approval_status="CONFIRMED";}
                        else{$approval_status="UNKNOWN";}
                        $transaction_amount = $account_transaction->amount ;

                        if ($account_transaction->transaction_type == 'CREDIT') {
                            $account->balance += $transaction_amount;
                        }
                        elseif ($account_transaction->transaction_type == 'DEBIT') {
                            $account->balance -= $transaction_amount;
                            
                        }
                        
                        else{
                            throw new Exception('invalid transaction_type');
                        }
                        $account_transaction->balance = $account->balance;
                        $account_transaction->approval_status ='CONFIRMED' ;

                        $account_transaction_approval = Approval::where('process_id',$account_transaction->id)->where('process_type',$request->get('process_type'))->first();
                        $account_transaction_approval->{$level}= Auth::user()->id; 

                        $account_transaction_approval->save();
                        $account_transaction->save();
                        $account->save();
                        $post_status->success();
                    }
                    catch(Exception $e)
                    {
        
                        DB::rollback();
                        $post_status->failed();
                        $post_status_message = "Operation failed";
                        DB::commit();
                        throw $e;
                    }
                    DB::commit();
                    $view_data['post_status'] = $post_status->post_status;
                    $view_data['post_status_message'] = $post_status->post_status_message;
                    $view_data['lubebays_list'] = Auth::user()->allowedLubebays();
                    return redirect('lubebay/lodgement/confirmation/'.$account->owner_id);
                }
                elseif($request->get('approval')=='DECLINE'){
                    DB::beginTransaction();
                    try
                    {   $account_transaction = AccountTransaction::find($request->get('transaction_id'));
                        
                        $account_transaction->current_approval='$level';
                        $account_transaction->approval_status='DECLINED';
                        $account_transaction->save();
                        $account_transaction_approval = Approval::where('process_id',$account_transaction->id)->where('process_type','ACCOUNT_TRANSACTION')->first();
                        $account_transaction_approval->{$level} = Auth::user()->id;             
                        $account_transaction_approval->save();
                        $account_transaction->delete();
                        $post_status->success();
                        
                    }
                    catch(Exception $e)
                    {
        
                        DB::rollback();
                        $post_status->failed();
                        
                        throw $e;
                    }
                    DB::commit();
                    $view_data['post_status'] = $post_status->post_status;
                    $view_data['post_status_message'] = $post_status->post_status_message;
                    $view_data['lubebays_list'] = Auth::user()->allowedLubebay();
                    return redirect('lubebay/lodgement/confirmation/'.$account->owner_id);
                }    
            }
            else{
                return abort(403);
            }
    }

    public function customerLodgement(Request $request){
        $view_data = [];
        $post_status  = new PostStatusHelper;

        //approval/permission name and level syntax 
        // "approve_prf_".$level
        $level = $request->input('level');
        

            if(Auth::user()->hasPermissionTo('approve_lodgement_'.$level)){
                if($request->get('approval')=='APPROVE')
                {
                    

                    DB::beginTransaction();
                    try
                    {   
                        $customer_account_transaction = CustomerTransaction::find($request->input('process_id'));
                        $customer = $customer_account_transaction->customer;
                        $system_account = Account::where('account_type','STATE_LUBRICANT_SALES')->where('owner_id',$customer->state)->first();
                        $payment_amount = $customer_account_transaction->amount;
                        $system_account_transaction = new AccountTransactionClass;
                        $system_account_transaction_id = $system_account_transaction->new_transaction($system_account->id, $related_process="CUSTOMER_LODGEMENT", $related_process_id=$customer_account_transaction->id ,$transaction_type="CREDIT",$transaction_amount=$payment_amount,$payment_comment="",$bank_reference=$customer_account_transaction->reference_number, $approved=true);
                        if (!$system_account_transaction_id) {
                            throw new Exception('system transaction entry not successfull');
                        }
                        //case swith for approval status depending on the approval level
                        if($level == $customer_account_transaction->final_approval){$approval_status="CONFIRMED";}
                        elseif($level=='l1'){$approval_status="CONFIRMED";}
                        else{$approval_status="UNKNOWN";}
                        $transaction_amount = $customer_account_transaction->amount ;

                        if ($customer_account_transaction->transaction_type == 'CREDIT') {

                            $customer_account_transaction->balance = $customer->balance + $payment_amount;
                            $system_account->balance = $system_account->balance +$transaction_amount;
                            $customer->balance = $customer_account_transaction->balance;
                        }
                        elseif ($customer_account_transaction->transaction_type == 'DEBIT') {

                            $customer_account_transaction->balance = $customer->balance - $payment_amount;
                            $customer->balance = $customer_account_transaction->balance;
                            $system_account->balance -= $transaction_amount;
                        }
                        
                        else{
                            throw new Exception('invalid transaction_type');
                        }
                        $customer_account_transaction->approval_status ='CONFIRMED' ;

                        $customer_account_transaction_approval = Approval::where('process_id',$customer_account_transaction->id)->where('process_type',$request->get('process_type'))->first();
                        $customer_account_transaction_approval->{$level}= Auth::user()->id; 
                        
                        $customer_account_transaction->save();
                        $customer->save();
                        $system_account->save();
                        $customer_account_transaction_approval->save();
                        
                        $post_status->success();
                    }
                    catch(Exception $e)
                    {
        
                        DB::rollback();
                        $post_status->failed();
                        $post_status_message = "Operation failed";
                        DB::commit();
                        throw $e;
                    }
                    DB::commit();
                    $view_data['post_status'] = $post_status->post_status;
                    $view_data['post_status_message'] = $post_status->post_status_message;
                    $view_data['lubebays_list'] = Auth::user()->allowedLubebays();
                    return redirect('customer/lodgement/confirmation/');
                }
                elseif($request->get('approval')=='DECLINE'){
                    DB::beginTransaction();
                    try
                    {   
                        $customer_account_transaction = CustomerTransaction::find($request->input('process_id'));
                        $customer_account_transaction->current_approval=$level;
                        $customer_account_transaction->approval_status='DECLINED';
                        $customer_account_transaction->save();

                        $customer_account_transaction_approval = Approval::where('process_id',$customer_account_transaction->id)->where('process_type',$request->get('process_type'))->first();
                        $customer_account_transaction_approval->{$level} = Auth::user()->id;             
                        $customer_account_transaction_approval->save();
                        $customer_account_transaction->delete();
                        $post_status->success();
                        
                    }
                    catch(Exception $e)
                    {
        
                        DB::rollback();
                        $post_status->failed();
                        
                        throw $e;
                    }
                    DB::commit();
                    $view_data['post_status'] = $post_status->post_status;
                    $view_data['post_status_message'] = $post_status->post_status_message;
                    $view_data['lubebays_list'] = Auth::user()->allowedLubebays();
                    return redirect('customer/lodgement/confirmation/');
                }    
            }
            else{
                return abort(403);
            }
    }


}
