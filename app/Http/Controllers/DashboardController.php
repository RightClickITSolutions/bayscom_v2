<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\User;
use App\Models\Prf;
use App\Models\Pro;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Lubebay;
use App\Models\Substore;
use App\Models\State;
use App\Models\Warehouse;
use App\Models\LubebayServiceTransaction;
use App\Models\SubstoreTransaction;
use App\Models\AccountTransaction;
use App\Models\CustomerTransaction;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;

Use Illuminate\Support\Collection ;

class DashboardController extends Controller
{
    //
    public function main(Request $request){

        $start_time= now()->startOfYear() ; //now()->startOfWeek() ;
        $end_time = now()->endOfYear() ;//now()->endOfWeek() ;
        $products = Product::all();
        $prf_list  = Prf::whereIn('approval_status',["AWAITING_APPROVAL","APPROVED_NOT_COLLECTED","APPROVED_COLLECTED"])->whereBetween('created_at', [$start_time,$end_time])->get();
        $grand_total_quantity = 0;
        $grand_total_price  = 0;
        $grand_total_lodged  = 0;
        $week_totals = ['day1'=>0,'day2'=>0,'day3'=>0,'day4'=>0,'day5'=>0,'day6'=>0,'day7'=>0,];
        foreach ($products as $product) {
            $comipled_product_list[$product->id] = [
                'product_id'=> $product->id,
                'product_name'=> $product->name(),
                'total_quantity'=> 0,
                'total_price'=> 0,
            ];
        }
        foreach ($prf_list as $prf) {
            foreach ($prf->order_snapshot() as $order_item) {
                $comipled_product_list[$order_item->product_id]['total_quantity'] += $order_item->product_quantity;
                $comipled_product_list[$order_item->product_id]['total_price'] += $order_item->product_quantity*$order_item->product_price;
                $grand_total_quantity += $order_item->product_quantity;
                $grand_total_price += $order_item->product_quantity*$order_item->product_price;

            }
            
            if($prf->created_at->is('JANUARY 2020'))
            {
                $week_totals['day1'] += $prf->order_total;
            }
            elseif($prf->created_at->is('JANUARY 2020'))
            {
                $week_totals['day2'] += $prf->order_total;
            }
            elseif($prf->created_at->is('FEBRUARY 2020'))
            {
                $week_totals['day3'] += $prf->order_total;
            }
            elseif($prf->created_at->is('MARCH 2020'))
            {
                $week_totals['day4'] += $prf->order_total;
            }
            elseif($prf->created_at->is('APRIL 2020'))
            {
                $week_totals['day5'] += $prf->order_total;
            }
            elseif($prf->created_at->is('MAY 2020'))
            {
                $week_totals['day6'] += $prf->order_total;
            }
            elseif($prf->created_at->is('JUNE 2020'))
            {
                $week_totals['day7'] += $prf->order_total;
            }


            
        }

                
        $graph_values = [$week_totals['day1']/1000000,$week_totals['day2']/1000000,$week_totals['day3']/1000000,$week_totals['day4']/1000000,$week_totals['day5']/1000000,$week_totals['day6']/1000000,$week_totals['day7']/1000000 ];
        $view_data['graph_values'] = $graph_values;
        $prf_account_trasactions = AccountTransaction::whereIn('related_process',['SST_LODGEMENT','CUSTOMER_PAYMENT'])->where('approval_status','CONFIRMED')->whereBetween('created_at', [$start_time,$end_time])->get();
        foreach ($prf_account_trasactions as $tranaction) {
            $grand_total_lodged +=  $tranaction->amount;
        }
        
        $view_data['grand_total_quantity'] = $grand_total_quantity;
        $view_data['grand_total_lodged'] = $grand_total_lodged;
        $view_data['grand_total_price']  = $grand_total_price;
        $view_data['comipled_product_list']  = $comipled_product_list;


        $lubebays = Lubebay::all();
            $compiled_lubebays = [];
            $grand_total  = 0;
            $lodgement_grand_total  = 0;
            $expense_grand_total = 0;
            $compiled_substores = [];
            $substores_grand_total  = 0;
            $substores_lodgements_grand_total = 0;
            foreach ($lubebays as $lubebay) {
                $compiled_lubebays[$lubebay->id] = [
                    'lubebay_name'=> $lubebay->name,
                    'lubebay_sales_totals'=>0,
                    'lubebay_lodgement_totals'=>0,
                    'lubebay_expense_totals'=>0,


                ];
                foreach ($lubebay->lsts->whereBetween('created_at', [$start_time,$end_time]) as $lubebay_lst) {
                   
                    $compiled_lubebays[$lubebay->id]['lubebay_sales_totals'] += $lubebay_lst->total_amount;
                    $grand_total += $lubebay_lst->total_amount;
                }

                foreach ($lubebay->expenses_range($start_time,$end_time) as $lubebay_expense) {
                    $compiled_lubebays[$lubebay->id]['lubebay_expense_totals'] += $lubebay_expense->amount;
                    $expense_grand_total += $lubebay_expense->amount;
                }
                foreach ($lubebay->lodgements_range($start_time,$end_time) as $lodgement) {
                    $compiled_lubebays[$lubebay->id]['lubebay_lodgement_totals'] += $lodgement->amount;
                    $lodgement_grand_total += $lodgement->amount;
                }
            }
        
        
        
        $view_data['lubebays_expense_grand_total']  = $expense_grand_total;
        $view_data['lubebays_grand_total']  = $grand_total;
        $view_data['compiled_lubebays']  = $compiled_lubebays;


        $substores = Substore::all();
            $compiled_substores = [];
            $grand_total  = 0;
            $expense_grand_total = 0;
            foreach ($substores as $substore) {
                $compiled_substores[$substore->id] = [
                    'substore_name'=> $substore->name,
                    'substore_sales_totals'=>0,
                    'substore_expense_totals'=>0,
                    'substore_lodgement_totals'=>0

                ];
                foreach ($substore->ssts->whereBetween('created_at', [$start_time,$end_time]) as $substore_sst) {
                   
                    $compiled_substores[$substore->id]['substore_sales_totals'] += $substore_sst->total_amount;
                    $grand_total += $substore_sst->total_amount;
                }

                
                foreach ($substore->lodgements_range($start_time,$end_time) as $lodgement) {
                    $compiled_substores[$substore->id]['substore_lodgement_totals'] += $lodgement->amount;
                    $substores_lodgements_grand_total += $lodgement->amount;
                }
            }
        
        
        $view_data['substores_grand_total']  = $substores_grand_total;
        $view_data['substores_lodgement_grand_total']  = $substores_lodgements_grand_total;
        $view_data['compiled_substores']  = $compiled_substores;


        // $substores = Substore::all();
        //     $compiled_sources = [];
        //     $sources_grand_total  = 0;
        //     $sources_lodgement_grand_total = 0;
        //     foreach ($substores as $substore) {
        //         $compiled_lubebays[$lubebay->id] = [
        //             'source_name'=> $substore->name,
        //             'source_sales_totals'=>0,
        //             'source_lodgement_totals'=>0,


        //         ];
        //         foreach ($lubebay->ssts->whereBetween('created_at', [$start_time,$end_time]) as $lubebay_lst) {
                   
        //             $compiled_lubebays[$lubebay->id]['lubebay_sales_totals'] += $lubebay_lst->total_amount;
        //             $grand_total += $lubebay_lst->total_amount;
        //         }

        //         foreach ($lubebay->expenses as $lubebay_expense) {
        //             $compiled_lubebays[$lubebay->id]['lubebay_expense_totals'] += $lubebay_expense->amount;
        //             $expense_grand_total += $lubebay_expense->amount;
        //         }
        //     }
        
        
        
        // $view_data['lubebays_expense_grand_total']  = $expense_grand_total;
        // $view_data['lubebays_grand_total']  = $grand_total;
        // $view_data['compiled_lubebays']  = $compiled_lubebays;
    
        return view('dashboard',$view_data);
    }

