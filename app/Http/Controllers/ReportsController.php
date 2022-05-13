<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prf;
use App\Models\Pro;
use App\Models\Product;
use App\Models\Service;
use App\Models\Lubebay;
use App\Models\Substore;
use App\Models\SubstoreInventory;
use App\Models\Warehouse;
use App\Models\WarehouseInventory;
use App\Models\Customer;
use App\Models\LubebayServiceTransaction;
use App\Models\Account;
use App\Models\AccountTransaction;
use App\Models\State;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;


use App\Exports\ReportExport;
use Datatables;

use Illuminate\Support\Facades\Auth;
use  Maatwebsite\Excel\Facades\Excel;
use App\DataTables\CustomersDataTable;
use App\DataTables\CustomerTransactionDataTable;

class ReportsController extends Controller
{

    public function lubebayIncomeStatementList(){
        $view_data['lubebay_list'] = Lubebay::all();
        return view('report_lubebay_income_statement_list',$view_data);
    }

    public function lubebayIncomeStatement(Lubebay $lubebay, Request $request ){
       $account = $lubebay->account;
       //return $account->transactions;
       $view_data['lubebay'] = $lubebay;
       $lubebay_data = ['expenses'=>0,'revenue'=>0] ;
       foreach ($account->transactions as $transaction) {
           if ($transaction->transaction_type=='CREDIT') {
               $lubebay_data['revenue'] += $transaction->amount;
           }
           elseif($transaction->transaction_type=='DEBIT') {
            $lubebay_data['expenses'] += $transaction->amount;
           }
       }
       $view_data['lubebay_data'] = $lubebay_data;
       return view('report_lubebay_income_statement',$view_data);
    }
    
    public function totalStockValue(){
        $products = Product::all() ;
        $total_inventory_value = 0;
        $total_account_balances = 0;
        $total_customer_credit = 0;
        foreach ($products as $product) {
            $comipled_product_list[$product->id] = [
                'product_id'=> $product->id,
                'product_name'=> $product->name(),
                'product_price'=> $product->cost_price,
                'total_quantity'=> 0,
                'total_price'=> 0,
            ];
        }
        foreach (Warehouse::all() as $warehouse) {
            foreach($comipled_product_list as $product_list_item){
                $comipled_product_list[$product_list_item['product_id']]['total_quantity'] += $warehouse->productInventory($product_list_item['product_id']);
               // print($product_list_item['total_quantity'].'-'.$warehouse->productInventory($product_list_item['product_id']).'<br>');
                $comipled_product_list[$product_list_item['product_id']]['total_price'] = $product_list_item['total_quantity'] * $product_list_item['product_price'] ;
            }
        }
        // print('<br>begin stored product list<br>');
        // print_r($comipled_product_list);
        // print('<br>end stored product list<br>');
        
        foreach (Substore::all() as $substore) {
            foreach($comipled_product_list as $product_list_item){
                $comipled_product_list[$product_list_item['product_id']]['total_quantity']  += $substore->productInventory($product_list_item['product_id']);
               // print($product_list_item['total_quantity'].'-'.$warehouse->productInventory($product_list_item['product_id']).'<br>');
                
                $comipled_product_list[$product_list_item['product_id']]['total_price'] = $product_list_item['total_quantity'] * $product_list_item['product_price'] ;
            }
        }
        foreach (Account::all()->whereIn('account_type',['MAIN','LUBEBAY_SUBSTORE','STATION_SUBSTORE']) as $account) {
            $total_account_balances += $account->balance;
        }
        foreach (Customer::where('customer_type',1)->where('balance','<',0)->get() as $custoemr_account) {
            $total_customer_credit += $custoemr_account->balance;
        }
        foreach ($comipled_product_list as $product_list_item) {
            $total_inventory_value += $product_list_item['total_price'];
        }
        $view_data['total_inventory_value'] = $total_inventory_value;
        $view_data['total_account_balances'] = $total_account_balances;
        $view_data['total_customer_credit'] = $total_customer_credit;
        return view('report_total_stock_value',$view_data);

    }

