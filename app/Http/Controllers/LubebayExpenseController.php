<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\LubebayExpense;
use App\Models\LubebayExpenseType;
use App\Models\Approval;
use App\Helpers\PostStatusHelper;

class LubebayExpenseController extends Controller
{
    //

    
    public function lubebayAddExpense(Request $request ){
        $view_data = [];
        $view_data['lubebay_list'] = Auth::user()->allowedlubebays();
        $post_status = '';
        $post_status_message = '';
        $view_data['expense_types'] = LubebayExpenseType::all();
        //die($request->get('expense_name'));
        if($request->isMethod('post'))
        {
            $request->validate([
                'lubebay'=>'required',
                'expense_name'=>'required',
                'expense_type'=>'required',
                'expense_amount'=>'required'
                
            ]);
            DB::beginTransaction();
            try {
                
                $new_expense = new LubebayExpense;
                $new_expense->lubebay_id = $request->get('lubebay');
                $new_expense->name = $request->get('expense_name');
                $new_expense->amount = $request->get('expense_amount');
                $new_expense->user_id = Auth::user()->id;
                $new_expense->expense_type_id = $request->get('expense_type');
                $new_expense->expense_type = LubebayExpenseType::find($request->get('expense_type'))->name;

                $new_expense->current_approval = "l0";
                $new_expense->final_approval = "l1";
                $new_expense->approval_status = "AWAITING_APPROVAL";
                $new_expense->save();

                $new_approval_tracker = new Approval;
                $new_approval_tracker->process_type = "LUBEBAY_EXPENSE";
                $new_approval_tracker->process_id = $new_expense->id;
                $new_approval_tracker->l0 = Auth::user()->id;
                $new_approval_tracker->save();
            } catch (Exception $e) {
                throw $e;
                DB::rollback();
                $post_status = 'FAILED';
                $post_status_message = 'Operation Failed';
            }
            DB::commit();
           $post_status = 'SUCCESS';
           $post_status_message = 'Successfully added Expense "'.$request->get('expense_name').' "';

            
        }
        $view_data['post_status'] = $post_status;
        $view_data['post_status_message'] = $post_status_message;
        //return ($view_data);
        return view('add_lubebay_expense',$view_data);
    }

    public function lubebayView(){
        $view_data = [];
        $view_data['expense_types'] = LubebayExpenseType::all();
        $view_data['expense_list'] = LubebayExpense::whereIn('lubebay_id',json_decode(Auth::user()->accessibleEntities()->lubebays))->get();
        return view('view_approve_lubebay_expense',$view_data);
    }

    // public function createLubebayExpenseType(Request $request ) {
    //     $post_status = new PostStatusHelper;
    //     if($request->isMethod('post')){
    //         $request->validate([
    //             'expense_type_name' => 'required'
    //         ]);

    //         $new_expense_type = new LubebayExpenseType;
    //         $new_expense_type->name = $request->input('expense_type_name');
    //         if ($new_expense_type->save()){
    //             $post_status->success();
    //         }
    //         else{
    //             $post_status->failed();
    //         }
            
    //     }
    //     $view_data['post_status'] = $post_status->post_status;
    //     $view_data['post_status_message'] = $post_status->post_status_essage;
    //     return view('lubebay_create_expensetype', $view_data);

    // }

    public function viewExpenseTypes(){
        $view_data = [];
        $view_data['expense_types_list'] = LubebayExpenseType::all();
        return view('admin_lubebay_expense_view_lubebay_expensetypes',$view_data);
    }

    public function createExpenseType(Request $request ) {
        $post_status = new PostStatusHelper;
        if($request->isMethod('post')){
            $request->validate([
                'expense_type_name' => 'required'
            ]);

            $new_expense_type = new LubebayExpenseType;
            $new_expense_type->name = $request->input('expense_type_name');
            if ($new_expense_type->save()){
                $post_status->success();
                $view_data['post_status'] = $post_status->post_status;
                $view_data['post_status_message'] = $post_status->post_status_message;
                $view_data['expense_types_list'] = LubebayExpenseType::all();        
                return view('admin_lubebay_expense_view_lubebay_expensetypes',$view_data);
            }
            else{
                $post_status->failed();
            }
            
        }
        $view_data['post_status'] = $post_status->post_status;
        $view_data['post_status_message'] = $post_status->post_status_message;
        return view('admin_lubebay_expense_create_expensetype', $view_data);

    }

    public function editExpenseType(Request $request, LubebayExpenseType $expense_type ) {
        $post_status = new PostStatusHelper;
        
        if($request->isMethod('post')){
            $request->validate([
                'expense_type_name' => 'required'
            ]);

            $expense_type->name = $request->input('expense_type_name');
            if ($expense_type->save()){
                $post_status->success();
                $view_data['post_status'] = $post_status->post_status;
                $view_data['post_status_message'] = $post_status->post_status_message;
                $view_data['expense_types_list'] = LubebayExpenseType::all();        
                return view('admin_lubebay_expense_view_lubebay_expensetypes',$view_data);
            }
            else{
                $post_status->failed();
            }
            
            
        }
        $view_data['expense_type'] = $expense_type;
        $view_data['post_status'] = $post_status->post_status;
        $view_data['post_status_message'] = $post_status->post_status_message;
        return view('admin_lubebay_expense_edit_expensetype', $view_data);

    }
    public function deleteExpenseType(Request $request, LubebayExpenseType $expense_type ) {
        $post_status = new PostStatusHelper;
        if ($expense_type->delete()){
                $post_status->success();
            }
            else{
                $post_status->failed();
            }
            
        $view_data['expense_types_list'] = LubebayExpenseType::all();
        $view_data['post_status'] = $post_status->post_status;
        $view_data['post_status_message'] = $post_status->post_status_message;
        return view('admin_lubebay_expense_view_lubebay_expensetypes', $view_data);

    }
}
