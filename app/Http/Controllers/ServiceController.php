<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\PostStatusHelper;
use App\Models\Service;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    //
    public function createLubebayService(Request $request){
        $view_data = [];
        $post_status = new PostStatusHelper;

        if($request->isMethod('post'))
        {
            $request->validate([
                'service_name'=>'required|string|max:50',
                'service_description' =>'required',
                'price' => 'required|numeric',
                //todo
                //add validation for different price scheme

            ]);

            //db related operations in transaction
            DB::
            beginTransaction();
            try{
                $service = new Service;
                $service->service_name = $request->input('service_name');
                $service->service_description = $request->input('service_description');
                $service->price = $request->input('price');
                $service->save();
                
                $post_status->success();
            }
            catch(Exception $e){
                DB::rollack();
                $post_status->failed();
                throw $e;
            }
            DB::commit();
        }

        $view_data['post_status'] = $post_status->post_status;
        $view_data['post_status_message'] = $post_status->post_status_message;
        
        return view('admin_lubebay_services_create_service',$view_data);

    }

    public function viewLubebayServices(Request $request){
        $view_data = [];

        $view_data['services_list'] = Service::all();
        return view('admin_lubebay_services_view_services',$view_data);
        
    }
    public function editLubebayService(Request $request , Service $service){
        $view_data['service'] = $service;
        $post_status = new PostStatusHelper;

        if($request->isMethod('post'))
        {
            $request->validate([
                'service_name'=>'required|string|max:50',
                'service_description' =>'required',
                'price' => 'required|numeric',
                //todo
                //add validation for different price scheme

            ]);

            //db related operations in transaction
            DB::
            beginTransaction();
            try{
                
                $service->service_name = $request->input('service_name');
                $service->service_description = $request->input('service_description');
                $service->price = $request->input('price');
                $service->save();
                
                $post_status->success();
            }
            catch(Exception $e){
                DB::rollack();
                $post_status->failed();
                throw $e;
            }
            DB::commit();
        }

        $view_data['post_status'] = $post_status->post_status;
        $view_data['post_status_message'] = $post_status->post_status_message;
        
        return view('admin_lubebay_services_edit_service',$view_data);

        
    }

    public function deleteLubebayService(Request $request , Service $service){
        $post_status = new PostStatusHelper;
         
        if($service->delete()){
            $post_status->success();
        }
        else{
            $post_status->failed();
        }

        $view_data['post_status_message'] = $post_status->post_status_message;
        $view_data['post_status'] = $post_status->post_status;
        $view_data['services_list'] = Service::all();
        return view('admin_lubebay_services_view_services',$view_data);
        
    }


}