    public function warehouseInventory(Warehouse $warehouse){
        $view_data['warehouse'] = $warehouse;
        $view_data['products_list'] = Product::all();
        return view('warehouse_products_inventory',$view_data);
    }
    public function warehouseInventoryStoresList(){
        $view_data['warehouses_list'] = Auth::user()->allowedwarehouses();
        return view('warehouses_inventory_stores_list',$view_data);
    }

    public function stockInventoryAnalysisPage(){
        return view('reports');
    }

    public function stockInventoryAnalysis(){
        $grand_total_stock_value = 0; 
        
        $product_list = Product::all();
        $data[ ] = ['', '', '', '', ''];
        $data[ ] = ['', '', '', '', ''];
        $data[ ] = ['', '', '', '', ''];
        $data[ ] = ['', '', '', '', ''];

        foreach (State::all() as $state) {
            
            foreach (Warehouse::where('state', $state->id)->get() as $warehouse) {
                $data[ ] = [$warehouse->name, '', '', '' ,''];
                $data[ ] = ['Product Id', 'Product Name', 'Quantity', 'Price', 'Amount'];
                $store_total_stock_value = 0; 
            
                foreach (WarehouseInventory::where('warehouse_id',$warehouse->id)->get()->SortBy('product_id') as $inventry_item){
                    $store_product_name = Product::find($inventry_item->product_id)->name();
                    $store_product_quantity = $inventry_item->quantity;
                    $store_product_price = Product::find($inventry_item->product_id)->productPrice(1);
                    $store_product_id = $inventry_item->product_id;
                    $store_product_amount = $store_product_quantity*$store_product_price ;

                    $data[ ] = [$store_product_id, $store_product_name, $store_product_quantity, $store_product_price , $store_product_amount];
                    $grand_total_stock_value +=  $store_product_amount;
                    $store_total_stock_value += $store_product_amount;
                }
                $data[ ] = ['TOTAL', '', '', '', $store_total_stock_value];
                $data[ ] = ['', '', '', '', ''];
                $data[ ] = ['', '', '', '', ''];
            }

            foreach (Substore::where('state', $state->id)->get() as $substore) {
                $data[ ] = [$substore->name, '', '', '', ''];
                $data[ ] = ['Product Id', 'Product Name', 'Quantity', 'Price', 'Amount'];
                $store_total_stock_value = 0; 
            
                foreach (SubstoreInventory::where('substore_id',$substore->id)->get()->SortBy('product_id') as $inventry_item){

                    $store_product_name = Product::find($inventry_item->product_id)->name();
                    $store_product_quantity = $inventry_item->quantity;
                    $store_product_price = Product::find($inventry_item->product_id)->productPrice(1);
                    $store_product_id = $inventry_item->product_id;
                    $store_product_amount = $store_product_quantity*$store_product_price ;

                    $data[ ] = [$store_product_id, $store_product_name, $store_product_quantity, $store_product_price , $store_product_amount];
                    $grand_total_stock_value +=  $store_product_amount;
                    $store_total_stock_value += $store_product_amount;
                }
                $data[ ] = ['TOTAL', '', '', '', $store_total_stock_value];
                $data[ ] = ['', '', '', '', ''];
                $data[ ] = ['', '', '', '', ''];
            }

            
        }
        
        $grand_total_cash_with_customers = 0;
        foreach (Customer::where('customer_type',1)->get() as $customer ){
            if($customer->balance < 0){
                 $grand_total_cash_with_customers += $customer->balance;
            }
           
        }
        $grand_total_cash_with_customers = -1*$grand_total_cash_with_customers;
        $data[ ] = ['', '', '', '', ''];
        $data[ ] = ['', '', '', '', ''];
        $data[ ] = ['TOTAL CASH AT HAND', '', '', '', 0];
        $data[ ] = ['TOTAL CASH WITH CUSTOMERS', '', '', '', $grand_total_cash_with_customers];
        $data[ ] = ['MOFAD TOTAL STOCK VALUE', '', '', '', $grand_total_stock_value];
        $data[ ] = ['GRAND TOTAL', '', '', '', $grand_total_stock_value + $grand_total_cash_with_customers];
        $data[ ] = ['CAPITAL INVESTED', '', '', '', ''];
        $data[ ] = ['DIFFERENCES', '', '', '', $grand_total_stock_value + $grand_total_cash_with_customers];
        $export = new ReportExport($data);
        
    
        return Excel::download($export, 'StockInventoryAnalysis'.now().'.xlsx');
    }


