<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\CustomerType;
use App\Models\PriceScheme;
use App\Helpers\PostStatusHelper;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class ProductController extends Controller
{
    public function createProduct(Request $request){
        $view_data['customer_types'] =  CustomerType::all();
        $post_status = new PostStatusHelper;

        if($request->isMethod('post'))
        {
            $request->validate([
                'product_name'=>'required|string|max:50',
                'product_description' =>'required',
                'cost_price' => 'required|numeric',
                'product_code' => 'required|string',
                //todo
                //add validation for different price scheme

            ]);

            //db related operations in transaction
            DB::beginTransaction();
            try{
                $product = new Product;
                $product->product_name = $request->input('product_name');
                $product->product_description = $request->input('product_description');
                $product->cost_price = $request->input('cost_price');
                $product->product_code = $request->input('product_code');
                $product->save();
                
                foreach(CustomerType::all() as $customer_type)
                {
                    $product_price_scheme = new PriceScheme;
                    $product_price_scheme->product_id = $product->id;
                    $product_price_scheme->customer_type = $customer_type->id;
                    $product_price_scheme->price = $request->input('customer_type.'.$customer_type->id.'.price');
                    $product_price_scheme->product_name = $request->input('product_name');
                    if($product_price_scheme->save()){

                    }
                    else{
                        throw new Exception('price scheme could not be created for '.$customer_type->name.' cutomer type. Aborted.');
                    break;
                    }

                    
                }
                $post_status->success();
            }
            catch(Exception $e){
                DB::rollback();
                $post_status->failed();
                throw $e;
            }
            DB::commit();
        }

        $view_data['post_status'] = $post_status->post_status;
        $view_data['post_status_message'] = $post_status->post_status_message;
        
        return view('admin_products_create_product',$view_data);

    }

    public function viewProducts(Request $request){
        $view_data = [];

        $view_data['products_list'] = Product::all();
       return  view('admin_products_view_products',$view_data);
        
    }

    public function editProduct(Request $request , Product $product){
        $view_data['customer_types'] =  CustomerType::all();
        $view_data['product'] =  $product;
        $post_status = new PostStatusHelper;

        if($request->isMethod('post'))
        {
            $request->validate([
                'product_name'=>'required|string|max:50',
                'product_description' =>'required',
                'cost_price' => 'required|numeric',
                'product_code' => 'required|string',
                
                //todo
                //add validation for different price scheme

            ]);

            //db related operations in transaction
            DB::beginTransaction();
            try{
                
                $product->product_name = $request->input('product_name');
                $product->product_description = $request->input('product_description');
                $product->cost_price = $request->input('cost_price');
                $product->product_code = $request->input('product_code');
                
                $product->save();
                
                foreach(CustomerType::all() as $customer_type)
                {
                    $product_price_scheme =  PriceScheme::where('product_id',$product->id)->where('customer_type',$customer_type->id)->first();
                    $product_price_scheme->product_id = $product->id;
                    $product_price_scheme->customer_type = $customer_type->id;
                    $product_price_scheme->price = $request->input('customer_type.'.$customer_type->id.'.price');
                    $product_price_scheme->product_name = $request->input('product_name');
                    if($product_price_scheme->save()){

                    }
                    else{
                        throw new Exception('price scheme could not be created for '.$customer_type->name.' cutomer type. Aborted.');
                    break;
                    }

                    
                }
                $post_status->success();
            }
            catch(Exception $e){
                DB::rollback();
                $post_status->failed();
                throw $e;
            }
            DB::commit();
        }

        $view_data['post_status'] = $post_status->post_status;
        $view_data['post_status_message'] = $post_status->post_status_message;
        
        return view('admin_products_edit_product',$view_data);

        
    }

    public function deleteProduct(Request $request , Product $product){
        $post_status = new PostStatusHelper;
         
        if($product->delete()){
            $post_status->success();
        }
        else{
            $post_status->failed();
        }

        $view_data['post_status_message'] = $post_status->post_status_message;
        $view_data['post_status'] = $post_status->post_status;
        $view_data['products_list'] = Product::all();
        return view('admin_products_view_products',$view_data);
        
    }

    public function updatePricescheme(Request $request ){
        $products = Product::all();
        $customer_types = CustomerType::all();
        $post_status = new PostStatusHelper;
        if($request->isMethod('post')){
            //return $request->input('update_products');
            foreach ($request->input('update_products') as $product_id => $custumer_types) {
                foreach ( $custumer_types as  $customer_type =>  $custumer_type_price) {
                    $product_price_scheme =  PriceScheme::where('product_id',$product_id)->where('customer_type',$customer_type)->first();
                    if(!empty($product_price_scheme) && $product_price_scheme != null){
                        $product_price_scheme->price = $custumer_type_price;
                        $product_price_scheme->product_name = Product::find($product_id)->name();
                        $product_price_scheme->save();
                    }
                    else{
                        $product_price_scheme = new PriceScheme ;
                        $product_price_scheme->product_name = Product::find($product_id)->name();
                        $product_price_scheme->product_id = $product_id;
                        $product_price_scheme->customer_type = $customer_type;
                        $product_price_scheme->price = $custumer_type_price;
                        $product_price_scheme->save();
                    }
                } 

                // add product code
                $selected_product = Product::find($product_id); 
                $selected_product->product_code = $request->input('product_code.'.$product_id);
                $selected_product->save();

            }    
            $post_status->success();
        }

        //refresh display list after update
        $products = Product::all();
        $view_data['products_list'] = $products;
        $view_data['customer_types'] = $customer_types;
        $view_data['post_status'] = $post_status->post_status;
        $view_data['post_status_message'] = $post_status->post_status_message;
        
        return view('admin_products_update_price_scheme',$view_data);


    }

    


    



}