    public function substoreDetails(Request $request , Substore $selected_substore){
        if($request->input('start_date')==null && $request->input('end_date')==null ){
            $start_date= now()->startOfMonth() ;
            $end_date = now()->endOfMonth() ;
           
        }
        elseif($request->input('start_date')!=null && $request->input('end_date') !=null ){
            $start_date = Carbon::create($request->input('start_date'),0); //strtodate('2020-01-01 00:00:00');
            $end_date = Carbon::create($request->input('end_date'),0);
            
        }
        elseif($request->input('start_date')==null && $request->input('end_date')!=null ){
            $start_date = Carbon::create(2020, 1, 1, 0); //strtodate('2020-01-01 00:00:00');
            $end_date = Carbon::create($request->input('end_date'),0);
        }
        elseif($request->input('start_date')!=null && $request->input('end_date')==null){
            $start_date = Carbon::create($request->input('start_date'), 0);
            $end_date = now();
        }

         
        $start_time = $start_date->startOfDay() ;
        $end_time = $end_date->startOfDay();
        $view_data['start_date'] = $start_date;
        $view_data['end_date'] = $end_date;
        $view_data['substore'] = $selected_substore;

        $sales_lodgement_history = new Collection();
        $dateinterval = new CarbonPeriod(
            $start_time,
            '1 day',
            $end_time
        ); 
        
        $number_of_days_in_interval = $dateinterval->count();
        $highest_graph_value =  0;
        $graph_label_array = [];
            
        foreach ($dateinterval as $date) {
           
            $start_of_day = Carbon::createFromTimestamp($date->timestamp)->startOfDay() ;
            $end_of_day = Carbon::createFromTimestamp($date->timestamp)->endOfDay();

            $graph_sales_array[] = $selected_substore->total_sales($start_of_day, $end_of_day );
            $graph_label_array[] = $start_of_day->format('d');

            if($selected_substore->total_sales($start_of_day, $end_of_day ) > $highest_graph_value){
                $highest_graph_value = $selected_substore->total_sales($start_of_day, $end_of_day );
            }


        }

        //Substore sales report
            $grand_total_product_selling_price = 0;
            $grand_total_product_cost_price = 0;
            $grand_total_product_total_sales_value = 0;
            $grand_total_product_total_profit = 0;
            $grand_total_product_total_commission = 0;
            $compiled_substore_products = [];
            //return $selected_substore;
            foreach($selected_substore->inventory as $substore_inventory_item){

                $product_quantity_sold  = $selected_substore->productSalesQuantity($substore_inventory_item->product->id,$start_time, $end_time);
                $product_selling_price = $substore_inventory_item->product->productPrice($selected_substore->customerProfile->customer_type);
                $product_cost_price    = $substore_inventory_item->product->cost_price;
                $product_total_sales_value = $selected_substore->productSalesValue($substore_inventory_item->product->id,$start_time, $end_time);
                $product_total_profit = $product_total_sales_value - $product_cost_price* $product_quantity_sold;
                $compiled_substore_products[$substore_inventory_item->product_id] = [
                    'product_id'=> $selected_substore->name,
                    'product_name'=>$substore_inventory_item->product->name(),
                    'product_current_invetory'=> $selected_substore->productInventory($substore_inventory_item->product_id),
                    'product_quantity_sold'=> $product_quantity_sold,
                    'product_selling_price'=> $product_selling_price,
                    'product_cost_price'=> $product_cost_price,
                    'product_total_sales_value'=> $product_total_sales_value,
                    'product_total_profit'=> $product_total_profit,
                    'product_total_commission'=>$product_total_profit * 0.05,
                    

                ];

                $grand_total_product_selling_price += $product_selling_price;
                $grand_total_product_cost_price += $product_cost_price;
                $grand_total_product_total_sales_value += $product_total_sales_value;
                $grand_total_product_total_profit += $product_total_profit;
                $grand_total_product_total_commission += $product_total_profit *0.05;
        }


        $view_data['compiled_substore_products']  = $compiled_substore_products;
        $view_data['grand_total_product_selling_price']  = $grand_total_product_selling_price ;
        $view_data['grand_total_product_cost_price']  = $grand_total_product_cost_price ;
        $view_data['grand_total_product_total_sales_value']  = $grand_total_product_total_sales_value ;
        $view_data['grand_total_product_total_profit']  = $grand_total_product_total_profit;
        $view_data['grand_total_product_total_commission']  = $grand_total_product_total_commission;
        
        $view_data['graph_sales_array']  = $graph_sales_array;
        $view_data['number_of_days_in_interval']  = $number_of_days_in_interval;
        $view_data['highest_graph_value']  = $highest_graph_value;
        $view_data['graph_label_array']  = json_encode($graph_label_array);
            
        $view_data['substore_total_sales'] = $selected_substore->total_sales($start_time, $end_time );
        $view_data['substore_total_lodgement'] = $selected_substore->total_lodgements($start_time, $end_time );

        

       
        return view('dashboard_substore_details',$view_data);
    }