    public function customerReports(CustomersDataTable $dataTable)
    {
        /* 
        TODO:
        - View list of customers
        - View customer report details
        - View list of all customer activities i.e orders and deposits
        - View list of customer orders
        - View list of customer deposits
        - Filter customers by orders and deposits
        - Generate report for list of customers in excel format
        - Generate report for a customer in excel format
        */

        // $customer_id = 2; //$request->input('customer_id');
        // $customer = Customer::find(2);
        // dd($customer->totalPurchases());

        // $customers = Customer::all();
        
        // return view('reports.customers.reports', ['customers'=>$customers]);
        
        return $dataTable->render('reports.customers.reports');
    }

    public function customerDataTable()
    {
        $customers = Customer::select(['id','name','address','balance']);

        return Datatables::of($customers)->make();
    }

    public function getCustomers(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::latest()->pluck('name', 'address', 'balance')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    
    public function salesReports(CustomerTransactionDataTable $dataTable){
        return $dataTable->render('reports.sales.reports');
    }


    public function reports( Request $request ){
        
        $view_data['lubebays'] = Lubebay::all();
        $view_data['substores'] = Substore::all();
        $view_data['customers'] = Customer::where([
            ['customer_type', '=', '1']
        ])->get();
        $view_data['states'] =  State::all();
        foreach ($view_data['customers'] as $key => $customer) {
            // dd($customer->name);
        }
        
        if ($request->isMethod("get") ) {
            return view('reports', $view_data);
        }
        
        elseif( $request->isMethod("post") && $request->input('report_type')=='substore_sales'){

            //todo
            //generate and populate rows 
            $request->validate([
                'month' => 'required',
                'substore' => 'required',
                'year'  => 'required'
            ]);
            $report_year = $request->input('year');

            $data[ ] = ['', '', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', ''];
            
            $substore =  Substore::find($request->input('substore'));
            $start_of_month = Carbon::create($report_year, $request->input('month') , 1)->startOfMonth();
            $end_of_month = Carbon::create($report_year, $request->input('month') , 1)->endOfMonth();

            $dateinterval = new CarbonPeriod(
                $start_of_month,
                '1 day',
                $end_of_month
            ); 
             
            //$revdate = Carbon::create(2020, 9 , 26);
           
            //return  $substore->productStock(59,now());
            //return  $substore->productStockRecieved(59,$revdate);
            $number_of_days_in_interval = $dateinterval->count();
            // $day_row =[];
            $title_row_created = false;
            $product_title_row = [""];
            $product_vilues_title_row  = [""] ;//=['QTY','REV','STOCK','PRICE','SALES','TOTAL']
            $substore_products_totals = [];
            $days_grand_total_value = 0;
           
            $substore_products = Product::all()->whereIn('id',SubstoreInventory::all()->pluck('product_id')->toArray());

            foreach ($substore_products as $substore_product) {
                $product_sale_quantity = $substore->productSalesQuantity($substore_product->id,$start_of_month , $end_of_month);
                $product_sale_value = $substore->productSalesValue($substore_product->id,$start_of_month, $end_of_month);
               
                $substore_products_totals[$substore_product->id]['product_name'] =  $substore_product->name();
                $substore_products_totals[$substore_product->id]['product_cost'] =  $substore_product->cost_price;
                $substore_products_totals[$substore_product->id]['product_price'] =  $substore_product->productPrice(2);
                
                $substore_products_totals[$substore_product->id]['product_quantity'] = 0;
                $substore_products_totals[$substore_product->id]['product_value'] = 0;
            
            }
            //return $substore_products_totals;
                
            foreach ($dateinterval as $date) {
                $start_of_day = Carbon::createFromTimestamp($date->timestamp)->startOfDay() ;
                $end_of_day = Carbon::createFromTimestamp($date->timestamp)->endOfDay();
                $days_total_value =0;
                $day_row = [];
                $day_row[] = $date->format('d-m-Y');
                //$substore_products = Product::all()->whereIn('id',SubstoreInventory::all()->pluck('id')->toArray());
                
                foreach ($substore_products as $substore_product) {
                    //insirt title row in firt loop
                    if(!$title_row_created){
                        array_push($product_title_row, $substore_product->name() ,'','','','','');
                        array_push($product_vilues_title_row, 'QTY','REV','STOCK','PRICE','SALES','TOTAL');
                        

                    }
                    $product_sale_quantity = $substore->productSalesQuantity($substore_product->id,$start_of_day , $end_of_day);
                    $product_sale_value = $substore->productSalesValue($substore_product->id,$start_of_day, $end_of_day);
                    $days_total_value += $product_sale_value;
                    $product_stock = $substore->productStock($substore_product->id,$start_of_day);
                    $products_recieved = $substore->productStockRecieved($substore_product->id,$date);
                    array_push($day_row,"".$product_stock[0], "".$products_recieved ,"".($products_recieved + $product_stock[0]), '‎₦'.$substore_product->productPrice('2'),"".$product_sale_quantity , '‎₦'.$product_sale_value );
                    
                    
                    $substore_products_totals[$substore_product->id]['product_quantity'] += $product_sale_quantity;
                    $substore_products_totals[$substore_product->id]['product_value'] += $product_sale_value;
                }
                $days_grand_total_value += $days_total_value;
            //title row created after first iteration of product inventory 
            if (!$title_row_created) {
                array_push($product_title_row,"");
                array_push($product_vilues_title_row,"GRAND TOTAL");
                $data[] =  $product_title_row ;
                $data[] = $product_vilues_title_row;

            }
            $title_row_created = true; 
            array_push($day_row,'‎₦'.$days_total_value);  
            $data[]= $day_row;
                   
    
            }

            $last_row = ["TOTAL"] ;
            //return $substore_products_totals;
            foreach ($substore_products_totals as $substore_products_total) {
               
                array_push($last_row ,'','','','',"".$substore_products_total['product_quantity'],'‎₦'.$substore_products_total['product_value']);
                        
            }

            //return $last_row;
            $data[] =[''];
            array_push($last_row ,'‎₦'.$days_grand_total_value);
            $data[] = $last_row;


            //summery table
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];


            $data[ ] = ['', 'Product', 'Qty sold', 'price','amount','Profit', 'Comm'];
            $product_grand_total_value =0;
            $product_grand_total_cost =0;
            $product_grand_total_profit =0;
            $product_grand_total_commission =0;
            
            foreach ($substore_products_totals as $substore_products_total) {

                $product_total_value =  $substore_products_total['product_quantity'] *  $substore_products_total['product_price'];
                $product_total_cost = $substore_products_total['product_quantity'] *  $substore_products_total['product_cost'];
                $product_total_profit = $product_total_value - $product_total_cost;
                $product_total_commission =$product_total_profit *0.5;

                $product_grand_total_value += $product_total_value;
                $product_grand_total_cost += $product_total_cost;
                $product_grand_total_profit += $product_total_profit;
                $product_grand_total_commission += $product_total_commission;


                $data[ ] = ['', $substore_products_total['product_name'], ''.$substore_products_total['product_quantity'], '‎₦'.$substore_products_total['product_price'],'‎₦'.$product_total_value,'‎₦'.$product_total_profit, '‎₦'.$product_total_commission];
               
                                        
            }
            $data[ ] = [''];
            $data[ ] = ['', ' GRAND TOTALS', '', '','‎₦'.$product_grand_total_value, '‎₦'.$product_grand_total_profit, '‎₦'.$product_grand_total_commission];
            




            $export = new ReportExport($data);
            return Excel::download($export, $substore->name.'-lubricantsales'.$start_of_month->format("M-Y").'.xlsx');


        }
        elseif( $request->isMethod("post") && $request->input('report_type')=='lubebay_service_sales'){

            //todo
            //generate and populate rows 
            $request->validate([
                'month' => 'required',
                'lubebay' => 'required',
                'year' => 'required'
            ]);
            $report_year = $request->input('year');

            $data[ ] = ['', '', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', ''];
            
            $lubebay =  Lubebay::find($request->input('lubebay'));
            $start_of_month = Carbon::create($report_year, $request->input('month') , 1)->startOfMonth();
            $end_of_month = Carbon::create($report_year, $request->input('month') , 1)->endOfMonth();

            $dateinterval = new CarbonPeriod(
                $start_of_month,
                '1 day',
                $end_of_month
            ); 
             
            //$revdate = Carbon::create(2020, 9 , 26);
           
            //return  $lubebay->productStock(59,now());
            //return  $lubebay->productStockRecieved(59,$revdate);
            $number_of_days_in_interval = $dateinterval->count();
            // $day_row =[];
            $title_row_created = false;
            $product_title_row = [""];
            $product_vilues_title_row  = [""] ;//=['QTY','REV','STOCK','PRICE','SALES','TOTAL']
            $lubebay_products_totals = [];
            $days_grand_total_value = 0;
            
            $lubebay_services = Service::all();
            foreach ($lubebay_services as $lubebay_service) {
                $lubebay_services_totals[$lubebay_service->id]['service_name'] = $lubebay_service->service_name;
                $lubebay_services_totals[$lubebay_service->id]['service_price'] = $lubebay_service->price;
                $lubebay_services_totals[$lubebay_service->id]['service_count'] = 0;
                $lubebay_services_totals[$lubebay_service->id]['service_value'] = 0;
            
            }
            //return $lubebay_services_totals;
                
            foreach ($dateinterval as $date) {
                $start_of_day = Carbon::createFromTimestamp($date->timestamp)->startOfDay() ;
                $end_of_day = Carbon::createFromTimestamp($date->timestamp)->endOfDay();
                $days_total_value  = 0;
                $day_row = [];
                $day_row[] = $date->format('d-m-Y');
                //$lubebay_services = Product::all()->whereIn('id',lubebayInventory::all()->pluck('id')->toArray());
                
                foreach ($lubebay_services as $lubebay_service) {
                    //insirt title row in firt loop
                    if(!$title_row_created){
                        array_push($product_title_row, $lubebay_service->service_name ,'','');
                        array_push($product_vilues_title_row, 'RATE','COUNT','TOTAL');
                        

                    }
                    $service_count = $lubebay->serviceCount($lubebay_service->id,$start_of_day , $end_of_day);
                    $service_sale_value = $service_count * $lubebay_service->price;
                    $days_total_value += $service_sale_value;
                    array_push($day_row,'‎₦'.$lubebay_service->price, "".$service_count ,'‎₦'.($service_count * $lubebay_service->price) );
                    
                    
                    $lubebay_services_totals[$lubebay_service->id]['service_count'] += $service_count;
                    $lubebay_services_totals[$lubebay_service->id]['service_value'] += $service_sale_value;
                }
                $days_grand_total_value += $days_total_value;

                //title row created after first iteration of product inventory 
               
                if (!$title_row_created) {
                    array_push($product_title_row,"");
                    array_push($product_vilues_title_row,"GRAND TOTAL");
                    $data[] =  $product_title_row ;
                    $data[] = $product_vilues_title_row;
    
                }
                $title_row_created = true; 
                array_push($day_row,'‎₦'.$days_total_value);  
                $data[]= $day_row;
                       
        
                
                   
    
            }

            $last_row = ["TOTAL"] ;
            //return $lubebay_services_totals;
            foreach ($lubebay_services_totals as $lubebay_services_total) {
               
                array_push($last_row ,'',"".$lubebay_services_total['service_count'],'‎₦'.$lubebay_services_total['service_value']);
                        
            }

            //return $last_row;
            $data[] =[''];
            array_push($last_row ,'‎₦'.$days_grand_total_value);
            $data[] = $last_row;


            //summery table
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];


            $data[ ] = ['', 'Service', 'Qty', 'Amount'];
            $product_grand_total_value =0;
             
            foreach ($lubebay_services_totals as $lubebay_services_total) {

                $product_total_value =  $lubebay_services_total['service_count'] *  $lubebay_services_total['service_price'];
                
                $product_grand_total_value += $product_total_value;
               

                $data[ ] = ['', $lubebay_services_total['service_name'], ''.$lubebay_services_total['service_count'], '‎₦'.$product_total_value];
               
                                        
            }
            $data[ ] = [''];
            $data[ ] = ['', ' GRAND TOTALS','', '‎₦'.$product_grand_total_value ];
            

            $export = new ReportExport($data);
            return Excel::download($export, $lubebay->name.'-service_sales'.$start_of_month->format("M-Y").'.xlsx');


        }
        
        elseif( $request->isMethod("post") && $request->input('report_type')=='customer_profile'){

            //todo
            //generate and populate rows 
            $request->validate([
                'customer' => 'required',
            ]);
            $report_year = 2021;

            $data[ ] = ['',' Customer Profile', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', ''];
            
            $customer = Customer::find($request->input('customer'));
            $data[ ] = [$customer->name, '', '', '', ''];
            $data[ ] = ['', '', ''];
            $data[ ] = ['Date', 'Credit', 'Debit', 'Balance', 'Lodged By'];
            foreach ($customer->transactions as $custmer_transaction) {
                if ($custmer_transaction->transaction_type =='CREDIT') {
                    $data[ ] = [$custmer_transaction->created_at, $custmer_transaction->amount, '', $custmer_transaction->balance, $custmer_transaction->approvedBy('l1')];
                }
                elseif ($custmer_transaction->transaction_type =='DEBIT') {
                    $data[ ] = [$custmer_transaction->created_at, '',$custmer_transaction->amount,  $custmer_transaction->balance, $custmer_transaction->approvedBy('l1')];
                }
            
            }
            //return $lubebay_services_totals;
                
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];


           

            $export = new ReportExport($data);
            return Excel::download($export, $customer->name.'-custmer_profile'.now()->format("M-Y").'.xlsx');


        }
        elseif( $request->isMethod("post") && $request->input('report_type')=='debtors_list'){

            $request->validate([
                'state' => 'required',
            ]); 

            //todo
            //generate and populate rows 
            
            $report_year = 2021;

            $data[ ] = ['',' Debtors List', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', ''];
            $total_customer_debt = 0;

            $customers = Customer::all()->where('customer_type',1)->where('balance' ,'<', 0)->where('state',$request->input('state'));
            $data[ ] = ['','', '', '', ''];
            //return $customers;
            $state = State::find($request->input('state'));

            $data[ ] = ['Cutomer Name', 'Customer Balance','State'];
            foreach ($customers as $customer) {
                 $data[ ] = [$customer->name, $customer->balance,  $state->name];
                 $total_customer_debt += $customer->balance;
               
            }
            //return $lubebay_services_totals;
                
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['TOTAL', $total_customer_debt, ];


           

            $export = new ReportExport($data);
            return Excel::download($export, 'Debtors_list'.now()->format("M-Y").'.xlsx');


        }
        elseif($request->isMethod("post") && $request->input('report_type')=="SIA")
            $request->validate([
                'state' =>'required',

            ]);
            $grand_total_stock_value = 0; 
            $product_list = Product::all();
            $data[ ] = ['', '', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', ''];

            $state_id = $request->input("state");
            
            foreach (Warehouse::where('state', $state_id)->where('type', "MAIN")->get() as $warehouse) {
                $data[ ] = [$warehouse->name, '', '', '' ,''];
                $data[ ] = ['Product Id', 'Product Name', 'Quantity', 'Price', 'Amount'];
                $store_total_stock_value = 0; 
            
                foreach (WarehouseInventory::where('warehouse_id',$warehouse->id)->get()->SortBy('product_id') as $inventry_item){
                    $store_product_name = Product::find($inventry_item->product_id)->name();
                    $store_product_quantity = $inventry_item->quantity;
                    $store_product_price = Product::find($inventry_item->product_id)->productPrice(1);
                    $store_product_id = $inventry_item->product_id;
                    $store_product_amount = $store_product_quantity*$store_product_price ;

                    $data[ ] = [$store_product_id, $store_product_name, $store_product_quantity, $store_product_price , $store_product_amount];
                    $grand_total_stock_value +=  $store_product_amount;
                    $store_total_stock_value += $store_product_amount;
                }
                $data[ ] = ['TOTAL', '', '', '', $store_total_stock_value];
                $data[ ] = ['', '', '', '', ''];
                $data[ ] = ['', '', '', '', ''];
            }

            foreach (Substore::where('state', $state_id)->get() as $substore) {
                $data[ ] = [$substore->name, '', '', '', ''];
                $data[ ] = ['Product Id', 'Product Name', 'Quantity', 'Price', 'Amount'];
                $store_total_stock_value = 0; 
            
                foreach (SubstoreInventory::where('substore_id',$substore->id)->get()->SortBy('product_id') as $inventry_item){

                    $store_product_name = Product::find($inventry_item->product_id)->name();
                    $store_product_quantity = $inventry_item->quantity;
                    $store_product_price = Product::find($inventry_item->product_id)->productPrice(1);
                    $store_product_id = $inventry_item->product_id;
                    $store_product_amount = $store_product_quantity*$store_product_price ;

                    $data[ ] = [$store_product_id, $store_product_name, $store_product_quantity, $store_product_price , $store_product_amount];
                    $grand_total_stock_value +=  $store_product_amount;
                    $store_total_stock_value += $store_product_amount;
                }
                $data[ ] = ['TOTAL', '', '', '', $store_total_stock_value];
                $data[ ] = ['', '', '', '', ''];
                $data[ ] = ['', '', '', '', ''];
            }

            
        
        
            $grand_total_cash_with_customers = 0;
            
            foreach (Customer::where('customer_type',1)->where('state',$request->input('state'))->get() as $customer ){
                if($customer->balance < 0){
                    $grand_total_cash_with_customers += $customer->balance;
                }
            
            }
        
            $grand_total_cash_with_customers = -1*$grand_total_cash_with_customers;
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['', '', '', '', ''];
            $data[ ] = ['TOTAL CASH AT HAND', '', '', '', $request->input('cash_at_hand')];
            $data[ ] = ['TOTAL CASH WITH CUSTOMERS', '', '', '', $grand_total_cash_with_customers];
            $data[ ] = ['MOFAD TOTAL STOCK VALUE', '', '', '', $grand_total_stock_value];
            $data[ ] = ['GRAND TOTAL', '', '', '', $grand_total_stock_value + $grand_total_cash_with_customers];
            $data[ ] = ['CAPITAL INVESTED', '', '', '', $request->input('cash_invested')];
            $data[ ] = ['DIFFERENCES', '', '', '',$request->input('cash_invested')- $grand_total_stock_value + $grand_total_cash_with_customers];
            $export = new ReportExport($data);
            
        
            return Excel::download($export, 'StockInventoryAnalysis'.now().'.xlsx');

            
        }
        
    }
