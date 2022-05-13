<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => ['auth']], function() {
   Route::get('/', function () {
    return view('layouts.mofad');
});
    Route::any('/add-customer', 'CustomerController@addCustomer')->middleware("permission:add_customer");
    Route::any('/customers', 'CustomerController@viewAllCustomers');
    Route::any('/customer/orders/{customer}', 'CustomerController@viewCustomerOrders');
    Route::any('/customer/transactions/{customer}', 'CustomerController@viewCustomerTransactions');
    Route::any('/customer/edit/{customer}', 'CustomerController@customerEdit');
    Route::any('/customer/edit/inst-edit/{customer}', 'CustomerController@instEdit');
    Route::any('/customer/delete/{customer}', 'CustomerController@customerDelete');
    Route::any('/customer/delete/inst-delete/{customer}', 'CustomerController@instDelete');
    Route::any('/customer/lodgment/{customer}', 'CustomerController@customerPayment');
    Route::any('customer/lodgement/confirmation', 'CustomerController@confirmCustomerLogement');
    Route::any('/approve-customer-lodgement', 'ApprovalController@customerLodgement');
    
    //todo
    //add view and controller
    Route::any('/customer/{customer_id}', 'CustomerController@viewAllCustomers');
    
    Route::any('/create-pro', 'ProController@createPro')->middleware("permission:create_pro");
    Route::any('/view-pro', 'ProController@view');
    Route::any('/pro/reverse_pro/{pro_reverser}', 'ProController@reversePro');
    Route::any('/pro/reverse_pro/delete/inst-delete/{pro_reverser}', 'ProController@instReversePro');
    Route::any('/approve-pro', 'ApprovalController@pro');
    Route::any('/pro/view-details/{pro}', 'ProController@viewProDetails');
    Route::any('/pro/store-keeper', 'ProController@proStorekeeper');
    Route::any('/pro/store-keeper/{pro}', 'ProController@proReceiveGoods');
    Route::any('/create-prf', 'PrfController@createPrf')->middleware("permission:create_prf");
    Route::any('/view-prf', 'PrfController@view');
    Route::any('/approve-prf', 'ApprovalController@prf');
    Route::any('/prf/store-keeper', 'PrfController@prfStorekeeper');
    Route::any('/prf/payment/{prf}', 'PrfController@prfPayment');
    Route::any('/prf/payment', 'PrfController@prfPaymentList');
    Route::any('/prf/invoice/{prf}', 'PrfController@prfInvoice');
    Route::any('/prf/waybill/{prf}', 'PrfController@prfWaybill');
    Route::any('/prf/payment-history/{prf}', 'PrfController@paymentHistory');

   
    Route::any('/substore/days-transactions/view', 'SubstoreController@viewTransactions');
    Route::any('lubebay/substore/days-transactions/view', 'SubstoreController@viewLubebaySubstoreTransactions');

    Route::any('/sst/view-details/{sst}', 'SubstoreController@sstDetails');
    Route::any('/substore/days-transactions/submit', 'SubstoreController@transactionsEntry');
    Route::any('/lubebay/substore/days-transactions/submit', 'SubstoreController@lubebaySubstoreTransactionsEntry');//

    Route::any('/substore/lodgement/{substore}', 'SubstoreController@substoreLodgement');
    Route::any('/substore/lodgement-history/{substore}', 'SubstoreController@substoreSalesLodgementHistory');
    Route::any('/substore/lodgement/confirmation/{substore}', 'SubstoreController@substoreLodgementHistory');
    Route::any('/substore/lodgement', 'SubstoreController@substoreLodgementStations');

    Route::any('/lubebay/substore/lodgement', 'SubstoreController@substoreLodgementLubebays');//
    Route::any('/substore/inventory/{substore}', 'SubstoreController@substoreInventory');
    Route::any('/substore/inventory', 'SubstoreController@substoreInventoryStoresList');
    Route::any('/substore/inventory/{substore}/{product}', 'SubstoreController@substoreProductBincard');
   
    Route::any('/approve-sst', 'ApprovalController@sst');
    Route::any('/approve-substore-lodgement', 'ApprovalController@substoreLodgement');
    
    Route::any('/lubebay/days-transactions/view', 'LubebayController@viewTransactions');
    Route::any('/lst/view-details/{lst}', 'LubebayController@lstDetails');
    Route::any('/lubebay/days-transactions/submit', 'LubebayController@transactionsEntry');
    Route::any('/approve-lst', 'ApprovalController@lst');
    Route::any('/approve-lubebay-lodgement', 'ApprovalController@lubebayLodgement');
    // Route::any('/lubebay/services-lodgement/{lst}', 'LubebayController@lstLodgement');
    // Route::any('/lubebay/services-lodgement-list', 'LubebayController@lstLodgementList');
    Route::any('/lubebay/lodgement/{lubebay}', 'LubebayController@lubebayLodgement');
    Route::any('/lubebay/lodgement-history/{lubebay}', 'LubebayController@lubebaySalesLodgementHistory');
    Route::any('/lubebay/lodgement/confirmation/{lubebay}', 'LubebayController@lubebayLodgementHistory');
    Route::any('/lubebay/lodgement', 'LubebayController@lubebayLodgementLubebays');
    
    Route::any('/admin/create/station-lubebay', 'SubstoreController@createSubstoreLubebay');
    Route::any('/admin/create/warehouse', 'WarehouseController@createWarehouse');
    
    Route::any('/expense/add-expense', 'ExpenseController@addExpense');
    Route::any('/expense/view-expenses', 'ExpenseController@view');
    Route::any('/approve-expense', 'ApprovalController@expense');
    Route::any('/admin/expense/create-expensetype', 'ExpenseController@createExpenseType');
    Route::any('/admin/expense/edit-expensetype/{expense_type}', 'ExpenseController@editExpenseType');
    Route::any('/admin/expense/delete-expensetype/{expense_type}', 'ExpenseController@deleteExpenseType');
    Route::any('/admin/expense/view-expensetypes', 'ExpenseController@viewExpenseTypes');
   
    Route::any('/lubebay/expense/add-expense', 'LubebayExpenseController@lubebayAddExpense');
    Route::any('/lubebay/expense/view-expenses', 'LubebayExpenseController@lubebayView');
    Route::any('/lubebay/approve-expense', 'ApprovalController@lubebayExpense');
    Route::any('/admin/lubebay/expense/create-expensetype', 'LubebayExpenseController@createExpenseType');
    Route::any('/admin/lubebay/expense/edit-expensetype/{expense_type}', 'LubebayExpenseController@editExpenseType');
    Route::any('/admin/lubebay/expense/delete-expensetype/{expense_type}', 'LubebayExpenseController@deleteExpenseType');
    Route::any('/admin/lubebay/expense/view-expensetypes', 'LubebayExpenseController@viewExpenseTypes');
   
    Route::any('/dashboard', 'DashboardController@main');
    //Route::any('/dashboard/lubebay/{lubebay}', 'DashboardController@lubebayServicecesOverview');
    Route::any('/dashboard/lubebay/{selected_lubebay}', 'DashboardController@lubebayDetails');
    Route::any('/dashboard/substore/{selected_substore}', 'DashboardController@substoreDetails');
    Route::any('/dashboard/directsales/', 'DashboardController@directSales');
    Route::any('/dashboard/warehouse/{selected_warehouse}', 'DashboardController@warehouseDetails');
    Route::any('/dashboard/state/{state}', 'DashboardController@stateSales');
    Route::any('/reports/sia/download/', 'ReportsController@stockInventoryAnalysis');
    Route::any('/reports', 'ReportsController@reports');
    Route::any('/reports/customers', 'ReportsController@customerReports')->name('reports.customers');
    Route::any('/reports/sales', 'ReportsController@salesReports')->name('reports.sales');
    
    Route::any('/reports/sia/', 'ReportsController@stockInventoryAnalysisPage');
   

    Route::any('/stations', 'SubstoreController@viewStations');
    Route::any('/stations/view', 'SubstoreController@viewStation2');
    Route::any('/stations/edit/{station}', 'SubstoreController@editStation');
    Route::any('/stations/delete/{station}', 'SubstoreController@deleteStation');
    Route::any('/station/delete/inst-delete/{station}', 'SubstoreController@instDelete');
    Route::any('/lubebay/stores', 'SubstoreController@viewLubebaysStores');
    Route::any('/lubebays', 'LubebayController@viewLubebays');
    Route::any('/lubebays/view', 'LubebayController@lubebays');
    Route::any('/lubebay/delete/{lubebay}', 'LubebayController@deleteLubebay');
    Route::any('/lubebay/delete/inst-delete/{lubebay}', 'LubebayController@instDeleteLubebay');
    Route::any('/states', 'DashboardController@viewStates');
    Route::any('/warehouses', 'DashboardController@viewWarehouses');


    Route::any('/storekeeper/issue-history', 'PrfController@storekeeperIssueHistory');
    Route::any('/storekeeper/receive-history', 'ProController@storekeeperReceiveHistory');
    
    Route::any('/dasboard/salesrep/sales-summery/', 'DashboardController@salesrepSalesReport');

    Route::any('/accounts/view-all-accounts', 'AccountsController@viewAllAccounts');
    Route::any('/accounts/view-account/{account}', 'AccountsController@viewAccountDetails');
    Route::any('/accounts/account/post-account-transaction/{account}', 'AccountsController@postCreditDedit');
    Route::any('/accounts/sage-account', 'AccountsController@sageAccountDetails');
    Route::any('/sage/unrecieved-products', 'AccountsController@sageAccount');
    


    Route::any('/reports/lubebay/income-statement-list', 'ReportsController@lubebayIncomeStatementList');
    Route::any('/reports/lubebay/income-statement/{lubebay}', 'ReportsController@lubebayIncomeStatement');
    Route::any('/reports/total-stock-value', 'ReportsController@totalStockValue');
    Route::any('/warehouse/inventory/{warehouse}', 'ReportsController@warehouseInventory');
    Route::any('/warehouse/inventory', 'ReportsController@warehouseInventoryStoresList');
    Route::any('/warehouse/inventory/{warehouse}/{product}', 'WarehouseController@productBincard');
    Route::post('/approve-warehouse-stock-transfer', 'ApprovalController@warehouseTransfer');
    Route::any('/warehouse/stock-transfer', 'WarehouseController@stockTransfer');
    Route::any('/warehouse/view-warehouse-transfer', 'WarehouseController@viewStockTransfer');
    Route::any('/warehouse/stock-transfer/store-keeper', 'WarehouseController@warehouseTransferStorekeeper');


    Route::any('/admin/users/create-user', 'UserController@createUser');
    Route::any('/admin/users/edit-user/{user}', 'UserController@editUser');
    Route::any('/admin/users/delete-user/{user}', 'UserController@deleteUser');
    Route::any('/admin/users/view-users', 'UserController@viewUsers');
    Route::any('/admin/users/edit-user-accesses/{user}', 'UserController@editUserAccesses');
    Route::any('/admin/users/assign-user-roles/{user}', 'UserController@assignUserRoles');
    Route::any('/admin/users/assign-accessible-facility/{user}', 'UserController@assignUserAccesibleEntities');

    Route::any('/admin/products/view-products', 'ProductController@viewProducts');
    Route::any('/admin/products/update-pricescheme', 'ProductController@updatePricescheme');
    Route::any('/admin/products/create-product', 'ProductController@createProduct');
    Route::any('/admin/products/edit-product/{product}', 'ProductController@editProduct');
    Route::any('/admin/products/delete-product/{product}', 'ProductController@deleteProduct');
    Route::any('/admin/prf/reversal/', 'PrfController@selecetPrfReversalCustomer');
    Route::any('/admin/prf/reversal/{prf}', 'PrfController@prfReversal');
    Route::any('/admin/sst/reversal/', 'SubstoreController@selectSstReversalSubstore');
    Route::any('/admin/sst/reversal/{sst}', 'SubstoreController@sstReversal');
    
    Route::any('/admin/inventory-adjustment/', 'StockInventoryController@InventoryAdjustmetSelectionPage');
    Route::any('/admin/substore/inventory-adjustment/{substore}/{product}/', 'StockInventoryController@substoreStockAdjustment');
    Route::any('/admin/warehouse/inventory-adjustment/{warehouse}/{product}/', 'StockInventoryController@warehouseStockAdjustment');
    
    Route::any('/admin/lubebay-services/view-services', 'ServiceController@viewLubebayServices');
    Route::any('/admin/lubebay-services/create-service', 'ServiceController@createLubebayService');
    Route::any('/admin/lubebay-services/edit-service/{service}', 'ServiceController@editLubebayService');
    Route::any('/admin/lubebay-services/delete-service/{service}', 'ServiceController@deleteLubebayService');


});


Route::any('/modifypermissions', 'PermissionsModifier@index');
// Route::group(['prefix'=>'admin','middleware'=>['auth','admin.access'] ],function(){

// 	Route::post('/add-institution', 'AddStructureController@institution');
// 	Route::get('/add-institution', 'AddStructureController@institution')php artisan permission:create-permission "edit articles";

// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