    public function lubebayDetails(Request $request , Lubebay $selected_lubebay){
        if($request->input('start_date')==null && $request->input('end_date')==null ){
            $start_date= now()->startOfMonth() ;
            $end_date = now()->endOfMonth() ;
           
        }
        elseif($request->input('start_date')!=null && $request->input('end_date') !=null ){
            $start_date = Carbon::create($request->input('start_date'),0); //strtodate('2020-01-01 00:00:00');
            $end_date = Carbon::create($request->input('end_date'),0);
            
        }
        elseif($request->input('start_date')==null && $request->input('end_date')!=null ){
            $start_date = Carbon::create(2020, 1, 1, 0); //strtodate('2020-01-01 00:00:00');
            $end_date = Carbon::create($request->input('end_date'),0);
        }
        elseif($request->input('start_date')!=null && $request->input('end_date')==null){
            $start_date = Carbon::create($request->input('start_date'), 0);
            $end_date = now();
        }
        //Lubay Substore computation
            $selected_substore = $selected_lubebay->substore;
            
            $start_time = $start_date->startOfDay() ;
            $end_time = $end_date->startOfDay();
            $view_data['start_date'] = $start_date;
            $view_data['end_date'] = $end_date;
            $view_data['substore'] = $selected_substore;
            //return [$start_time, $end_time];
            
            $sales_lodgement_history = new Collection();
            $dateinterval = new CarbonPeriod(
                $start_time,
                '1 day',
                $end_time
            ); 
            
            $number_of_days_in_interval = $dateinterval->count();
            $highest_graph_value =  0;

            foreach ($dateinterval as $date) {
            
                $start_of_day = Carbon::createFromTimestamp($date->timestamp)->startOfDay() ;
                $end_of_day = Carbon::createFromTimestamp($date->timestamp)->endOfDay();

                $graph_sales_array[] = $selected_substore->total_sales($start_of_day, $end_of_day );

                if($selected_substore->total_sales($start_of_day, $end_of_day ) > $highest_graph_value){
                    $highest_graph_value = $selected_substore->total_sales($start_of_day, $end_of_day );
                }


            }

            //Substore sales report
            $grand_total_product_selling_price = 0;
            $grand_total_product_cost_price = 0;
            $grand_total_product_total_sales_value = 0;
            $grand_total_product_total_profit = 0;
            $grand_total_product_total_commission = 0;
            $compiled_substore_products = [];
            //return $selected_substore;
            foreach($selected_substore->inventory as $substore_inventory_item){

                $product_quantity_sold  = $selected_substore->productSalesQuantity($substore_inventory_item->product->id,$start_time, $end_time);
                $product_selling_price = $substore_inventory_item->product->productPrice($selected_substore->customerProfile->customer_type);
                $product_cost_price    = $substore_inventory_item->product->cost_price;
                $product_total_sales_value = $selected_substore->productSalesValue($substore_inventory_item->product->id,$start_time, $end_time);
                $product_total_profit = $product_total_sales_value - $product_cost_price* $product_quantity_sold;
                $compiled_substore_products[$substore_inventory_item->product_id] = [
                    'product_id'=> $selected_substore->name,
                    'product_name'=>$substore_inventory_item->product->name(),
                    'product_current_invetory'=> $selected_substore->productInventory($substore_inventory_item->product_id),
                    'product_quantity_sold'=> $product_quantity_sold,
                    'product_selling_price'=> $product_selling_price,
                    'product_cost_price'=> $product_cost_price,
                    'product_total_sales_value'=> $product_total_sales_value,
                    'product_total_profit'=> $product_total_profit,
                    'product_total_commission'=>$product_total_profit * 0.05,
                    

                ];

                $grand_total_product_selling_price += $product_selling_price;
                $grand_total_product_cost_price += $product_cost_price;
                $grand_total_product_total_sales_value += $product_total_sales_value;
                $grand_total_product_total_profit += $product_total_profit;
                $grand_total_product_total_commission += $product_total_profit *0.05;
            }


            $view_data['compiled_substore_products']  = $compiled_substore_products;
            $view_data['grand_total_product_selling_price']  = $grand_total_product_selling_price ;
            $view_data['grand_total_product_cost_price']  = $grand_total_product_cost_price ;
            $view_data['grand_total_product_total_sales_value']  = $grand_total_product_total_sales_value ;
            $view_data['grand_total_product_total_profit']  = $grand_total_product_total_profit;
            $view_data['grand_total_product_total_commission']  = $grand_total_product_total_commission;
            
            $view_data['graph_sales_array']  = $graph_sales_array;
            $view_data['number_of_days_in_interval']  = $number_of_days_in_interval;
            $view_data['highest_graph_value']  = $highest_graph_value;
            $view_data['substore_total_sales'] = $selected_substore->total_sales($start_time, $end_time );
            $view_data['substore_total_lodgement'] = $selected_substore->total_lodgements($start_time, $end_time );

        
        //Lubebay services coputations
           
        $start_time= $start_time->startOfDay() ;
        $end_time = $end_time->startOfDay();
            $view_data['lubebay'] = $selected_lubebay;
            

            $dateinterval = new CarbonPeriod(
                $start_time,
                '1 day',
                $end_time
            ); 
            
            $number_of_days_in_interval = $dateinterval->count();
            $graph_label_array = [];
            $highest_lubebay_graph_value =  0;

            foreach ($dateinterval as $date) {
            
                $start_of_day = Carbon::createFromTimestamp($date->timestamp)->startOfDay() ;
                $end_of_day = Carbon::createFromTimestamp($date->timestamp)->endOfDay();

                $graph_label_array[] = $start_of_day->format('d');

                $graph_lubebay_sales_array[] = $selected_lubebay->total_sales($start_of_day, $end_of_day );

                if($selected_lubebay->total_sales($start_of_day, $end_of_day ) > $highest_lubebay_graph_value){
                    $highest_lubebay_graph_value = $selected_lubebay->total_sales($start_of_day, $end_of_day );
                }


            }

            //lubebay sales report
            $grand_total_service_price = 0;
            $grand_total_service_total_sales_value = 0;
            $grand_total_service_total_profit = 0;
            $compiled_lubebay_services = [];
            //return $selected_lubebay;
            foreach(Service::all() as $service){

                $service_quantity_sold  = $selected_lubebay->serviceSalesQuantity($service->id,$start_time, $end_time);
                $service_price = $service->price;
                $service_total_sales_value = $selected_lubebay->serviceSalesValue($service->id,$start_time, $end_time);
                $compiled_lubebay_services[$service->id] = [
                    'service_id'=> $service->id,
                    'service_name'=>$service->service_name,
                    'service_quantity_sold'=> $service_quantity_sold,
                    'service_price'=> $service_price,
                    'service_total_sales_value'=> $service_total_sales_value,
                    

                ];

                $grand_total_service_price += $service_price;
                $grand_total_service_total_sales_value    += $service_total_sales_value;
            }

            $grand_total_service_expense = $selected_lubebay->total_expenses($start_time, $end_time );
            $grand_total_service_profit = $selected_lubebay->total_sales($start_time, $end_time ) - $selected_lubebay->total_expenses($start_time, $end_time );


            $view_data['compiled_lubebay_services']  = $compiled_lubebay_services;
            $view_data['grand_total_service_price']  = $grand_total_service_price ;
            $view_data['grand_total_service_total_sales_value']  = $grand_total_service_total_sales_value ;
            $view_data['grand_total_service_expense']  = $grand_total_service_expense ;
            $view_data['grand_total_service_profit']  = $grand_total_service_profit ;
            
            $view_data['graph_lubebay_sales_array']  = $graph_lubebay_sales_array;
            $view_data['graph_label_array']  = json_encode($graph_label_array);
            $view_data['number_of_days_in_interval']  = $number_of_days_in_interval;
            $view_data['highest_lubebay_graph_value']  = $highest_lubebay_graph_value;
            $view_data['lubebay_total_sales'] = $selected_lubebay->total_sales($start_time, $end_time );
            $view_data['lubebay_total_lodgement'] = $selected_lubebay->total_lodgements($start_time, $end_time );
            $view_data['lubebay_total_expenses'] = $selected_lubebay->total_expenses($start_time, $end_time );

        
       
        return view('dashboard_lubebay_details',$view_data);
    }
    
