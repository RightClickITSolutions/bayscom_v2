<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\PriceScheme;
use App\Models\WarehouseInventory;
use Illuminate\Support\Facades\Hash;
use App\User;

//$permission = Permission::create(['name' => 'edit articles']);

class PermissionsModifier extends Controller
{
    function index()
    {
            // $md_role = Role::findByName("md");
            // $md_role->givePermissionTo("md");

            // $coo_role = Role::findByName("coo");
            // $coo_role->givePermissionTo("coo");

            // $managemnet_role = Role::findByName("management");
            // $managemnet_role->givePermissionTo("management");

            // $seniorsupervisor_role = Role::findByName("seniorsupervisor");
            // $seniorsupervisor_role->givePermissionTo("seniorsupervisor");

            // $supervisor_role = Role::findByName("supervisor");
            // $supervisor_role->givePermissionTo("supervisor");

            // $salesrep_role = Role::findByName("salesrep");
            // $salesrep_role->givePermissionTo("salesrep");

            // $storekeeper_role = Role::findByName("storekeeper");
            // $storekeeper_role->givePermissionTo("storekeeper");

        // $coo_role = Role::create(['name' => 'coo']);
        // $management_role = Role::create(['name' => 'management']);
        // $seniorsupervisor_role = Role::create(['name' => 'senior_supervisor']);
        // $supervisor_role = Role::create(['name' => 'supervisor']);
        // $salesrep_role = Role::create(['name' => 'salesrep']);
        // $accountant_role = Role::create(['name' => 'accountant']);
        // $storekeeper_role = Role::create(['name' => 'store_keeper']);

        // $md_permission = Permission::create(['name' => 'maddd']);
        // $coo_permission = Permission::create(['name' => 'coo']);
        // $management_permission = Permission::create(['name' => 'management']);
        // $seniorsupervisor_permission = Permission::create(['name' => 'senior_supervisor']);
        // $supervisor_permission = Permission::create(['name' => 'supervisor']);
        // $salesrep_permission = Permission::create(['name' => 'salesrep']);
        // $accountant_permission = Permission::create(['name' => 'accountant']);
        // $storekeeper_permission = Permission::create(['name' => 'store_keeper']);
            // $add_cutomer_permission = Permission::create(['name' => 'add_customer']);
            // $create_pro_permission = Permission::create(['name' => 'create_pro']);
            // $create_prf_permission = Permission::create(['name' => 'create_prf']);
            //$verify_pro_permission = Permission::create(['name' => 'verify_pro']);
            //$verify_prf_permission = Permission::create(['name' => 'verify_prf']);
            //$approve_pro_permission = Permission::create(['name' => 'approve_pro']);
            //$approve_prf_permission = Permission::create(['name' => 'approve_prf']);
            //Auth::user()->givePermissionTo('add_customer');
            // $approve_prf_permission = Permission::create(['name' => 'approve_prf_l1']);
            // $approve_prf_permission = Permission::create(['name' => 'approve_prf_l2']);
            // Auth::user()->givePermissionTo('approve_prf_l1');
            // Auth::user()->givePermissionTo('approve_prf_l2');
            // $view_prf_permission = Permission::create(['name' => 'view_prf']);
            // $view_pro_permission = Permission::create(['name' => 'view_pro']);
            // Auth::user()->givePermissionTo('view_prf');
            // Auth::user()->givePermissionTo('view_pro');
            // $view_prf_permission = Permission::create(['name' => 'approve_sst_l1']);
            // $view_pro_permission = Permission::create(['name' => 'approve_sst_l2']);
            // Auth::user()->givePermissionTo('approve_sst_l1');
            // Auth::user()->givePermissionTo('approve_sst_l2');
            //$approve_pro_l1_permission = Permission::create(['name' => 'create_prf']);
            //Auth::user()->givePermissionTo('create_prf');

            ///warehouse inventory update
                // $warehouses = Warehouse::all();
                // $products = Product::all();
                // $warehouse_inventory = WarehouseInventory::all();
                // foreach($warehouses as $warehouse){
                //     foreach($products as $product){
                //         if(!$warehouse_inventory->where("wharehouse_id",$warehouse->id)->where("product_id",$product->id)->count() )
                //         {
                //             print_r('debug 1');
                //             $inventory_item = new WarehouseInventory;
                //             $inventory_item->product_name = $product->product_name;
                //             $inventory_item->product_id = $product->id;
                //             $inventory_item->warehouse_id = $warehouse->id;
                //             $inventory_item->quantity = 0 ;
                //             $inventory_item->save();
                //             print_r('debug 2');

                //         }
                //     }
                // }
                // $products = Product::all();
                // foreach($products as $product){
                //             $pricescheme_item = new PriceScheme;
                //                 print_r('debug 1');
                //                 $pricescheme_item->product_name = $product->product_name;
                //                 $pricescheme_item->product_id = $product->id;
                //                 $pricescheme_item->price = $product->cost_price*1.1;
                //                 $pricescheme_item->customer_type = 3 ;
                //                 $pricescheme_item->save();
                //                 print_r('debug 2');
                //         }
                
                // Permission::create(['name' => 'view_dashboard']);
                // Permission::create(['name' => 'post_prf_payment']);
                // Permission::create(['name' => 'storekeeper']);
                // Permission::create(['name' => 'view_substore_sales']);
                // Permission::create(['name' => 'post_substore_sales']);
                // Permission::create(['name' => 'view_lubebay_sales']);
                // Permission::create(['name' => 'post_lubebay_sales']);
                // Permission::create(['name' => 'view_general_expenses']);
                // Permission::create(['name' => 'add_general_expenses']);
                // Permission::create(['name' => 'view_lubebay_expenses']);
                // Permission::create(['name' => 'add_lubebay_expenses']);
                // Permission::create(['name' => 'approve_lst_l1']);
                // Permission::create(['name' => 'approve_lst_l2']);
                // Permission::create(['name' => 'approve_expense_l1']);
                // Permission::create(['name' => 'approve_lubebay_expense_l1']);
                
                // Role::findByName('coo')->givePermissionTo('view_dashboard','approve_prf_l2','approve_pro_l2');
                // Role::create(['name' => 'management' ])->givePermissionTo('view_dashboard');
                // Role::create(['name' => 'substore_manager' ])->givePermissionTo('view_substore_sales','post_substore_sales');
                // Role::create(['name' => 'lubebay_manager' ])->givePermissionTo('view_lubebay_sales','post_lubebay_sales','approve_lubebay_expense_l1');
                // Role::create(['name' => 'superviosr' ])->givePermissionTo('create_pro','approve_pro_l1','view_pro','view_prf','approve_prf_l1');
                // Role::create(['name' => 'sales_rep' ])->givePermissionTo('create_prf','view_prf','approve_sst_l1');
                // Role::create(['name' => 'storekeeper' ])->givePermissionTo('storekeeper');
                
                // $user = new User;
                // $user->password = encrypt('Store-keeper1');
                // $user->email = 'storekeeper@mofadenergysolutions.com';
                // $user->name = 'Store Keeper';
                // $user->save();
                // $user->assignRole('storekeeper');

                // $user = new User;
                // $user->password = encrypt('Sales-rep1');
                // $user->email = 'salesrep@mofadenergysolutions.com';
                // $user->name = 'Sales rep';
                // $user->save();
                // $user->assignRole('sales_rep', 'storekeeper');
                
                // $user = new User;
                // $user->password = encrypt('Super-visor1');
                // $user->email = 'supervisor@mofadenergysolutions.com';
                // $user->name = 'Supervisor';
                // $user->save();
                // $user->assignRole('superviosr');

                // $user = new User;
                // $user->password = encrypt('Chief-exec-off');
                // $user->email = 'coo@mofadenergysolutions.com';
                // $user->name = 'C.O.O';
                // $user->save();
                // $user->assignRole('coo');

                // $user = new User;
                // $user->password = encrypt('Lubebay-manager');
                // $user->email = 'lb-mng@mofadenergysolutions.com';
                // $user->name = 'Lubebay Manager';
                // $user->save();
                // $user->assignRole('lubebay_manager');

                // $user = new User;
                // $user->password = encrypt('Substore-manager');
                // $user->email = 'st-mng@mofadenergysolutions.com';
                // $user->name = 'Substore Manager';
                // $user->save();
                // $user->assignRole('substore_manager');

                //  $user = User::find(4);
                // $user->password = Hash::make('Sales-rep1');
                // $user->save();
                // $user->assignRole('sales_rep', 'storekeeper');
                
                // $user = User::find(5);
                // $user->password = Hash::make('Super-visor1');
                // $user->save();
                // $user->assignRole('superviosr');

                // $user = User::find(1);
                // Role::create(['name' => 'Super Admin' ]);
                // $user->assignRole('Super Admin');
                //Role::findByName('lubebay_manager')->givePermissionTo('view_lubebay_expenses','add_lubebay_expenses','approve_lubebay_expense_l1');
                // /Role::findByName('sales_rep')->givePermissionTo('view_general_expenses','add_general_expenses','add_customer');
                //Role::findByName('coo')->givePermissionTo('view_general_expenses','approve_expense_l1');
                //Auth::user()->assignRole('coo');
                //Role::findByName('sales_rep')->givePermissionTo('create_pro');
                // Permission::create(['name' => 'view_customers']);
                // Permission::create(['name' => 'create_customers']);
                // Role::findByName('superviosr')->givePermissionTo('create_prf');
                // Role::findByName('coo')->givePermissionTo('approve_pro_l2','approve_expense_l1','view_customers');
                // Role::findByName('sales_rep')->givePermissionTo('view_customers','create_customers');
                //Role::findByName('superviosr')->givePermissionTo('view_customers');
                //Role::findByName('coo')->givePermissionTo('view_pro','view_prf','approve_prf_l2');
                ///new addition
                // Permission::create(['name' => 'access_all_entities']);
                // Role::findByName('coo')->givePermissionTo('access_all_entities');
                // Role::findByName('management')->givePermissionTo('access_all_entities');
                // Role::findByName('Super Admin')->givePermissionTo('access_all_entities');
                //Role::findByName('sales_rep')->givePermissionTo('view_pro','create_pro');
                //access_all_entities
                //Permission::create(['name' => 'use_admin_features']);
                //Role::findByName('management')->givePermissionTo('use_admin_features');
                //
                //Role::findByName('lubebay_manager')->givePermissionTo('approve_lst_l1');
                //Role::findByName('lubebay_manager')->givePermissionTo('approve_sst_l1');
                // Permission::create(['name' => 'approve_lodgement_l1']);
                // Role::findByName('coo')->givePermissionTo('approve_lodgement_l1');
                // Role::findByName('sales_rep')->givePermissionTo('approve_lodgement_l1');
                // Role::findByName('Super Admin')->givePermissionTo('approve_lodgement_l1');
                Permission::create(['name' => 'view_stock_transfer']);
                Permission::create(['name' => 'create_stock_transfer']);
                Permission::create(['name' => 'approve_stock_transfer_l1']);
                Permission::create(['name' => 'approve_stock_transfer_l2']);
                Role::findByName('storekeeper')->givePermissionTo('create_stock_transfer','view_stock_transfer');
                Role::findByName('superviosr')->givePermissionTo('approve_stock_transfer_l1','view_stock_transfer');
                Role::findByName('management')->givePermissionTo('approve_stock_transfer_l2','view_stock_transfer');
            return view("modifypermissions");   
    }
}
	