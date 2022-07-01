<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\User;
use App\Helpers\PostStatusHelper;

class PermissionsController extends Controller
{
    //Moved to userCntroller
    public function assignUserRoles(Request $request ){
        $view_data = [];
        if ($request->isMethod('post')) {
            $post_status = new PostStatusHelper;
            $request->validate([
                'user' => 'exists:App\User,id'
                //todo
                //check and validate roles before assigning
            ]);

            $user = User::find($request->input('user'));

            if( $user->syncRoles($request->input('roles_selected')) ){
                $post_status->success();
            }
            else{
                $post_status->success();
                $post_status_message = "There was an error assiging roles some ar all may not have been assigned";
            }
        }

        return view('assign_users_roles',$view_data);
        
        

    }

    public function assignUserAccesibleEntities(Request $request ){
        $view_data = [];
        $view_data['permissions_list'] = Permissions::all();
        if ($request->isMethod('post')) {
            DB::startTransaction();
            try {

                $post_status = new PostStatusHelper;
                $request->validate([
                    'user' => 'exists:App\User,id'
                    //todo
                    //check and validate roles before assigning
                ]);
                
                $user = User::find($request->input('user'));
                $user->accessibleEntities()->warehouses = $request->input('warehouses');
                $user->accessibleEntities()->substores = $request->input('substores');
                $user->accessibleEntities()->lubebays = $request->input('lubebays');
                $user->accessibleEntities()->states = $request->input('states');
                $user->accessibleEntities()->locations = $request->input('locations');
                $post_status->success();

            } 
            catch (Exception $e) {
                DB::rolback();
                throw $e;
                $post_status->failed();
            }
           
            
        }
            return view('user_accessible_entities',$view_data);
    }
    //end of methods moved to user controller
    
    public function assignRolePermissions(Request $request ){
        $view_data = [];

        if($request->isMethod('post')){
            $request->validate([
            //todo
            //validate role submitted
            //validate permissions submitted


            ]);

            $role = Role::findById($requst->input('role'));
            if($role->syncPermissions($request->input('permissions'))){
                $post_status->success();
            }
            else{
                $post_status->failed();
            }
        }

        $view_data['post_status'] = $post_status->post_status;
        $view_data['post_status_message'] = $post_status->post_status_message;

        return view('assign_role_permissions',$view_data);






    }

    public function viewRoles(Request $request ){
        $view_data = [];
        $view_data['roles_list'] = Roles::all();

        return view('view_roles',$view_data);
    }


}