    private function totalMofadDirectSales($start_time= null, $end_time = null){
        if($start_time==null && $end_time == null){
            $start_time= now()->startOfMonth() ;
            $end_time = now()->endOfMonth() ;
        }
        elseif($start_time==null && $end_time != null){
            $start_time = Carbon::create(2020, 1, 1, 0); //strtotime('2020-01-01 00:00:00');
        }

        elseif($start_time != null && $end_time == null){
            $end_time = now();
        }
        $sales_totals = 0;
 
                                 
        foreach (Prf::whereIn('client_id',Customer::all()->where('customer_type','1')->pluck('id')->toArray())->whereIn('approval_status',["AWAITING_APPROVAL","APPROVED_NOT_COLLECTED","APPROVED_COLLECTED"])->whereBetween('created_at', [$start_time,$end_time])->get() as $prf) {
                   
            $sales_totals += $prf->order_total;
            
        }
        return $sales_totals;
    }

    public function directSales(Request $request){

        if($request->input('start_date')==null && $request->input('end_date')==null ){
            $start_date= now()->startOfMonth() ;
            $end_date = now()->endOfMonth() ;
           
        }
        elseif($request->input('start_date')!=null && $request->input('end_date') !=null ){
            $start_date = Carbon::create($request->input('start_date'),0); //strtodate('2020-01-01 00:00:00');
            $end_date = Carbon::create($request->input('end_date'),0);
            
        }
        elseif($request->input('start_date')==null && $request->input('end_date')!=null ){
            $start_date = Carbon::create(2020, 1, 1, 0); //strtodate('2020-01-01 00:00:00');
            $end_date = Carbon::create($request->input('end_date'),0);
        }
        elseif($request->input('start_date')!=null && $request->input('end_date')==null){
            $start_date = Carbon::create($request->input('start_date'), 0);
            $end_date = now();
        }

         
        $start_time = $start_date->startOfDay() ;
        $end_time = $end_date->startOfDay();
        $view_data['start_date'] = $start_date;
        $view_data['end_date'] = $end_date;
        
        $dateinterval = new CarbonPeriod(
            $start_time,
            '1 day',
            $end_time
        ); 
        
        $number_of_days_in_interval = $dateinterval->count();
        $highest_graph_value =  0;
        $graph_label_array = [];
        $graph_data = [];
        array_push($graph_data,  ['Location', 'Sales']);

        foreach ($dateinterval as $date) {
            $start_of_day = Carbon::createFromTimestamp($date->timestamp)->startOfDay() ;
            $end_of_day = Carbon::createFromTimestamp($date->timestamp)->endOfDay();
            $total_mofad_direct_sales = $this->totalMofadDirectSales($start_of_day, $end_of_day );
            $graph_sales_array[] = $total_mofad_direct_sales;
            $graph_label_array[] = $start_of_day->format('d');

            if($total_mofad_direct_sales > $highest_graph_value){
                $highest_graph_value = $total_mofad_direct_sales;
            }

            $label_values = [$start_of_day->format('d'), $total_mofad_direct_sales];
            array_push($graph_data, $label_values);

        }

        
        $products = Product::all();
        $direct_sales_customers_array = Customer::all()->where('customer_type','1')->pluck('id')->toArray();
        $prf_list  = Prf::whereIn('client_id', $direct_sales_customers_array )->whereIn('approval_status',["AWAITING_APPROVAL","APPROVED_NOT_COLLECTED","APPROVED_COLLECTED"])->whereBetween('created_at', [$start_time,$end_time])->get();
        $compiled_product_list= [];
        $grand_total_quantity = 0;
        $grand_total_price  = 0;
        $grand_total_lodged  = 0;
        foreach ($products as $product) {
            $comipled_product_list[$product->id] = [
                'product_id'=> $product->id,
                'product_name'=> $product->name(),
                'total_quantity'=> 0,
                'total_price'=> 0,
            ];
        }
        foreach ($prf_list as $prf) {
            foreach ($prf->order_snapshot() as $order_item) {
                $comipled_product_list[$order_item->product_id]['total_quantity'] += $order_item->product_quantity;
                $comipled_product_list[$order_item->product_id]['total_price'] += $order_item->product_quantity*$order_item->product_price;
                $grand_total_quantity += $order_item->product_quantity;
                $grand_total_price += $order_item->product_quantity*$order_item->product_price;

            }
            
        }

                
        $graph_values = $graph_sales_array;
        $view_data['graph_values'] = $graph_values;
        $customer_account_trasactions = CustomerTransaction::whereBetween('created_at', [$start_time,$end_time])->whereIn('customer_id',$direct_sales_customers_array)->where('transaction_type','CREDIT')->get();
        
        foreach ($customer_account_trasactions as $transaction) {
            $grand_total_lodged +=  $transaction->amount;
        }
        
        $view_data['graph_sales_array']  = $graph_sales_array;
        $view_data['number_of_days_in_interval']  = $number_of_days_in_interval;
        $view_data['highest_graph_value']  = $highest_graph_value;
        $view_data['graph_label_array']  = json_encode($graph_label_array);
        $view_data['graph_data']  = json_encode($graph_data);
        $view_data['mofad_total_direct_sales'] = $grand_total_price;
        $view_data['mofad_total_direct_sales_lodgement'] = $grand_total_lodged;

        $view_data['grand_total_quantity'] = $grand_total_quantity;
        $view_data['grand_total_lodged'] = $grand_total_lodged;
        $view_data['grand_total_price']  = $grand_total_price;
        $view_data['comipled_product_list']  = $comipled_product_list;


        $lubebays = Lubebay::all();
            $compiled_lubebays = [];
            $grand_total  = 0;
            $lodgement_grand_total  = 0;
            $expense_grand_total = 0;
            $compiled_substores = [];
            $substores_grand_total  = 0;
            $substores_lodgements_grand_total = 0;
            foreach ($lubebays as $lubebay) {
                $compiled_lubebays[$lubebay->id] = [
                    'lubebay_name'=> $lubebay->name,
                    'lubebay_sales_totals'=>0,
                    'lubebay_lodgement_totals'=>0,
                    'lubebay_expense_totals'=>0,


                ];
                foreach ($lubebay->lsts->whereBetween('created_at', [$start_time,$end_time]) as $lubebay_lst) {
                   
                    $compiled_lubebays[$lubebay->id]['lubebay_sales_totals'] += $lubebay_lst->total_amount;
                    $grand_total += $lubebay_lst->total_amount;
                }

                foreach ($lubebay->expenses_range($start_time,$end_time) as $lubebay_expense) {
                    $compiled_lubebays[$lubebay->id]['lubebay_expense_totals'] += $lubebay_expense->amount;
                    $expense_grand_total += $lubebay_expense->amount;
                }
                foreach ($lubebay->lodgements_range($start_time,$end_time) as $lodgement) {
                    $compiled_lubebays[$lubebay->id]['lubebay_lodgement_totals'] += $lodgement->amount;
                    $lodgement_grand_total += $lodgement->amount;
                }
            }
        
        
        
        $view_data['lubebays_expense_grand_total']  = $expense_grand_total;
        $view_data['lubebays_grand_total']  = $grand_total;
        $view_data['compiled_lubebays']  = $compiled_lubebays;


        $substores = Substore::all();
            $compiled_substores = [];
            $grand_total  = 0;
            $expense_grand_total = 0;
            foreach ($substores as $substore) {
                $compiled_substores[$substore->id] = [
                    'substore_name'=> $substore->name,
                    'substore_sales_totals'=>0,
                    'substore_expense_totals'=>0,
                    'substore_lodgement_totals'=>0

                ];
                foreach ($substore->ssts->whereBetween('created_at', [$start_time,$end_time]) as $substore_sst) {
                   
                    $compiled_substores[$substore->id]['substore_sales_totals'] += $substore_sst->total_amount;
                    $grand_total += $substore_sst->total_amount;
                }

                
                foreach ($substore->lodgements_range($start_time,$end_time) as $lodgement) {
                    $compiled_substores[$substore->id]['substore_lodgement_totals'] += $lodgement->amount;
                    $substores_lodgements_grand_total += $lodgement->amount;
                }
            }
        
        
        $view_data['substores_grand_total']  = $substores_grand_total;
        $view_data['substores_lodgement_grand_total']  = $substores_lodgements_grand_total;
        $view_data['compiled_substores']  = $compiled_substores;


        // $substores = Substore::all();
        //     $compiled_sources = [];
        //     $sources_grand_total  = 0;
        //     $sources_lodgement_grand_total = 0;
        //     foreach ($substores as $substore) {
        //         $compiled_lubebays[$lubebay->id] = [
        //             'source_name'=> $substore->name,
        //             'source_sales_totals'=>0,
        //             'source_lodgement_totals'=>0,


        //         ];
        //         foreach ($lubebay->ssts->whereBetween('created_at', [$start_time,$end_time]) as $lubebay_lst) {
                   
        //             $compiled_lubebays[$lubebay->id]['lubebay_sales_totals'] += $lubebay_lst->total_amount;
        //             $grand_total += $lubebay_lst->total_amount;
        //         }

        //         foreach ($lubebay->expenses as $lubebay_expense) {
        //             $compiled_lubebays[$lubebay->id]['lubebay_expense_totals'] += $lubebay_expense->amount;
        //             $expense_grand_total += $lubebay_expense->amount;
        //         }
        //     }
        
        
        
        // $view_data['lubebays_expense_grand_total']  = $expense_grand_total;
        // $view_data['lubebays_grand_total']  = $grand_total;
        // $view_data['compiled_lubebays']  = $compiled_lubebays;

        // dd($view_data);
       
        return view('dashboard_direct_sales',$view_data);
    }

