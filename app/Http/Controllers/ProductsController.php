<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CustomerType;
use App\Models\PriceScheme;
use App\Helpers\PostStatusHelper;

class ProductsController extends Controller
{
    //
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
                
            }    
            $post_status->success();
        }

        $view_data['products_list'] = $products;
        $view_data['customer_types'] = $customer_types;
        $view_data['post_status'] = $post_status->post_status;
        $view_data['post_status_message'] = $post_status->post_status_message;
        
        return view('admin_products_update_price_scheme',$view_data);


    }
}
