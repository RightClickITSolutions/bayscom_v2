<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Helpers\PostStatusHelper;

/// this is an unused conroller filled with rfrequently repeated methods and functions and classes
class SampleController extends Controller
{
    //
    /*
    public function sampleMethod(Request $request){
        $view_data = [];
        $post_status = new PostStatusHelper;

        if($request->isMethod('post'))
        {

            //db related operations in transaction
            DB:beginTransaction();
            try{
                //operations 
                $post_status->sucess()
            }
            catch(Exception $e){
                DB::rollack();
                $post_status->failed();
                throw $e;
            }
        }

        $view_data['post_status'] = $post_status->post_status;
        $view_data['post_status_message'] = $post_status->post_status_message;
        
        return view('sample_view',$view_data);

    }

    */
}