    public function viewStates(){
        $view_data['state_list'] = State::all();
        return view('dashboard_state_list',$view_data);
    }

    public function stateSales(Request $request, State $state){

        if($request->input('start_date')==null && $request->input('end_date')==null ){
            $start_date= now()->startOfMonth() ;
            $end_date = now()->endOfMonth() ;
           
        }
        elseif($request->input('start_date')!=null && $request->input('end_date') !=null ){
            $start_date = Carbon::create($request->input('start_date'),0); //strtodate('2020-01-01 00:00:00');
            $end_date = Carbon::create($request->input('end_date'),0);
            
        }
        elseif($request->input('start_date')==null && $request->input('end_date')!=null ){
            $start_date = Carbon::create(2020, 1, 1, 0); //strtodate('2020-01-01 00:00:00');
            $end_date = Carbon::create($request->input('end_date'),0);
        }
        elseif($request->input('start_date')!=null && $request->input('end_date')==null){
            $start_date = Carbon::create($request->input('start_date'), 0);
            $end_date = now();
        }

         
        $start_time = $start_date->startOfDay() ;
        $end_time = $end_date->startOfDay();
        $view_data['start_date'] = $start_date;
        $view_data['end_date'] = $end_date;
        
        $dateinterval = new CarbonPeriod(
            $start_time,
            '1 day',
            $end_time
        ); 
        
        $number_of_days_in_interval = $dateinterval->count();
        $highest_graph_value =  0;
        $graph_label_array = [];

        foreach ($dateinterval as $date) {
           
            $start_of_day = Carbon::createFromTimestamp($date->timestamp)->startOfDay() ;
            $end_of_day = Carbon::createFromTimestamp($date->timestamp)->endOfDay();
            $total_state_direct_sales = $state->totalDirectSales($start_of_day, $end_of_day );
            $graph_sales_array[] = $total_state_direct_sales;
            $graph_label_array[] = $start_of_day->format('d');

            if($total_state_direct_sales > $highest_graph_value){
                $highest_graph_value = $total_state_direct_sales;
            }


        }
        
        
        $products = Product::all();
        $direct_sales_customers_array = Customer::all()->where('customer_type',1)->where('state',$state->id)->pluck('id')->toArray();
        
        $state_warehouses_array = $state->warehouses->first()->pluck('id')->toArray();
        //return $state_warehouses_array; //$state->warehouses->first()->directSalesPrfs();
        $prf_list  = Prf::whereIn('client_id', $direct_sales_customers_array )->whereIn('warehouse_id', $state_warehouses_array )->whereIn('approval_status',["APPROVED_NOT_COLLECTED","APPROVED_COLLECTED"])->where('created_at', '>=', $start_time)
        ->where('created_at', '<=', $end_time)->get();
        //return print_r($state_warehouses_array);
        $compiled_product_list= [];
        $grand_total_quantity = 0;
        $grand_total_price  = 0;
        $grand_total_lodged  = 0;
        foreach ($products as $product) {
            $comipled_product_list[$product->id] = [
                'product_id'=> $product->id,
                'product_name'=> $product->name(),
                'total_quantity'=> 0,
                'total_price'=> 0,
            ];
        }
        foreach ($prf_list as $prf) {
            foreach ($prf->order_snapshot() as $order_item) {
                $comipled_product_list[$order_item->product_id]['total_quantity'] += $order_item->product_quantity;
                $comipled_product_list[$order_item->product_id]['total_price'] += $order_item->product_quantity*$order_item->product_price;
                $grand_total_quantity += $order_item->product_quantity;
                $grand_total_price += $order_item->product_quantity*$order_item->product_price;

            }
            
        }

                
        $graph_values = $graph_sales_array;
        $view_data['graph_values'] = $graph_values;
        $customer_account_trasactions = CustomerTransaction::whereBetween('created_at', [$start_time,$end_time])->whereIn('customer_id',$direct_sales_customers_array)->where('transaction_type','CREDIT')->get();
        
        foreach ($customer_account_trasactions as $transaction) {
            $grand_total_lodged +=  $transaction->amount;
        }
        
        $view_data['graph_sales_array']  = $graph_sales_array;
        $view_data['number_of_days_in_interval']  = $number_of_days_in_interval;
        $view_data['highest_graph_value']  = $highest_graph_value;
        $view_data['mofad_total_direct_sales'] = $grand_total_price;
        $view_data['mofad_total_direct_sales_lodgement'] = $grand_total_lodged;

        $view_data['grand_total_quantity'] = $grand_total_quantity;
        $view_data['grand_total_lodged'] = $grand_total_lodged;
        $view_data['grand_total_price']  = $grand_total_price;
        $view_data['comipled_product_list']  = $comipled_product_list;



        $highest_services_graph_value =  0;

        foreach ($dateinterval as $date) {
           
            $start_of_day = Carbon::createFromTimestamp($date->timestamp)->startOfDay() ;
            $end_of_day = Carbon::createFromTimestamp($date->timestamp)->endOfDay();
            $total_state_services_sales = $state->totalLubebayServiceSales($start_of_day, $end_of_day );
            $graph_lubebay_service_sales_array[] = $total_state_services_sales;

            if($total_state_services_sales > $highest_services_graph_value){
                $highest_services_graph_value = $total_state_services_sales;
            }


        }
        
        
        $services = Service::all();
        
        $state_lubebays_array = $state->lubebays->pluck('id')->toArray();
        //return $state_warehouses_array; //$state->warehouses->first()->directSalesPrfs();
        $lst_list  = LubebayServiceTransaction::whereIn('lubebay_id', $state_lubebays_array )->whereIn('approval_status',["CONFIRMED"])->where('created_at', '>=', $start_time)
        ->where('created_at', '<=', $end_time)->get();
        //return print_r($state_warehouses_array);
        $compiled_service_list= [];
        $grand_total_lubebay_service_quantity = 0;
        $grand_total_lubebay_service_price  = 0;
        $grand_total_lubebay_service_lodged  = 0;
        foreach ($services as $service) {
            $comipled_service_list[$service->id] = [
                'service_id'=> $service->id,
                'service_name'=> $service->service_name,
                'service_total_quantity'=> 0,
                'service_total_price'=> 0,
            ];
        }
        foreach ($lst_list as $lst) {
            foreach ($lst->order_snapshot() as $sales_items) {
                $comipled_service_list[$sales_items->service_id]['service_total_quantity'] += $sales_items->service_quantity;
                $comipled_service_list[$sales_items->service_id]['service_total_price'] += $sales_items->service_quantity*$sales_items->service_price;
                $grand_total_lubebay_service_quantity += $sales_items->service_quantity;
                $grand_total_lubebay_service_price += $sales_items->service_quantity*$sales_items->service_price;

            }
            
        }

                
        $lubebay_service_graph_values = $graph_lubebay_service_sales_array;
        $view_data['lubebay_service_graph_values'] = $lubebay_service_graph_values;
        $customer_account_trasactions = CustomerTransaction::whereBetween('created_at', [$start_time,$end_time])->whereIn('customer_id',$direct_sales_customers_array)->where('transaction_type','CREDIT')->get();
        
        
            $grand_total_service_lodged =  $state->totalLubebayServicelogement($start_time,$end_time) ;
        
        
        $view_data['graph_lubebay_service_sales_array']  = $graph_lubebay_service_sales_array;
        $view_data['number_of_days_in_interval']  = $number_of_days_in_interval;
        $view_data['highest_services_graph_value']  = $highest_services_graph_value;
        $view_data['graph_label_array']  = json_encode($graph_label_array);

        $view_data['grand_total_lubebay_service_price'] = $grand_total_lubebay_service_price;
        $view_data['grand_total_lubebay_service_lodged'] = $grand_total_lubebay_service_lodged;

        $view_data['grand_total_lubebay_service_quantity'] = $grand_total_lubebay_service_quantity;
        $view_data['comipled_service_list']  = $comipled_service_list;
        $view_data['state']  = $state;



       
        return view('dashboard_state_sales',$view_data);
    }

