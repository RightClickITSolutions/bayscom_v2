<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\User;
use App\Models\AccessibleEntities;
use App\Models\Warehouse;
use App\Models\Substore;
use App\Models\Lubebay;
use App\Models\State;

use App\Helpers\PostStatusHelper;

class UserController extends Controller
{
    //
   
    public function createUser(Request $request){
        $post_status = new PostStatusHelper;
        $view_data = [];
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'string|max:250|required',
                'email'=> 'unique:users,email|required|email|max:250',
                'password'=> 'string|min:6|required',
            ]);
            
            DB::beginTransaction();
            try {
                
                $user = new User;
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->password = Hash::make($request->input('password'));
                $user->save();
    
                $user_accessible_entities = new AccessibleEntities;
                $user_accessible_entities->user_id = $user->id;
                $user_accessible_entities->warehouses = '[]';
                $user_accessible_entities->substores = '[]';
                $user_accessible_entities->lubebays = '[]';
                $user_accessible_entities->states = '[]';
                $user_accessible_entities->locations = '[]';
                if(!$user_accessible_entities->save()){
                    throw new Exception("saving to accessible entities model", 1);
                    
                }
                
                $post_status->success();
    
                
            } 
            catch (Exception $e) {
                DB::rolback();
                $post_status->failed();
                throw $e;
            }
            DB::commit();
        }
        
        
        $view_data['post_status'] = $post_status->post_status;
        $view_data['post_status_message'] = $post_status->post_status_message;
        return view('create_user',$view_data);

    }

    public function editUser(Request $request, User $user){
        $post_status = new PostStatusHelper;
        $view_data = [];
        if ($request->isMethod('post')) {
            $request->validate([
                'name' => 'string|max:250|required',
            ]);
            if($request->input('email') != $user->email){
                $request->validate(['email'=> 'unique:users,email|required|email|max:250']);
            }
            
            DB::beginTransaction();
            try {
                
                $user->name = $request->input('name');
                $user->email = $request->input('email');

                if ( $request->filled('password') ) {
                    $user->password = Hash::make($request->input('password'));
                }
                   
               
                if($user->save()){
                    
                    $post_status->success();
                }
                
                else{
                    $post_status->failed();
                    throw new Exception("user update error", 1);
                    
                }
                
    
                
            } 
            catch (Exception $e) {
                DB::rolback();
                $post_status->failed();
                throw $e;
            }
            DB::commit();
            
            $view_data = [];
            $view_data['users_list'] = User::withTrashed()->get();
            $view_data['post_status'] = $post_status->post_status;
            $view_data['post_status_message'] = $post_status->post_status_message;
            return view('view_users',$view_data);
    
        }
        
        $view_data['user'] = $user;
        $view_data['post_status'] = $post_status->post_status;
        $view_data['post_status_message'] = $post_status->post_status_message;
        return view('admin_edit_user',$view_data);

    }


    public function viewUsers(Request $request ){
        $view_data = [];
        $view_data['users_list'] = User::withTrashed()->get();

        return view('view_users',$view_data);
    }

    public function deleteUser(Request $request, $cid){
        $post_status = new PostStatusHelper;

        $view_data['user_delete_data'] = User::where('id', $cid)->get();
        return view('delete_user_prompt', $view_data);

        // if($user->delete())
        // {
        //     $post_status->success();
        // }
        // else{
        //     $post_status->failed();
        // }
        // $view_data['post_status'] = $post_status->post_status;
        // $view_data['post_status_message'] = $post_status->post_status_message;
        // $view_data['users_list'] = User::withTrashed()->get();

        // return view('view_users',$view_data);
    }

    public function instDeleteUser(Request $request)
    {
        $cid = $request->input('cid');

        $deleted = User::where('id', $cid)->delete();

        if ($deleted) {
            $request->session()->flash('status', 'User deleted!');
            return redirect('/admin/users/view-users');
        }else{
            $request->session()->flash('status', 'User not deleted!');
            return redirect('/admin/users/view-users');
        }
    }

    public function editUserAccesses(User $user){
        $view_data['user'] = $user;
        $view_data['roles_list'] = Role::all();
        $view_data['warehouses_list'] = Warehouse::all();
        $view_data['substores_list'] = Substore::all();
        $view_data['lubebays_list'] = Lubebay::all();
        $view_data['states_list'] = State::all();


        return view('admin_edit_user_accesses',$view_data);
    }

    public function assignUserRoles(User $user, Request $request ){
        $post_status = new PostStatusHelper;
        $view_data = [];
        $view_data['user'] = $user;
        $view_data['roles_list'] = Role::all();
        $view_data['warehouses_list'] = Warehouse::all();
        $view_data['substores_list'] = Substore::all();
        $view_data['lubebays_list'] = Lubebay::all();
        $view_data['states_list'] = State::all();

        if ($request->isMethod('post')) {
            
            $request->validate([
                'user' => 'exists:App\User,id'
                //todo
                //check and validate roles before assigning
            ]);

            

            if( $user->syncRoles($request->input('roles')) ){
                $post_status->success();
            }
            else{
                $post_status->success();
                $post_status_message = "There was an error assiging roles some ar all may not have been assigned";
            }

            $view_data['post_status'] = $post_status->post_status;
            $view_data['post_status_message'] = $post_status->post_status_message;

            return view('admin_edit_user_accesses',$view_data);
        
        }
        
        
        
        return redirect('/admin/users/edit-user-accesses/'.$user->id);

    }

    public function assignUserAccesibleEntities(User $user, Request $request ){
        $view_data = [];
        $view_data['user'] = $user;
        $view_data['roles_list'] = Role::all();
        $view_data['warehouses_list'] = Warehouse::all();
        $view_data['substores_list'] = Substore::all();
        $view_data['lubebays_list'] = Lubebay::all();
        $view_data['states_list'] = State::all();
        
        if ($request->isMethod('post')) {
            DB::beginTransaction();
            try {

                $post_status = new PostStatusHelper;
                $request->validate([
                    'user' => 'exists:App\User,id'
                    //todo
                    //check and validate roles before assigning
                ]);
                $user_accessible_entities = $user->accessibleEntities();
                
                $user_accessible_entities->warehouses = $request->input('warehouses','[]');
                $user_accessible_entities->substores = $request->input('substores','[]');
                $user_accessible_entities->lubebays = $request->input('lubebays','[]');
                $user_accessible_entities->states = $request->input('states','[]');
                // $user_accessible_entities->locations = $request->input('locations');
                 $user_accessible_entities->save();
                $post_status->success();

            } 
            catch (Exception $e) {
                DB::rolback();
                throw $e;
                $post_status->failed();
            }
            DB::commit();
           
            $view_data['post_status'] = $post_status->post_status;
            $view_data['post_status_message'] = $post_status->post_status_message;

            return view('admin_edit_user_accesses',$view_data);
        }
            
            return redirect('/admin/users/edit-user-accesses/'.$user->id);
    }
}