    public function viewWarehouses(){
        $view_data['warehouse_list'] = Warehouse::all();
        return view('view_warehouse',$view_data);
    }

    public function wareouseSales(Request $request, State $state){

        $start_time= now()->startOfMonth()->startOfDay() ;
        $end_time = now();
        
        $dateinterval = new CarbonPeriod(
            $start_time,
            '1 day',
            $end_time
        ); 
        
        $number_of_days_in_interval = $dateinterval->count();
        $highest_graph_value =  0;

        foreach ($dateinterval as $date) {
           
            $start_of_day = Carbon::createFromTimestamp($date->timestamp)->startOfDay() ;
            $end_of_day = Carbon::createFromTimestamp($date->timestamp)->endOfDay();
            $total_state_direct_sales = $state->totalDirectSales($start_of_day, $end_of_day );
            $graph_sales_array[] = $total_state_direct_sales;

            if($total_state_direct_sales > $highest_graph_value){
                $highest_graph_value = $total_state_direct_sales;
            }


        }
        
        
        $products = Product::all();
        $direct_sales_customers_array = Customer::all()->where('customer_type',1)->where('state',$state->id)->pluck('id')->toArray();
        
        $state_warehouses_array = $state->warehouses->first()->pluck('id')->toArray();
        //return $state_warehouses_array; //$state->warehouses->first()->directSalesPrfs();
        $prf_list  = Prf::whereIn('client_id', $direct_sales_customers_array )->whereIn('warehouse_id', $state_warehouses_array )->whereIn('approval_status',["APPROVED_NOT_COLLECTED","APPROVED_COLLECTED"])->where('created_at', '>=', $start_time)
        ->where('created_at', '<=', $end_time)->get();
        //return print_r($state_warehouses_array);
        $compiled_product_list= [];
        $grand_total_quantity = 0;
        $grand_total_price  = 0;
        $grand_total_lodged  = 0;
        foreach ($products as $product) {
            $comipled_product_list[$product->id] = [
                'product_id'=> $product->id,
                'product_name'=> $product->name(),
                'total_quantity'=> 0,
                'total_price'=> 0,
            ];
        }
        foreach ($prf_list as $prf) {
            foreach ($prf->order_snapshot() as $order_item) {
                $comipled_product_list[$order_item->product_id]['total_quantity'] += $order_item->product_quantity;
                $comipled_product_list[$order_item->product_id]['total_price'] += $order_item->product_quantity*$order_item->product_price;
                $grand_total_quantity += $order_item->product_quantity;
                $grand_total_price += $order_item->product_quantity*$order_item->product_price;

            }
            
        }

                
        $graph_values = $graph_sales_array;
        $view_data['graph_values'] = $graph_values;
        $customer_account_trasactions = CustomerTransaction::whereBetween('created_at', [$start_time,$end_time])->whereIn('customer_id',$direct_sales_customers_array)->where('transaction_type','CREDIT')->get();
        
        foreach ($customer_account_trasactions as $transaction) {
            $grand_total_lodged +=  $transaction->amount;
        }
        
        $view_data['graph_sales_array']  = $graph_sales_array;
        $view_data['number_of_days_in_interval']  = $number_of_days_in_interval;
        $view_data['highest_graph_value']  = $highest_graph_value;
        $view_data['mofad_total_direct_sales'] = $grand_total_price;
        $view_data['mofad_total_direct_sales_lodgement'] = $grand_total_lodged;

        $view_data['grand_total_quantity'] = $grand_total_quantity;
        $view_data['grand_total_lodged'] = $grand_total_lodged;
        $view_data['grand_total_price']  = $grand_total_price;
        $view_data['comipled_product_list']  = $comipled_product_list;



        $highest_services_graph_value =  0;

        foreach ($dateinterval as $date) {
           
            $start_of_day = Carbon::createFromTimestamp($date->timestamp)->startOfDay() ;
            $end_of_day = Carbon::createFromTimestamp($date->timestamp)->endOfDay();
            $total_state_services_sales = $state->totalLubebayServiceSales($start_of_day, $end_of_day );
            $graph_lubebay_service_sales_array[] = $total_state_services_sales;

            if($total_state_services_sales > $highest_services_graph_value){
                $highest_services_graph_value = $total_state_services_sales;
            }


        }
        
        
        $services = Service::all();
        
        $state_lubebays_array = $state->lubebays->pluck('id')->toArray();
        //return $state_warehouses_array; //$state->warehouses->first()->directSalesPrfs();
        $lst_list  = LubebayServiceTransaction::whereIn('lubebay_id', $state_lubebays_array )->whereIn('approval_status',["CONFIRMED"])->where('created_at', '>=', $start_time)
        ->where('created_at', '<=', $end_time)->get();
        //return print_r($state_warehouses_array);
        $compiled_service_list= [];
        $grand_total_lubebay_service_quantity = 0;
        $grand_total_lubebay_service_price  = 0;
        $grand_total_lubebay_service_lodged  = 0;
        foreach ($services as $service) {
            $comipled_service_list[$service->id] = [
                'service_id'=> $service->id,
                'service_name'=> $service->service_name,
                'service_total_quantity'=> 0,
                'service_total_price'=> 0,
            ];
        }
        foreach ($lst_list as $lst) {
            foreach ($lst->order_snapshot() as $sales_items) {
                $comipled_service_list[$sales_items->service_id]['service_total_quantity'] += $sales_items->service_quantity;
                $comipled_service_list[$sales_items->service_id]['service_total_price'] += $sales_items->service_quantity*$sales_items->service_price;
                $grand_total_lubebay_service_quantity += $sales_items->service_quantity;
                $grand_total_lubebay_service_price += $sales_items->service_quantity*$sales_items->service_price;

            }
            
        }

                
        $lubebay_service_graph_values = $graph_lubebay_service_sales_array;
        $view_data['lubebay_service_graph_values'] = $lubebay_service_graph_values;
        $customer_account_trasactions = CustomerTransaction::whereBetween('created_at', [$start_time,$end_time])->whereIn('customer_id',$direct_sales_customers_array)->where('transaction_type','CREDIT')->get();
        
        
            $grand_total_service_lodged =  $state->totalLubebayServicelogement($start_time,$end_time) ;
        
        
        $view_data['graph_lubebay_service_sales_array']  = $graph_lubebay_service_sales_array;
        $view_data['number_of_days_in_interval']  = $number_of_days_in_interval;
        $view_data['highest_services_graph_value']  = $highest_services_graph_value;
        $view_data['grand_total_lubebay_service_price'] = $grand_total_lubebay_service_price;
        $view_data['grand_total_lubebay_service_lodged'] = $grand_total_lubebay_service_lodged;

        $view_data['grand_total_lubebay_service_quantity'] = $grand_total_lubebay_service_quantity;
        $view_data['comipled_service_list']  = $comipled_service_list;
        $view_data['state']  = $state;



       
        return view('dashboard_warehouse_sales',$view_data);
    }

    public function lubebayServicecesOverview(){
        
            $lubebays = Lubebay::all();
            $compiled_lubebays = [];
            $grand_total  = 0;
            $expense_grand_total = 0;
            foreach ($lubebays as $lubebay) {
                $compiled_lubebays[$lubebay->id] = [
                    'lubebay_name'=> $lubebay->name,
                    'lubebay_sales_totals'=>0,
                    'lubebay_expense_totals'=>0,


                ];
                foreach ($lubebay->lsts as $lubebay_lst) {
                   
                    $compiled_lubebays[$lubebay->id]['lubebay_sales_totals'] += $lubebay_lst->total_amount;
                    $grand_total += $lubebay_lst->total_amount;
                }

                foreach ($lubebay->expenses as $lubebay_expense) {
                    $compiled_lubebays[$lubebay->id]['lubebay_expense_totals'] += $lubebay_expense->amount;
                    $expense_grand_total += $lubebay_expense->amount;
                }
            }
        
        
        
        $view_data['expense_grand_total']  = $expense_grand_total;
        $view_data['grand_total']  = $grand_total;
        $view_data['compiled_lubebays']  = $compiled_lubebays;
       
        return view('dashboard_lubebay_overview',$view_data);
    }
    
    public function salesrepSalesSummery(Request $request){
        $view_data['sales_rep_orders'] = [];
        if($request->isMethod('get')){
            $sales_rep = Auth::user();
            $sales_rep_orders = Prf::where('sales_rep',$sales_rep->id)->get();
            $total_order_value = 0;
            $total_amount_paid = 0;
            $total_amount_outstanding = 0;
            foreach ($sales_rep_orders as $order) {
                $total_order_value += $order->order_total;
                $total_amount_paid += $order->totalPaid();
                $total_amount_outstanding += $order->order_total - $order->totalPaid();
            }
            $view_data['total_order_value'] = $total_order_value ;
            $view_data['total_amount_paid'] = $total_amount_paid ;
            $view_data['total_amount_outstanding'] = $total_amount_outstanding;

            $view_data['sales_rep_orders'] = $sales_rep_orders;
            
        }
        
        return view('salesrep_sales_summery_report',$view_data);
    }

    public function salesrepSalesReport(Request $request ){
        if($request->isMethod('post')){
            $request->validate([
                'month' => 'required|min:1|max:12',
                'user' => 'required'
            ]);
            $report_year = 2020;
            $report_start_of_month = Carbon::create($report_year, $request->input('month') , 1);
            $report_end_of_month = Carbon::create($report_year, $request->input('month') , 1);
           
            $start_time  = $report_start_of_month->startOfMonth();
            $end_time = $report_end_of_month->endOfMonth();
             $sales_rep = User::find($request->input('user'));
            

        }
        else{
            $start_time  = now()->startOfMonth();
            $end_time = now()->endOfMonth();
            $sales_rep = Auth::user();
        }
        
        

        
            $sales_rep_orders = Prf::where('sales_rep',$sales_rep->id)
                                    ->whereIn('client_id',Customer::all()->where('customer_type',1)->pluck('id')->toArray())
                                    ->where('created_at', '>=', $start_time)->where('created_at', '<=', $end_time)
                                    ->get();
            $sales_rep_clients = array_unique($sales_rep_orders->pluck('client_id')->toArray());
            $sales_rep_client_orders = [];
            $grand_total_sales_value = 0 ;
            foreach ($sales_rep_clients as $sales_rep_client) {
                $client_order_ids =[];
                $client_total_order_value = 0;
                $client_total_payments  = 0;
                $client_balance  = 0;

                foreach($sales_rep_orders->where('client_id',$sales_rep_client) as $client_order){
                    $client_order_ids[] = $client_order->id;
                    $client_total_order_value = $client_order->order_total ;
                    $client_total_payments  = $client_order->customer->totalPayments($start_time,$end_time);
                   
                    $client_name = $client_order->customer->name;
                }
                $sales_rep_client_orders[] = [
                    'client_order_ids' => $client_order_ids,
                    'client_name' => $client_name,
                    'client_total_order_value' => $client_total_order_value,
                    'sales_rep' => $sales_rep->name,
                    'client_total_payments' =>  $client_total_payments,
                    'client_balance' =>  $client_order->customer->paymentIntervalLastBalance($start_time,$end_time)

                ];

                $grand_total_sales_value += $client_total_order_value ;
                
            }
            

            // $total_order_value = 0;
            // $total_amount_paid = 0;
            // $total_amount_outstanding = 0;
            // foreach ($sales_rep_orders as $order) {
            //     $total_order_value += $order->order_total;
            //     $total_amount_paid += $order->totalPaid();
            //     $total_amount_outstanding += $order->order_total - $order->totalPaid();
            // }
            $system_users = User::all();
            $view_data['sales_rep_client_orders'] = $sales_rep_client_orders;
            $view_data['grand_total_sales_value'] = $grand_total_sales_value ;
            $view_data['sales_rep'] = $sales_rep->name ;
            $view_data['month'] = $start_time->format('F-Y');
            //return $start_time;
            $view_data['system_users'] = $system_users ;
            
        
        
        return view('salesrep_sales_summery_report',$view_data);
    }
}
