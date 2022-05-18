<aside
class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-dark side-nav-bayscom sidenav-active-rounded">
<div class="brand-sidebar">
    <h1 class="logo-wrapper"><a class="brand-logo darken-1" href="{{ url('/home') }}"><span class="logo-text hide-on-med-and-down">BAYSCOM</span></a><a
            class="navbar-toggler" href="#"><i class="material-icons">radio_button_checked</i></a></h1>
</div>
<ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow"
    id="slide-out" data-menu="menu-navigation" data-collapsible="menu-accordion">
    @can('view_dashboard')
    @endcan
    <li class="bold"><a class="collapsible-header waves-effect waves-cyan "
            href="JavaScript:void(0)"><i class="material-icons">settings_input_svideo</i><span
                class="menu-title" data-i18n="Dashboard">Dashboard</span><span
                class="badge badge pill orange float-right mr-10">5</span></a>
        <div class="collapsible-body">
            <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                <!-- <li><a href="{{ url('/dashboard') }}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Modern">Main</span></a> </li> -->

                <li><a href="{{ url('/dashboard/directsales/') }}"><i
                            class="material-icons">radio_button_unchecked</i><span data-i18n="Analytics">Direct
                            Sales</span></a>
                </li>
                <li><a href="{{ url('/states') }}"><i class="material-icons">radio_button_unchecked</i><span
                            data-i18n="Analytics">Direct sales By state</span></a>
                    <!-- </li>
                <li><a href="{{ url('/warehouses') }}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Analytics">Direct sales by W/H</span></a>
                </li> -->
                <li><a href="{{ url('/stations') }}"><i class="material-icons">radio_button_unchecked</i><span
                            data-i18n="eCommerce">Retail Stations Sales</span></a>
                </li>
                <li><a href="{{ url('/lubebays') }}"><i class="material-icons">radio_button_unchecked</i><span
                            data-i18n="Analytics">Lubebay Sales </span></a>
                </li>



            </ul>
        </div>
    </li>

    <li class="navigation-header"><a class="navigation-header-text">Applications</a><i
            class="navigation-header-icon material-icons">more_horiz</i>
    </li>

    <!-- //PRO -->
    @can('view_pro')
        <li class="bold"><a class="collapsible-header waves-effect waves-cyan "
                href="JavaScript:void(0)"><i class="material-icons">local_shipping</i><span class="menu-title"
                    data-i18n="Menu levels">PRO</span></a>
            <div class="collapsible-body">
                <ul class="collapsible collapsible-sub" data-collapsible="accordion">

                    @can('create_pro')
                        <li><a href="{{ url('create-pro') }}"><i
                                    class="material-icons">radio_button_unchecked</i><span
                                    data-i18n="Second level">Create PRO</span></a>
                        </li>
                    @endcan

                    <li><a href="{{ url('view-pro') }}"><i class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">View/Approve PRO</span></a>
                    </li>
                </ul>
            </div>
        </li>
    @endcan

    <!-- PRF -->
    @can('view_prf')
        <li class="bold"><a class="collapsible-header waves-effect waves-cyan "
                href="JavaScript:void(0)"><i class="material-icons">fast_forward</i><span class="menu-title"
                    data-i18n="Menu levels">PRF</span></a>
            <div class="collapsible-body">
                <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                    @can('create_prf')

                        <li><a href="{{ url('create-prf') }}"><i
                                    class="material-icons">radio_button_unchecked</i><span
                                    data-i18n="Second level">Create PRF</span></a>
                        </li>
                    @endcan

                    <li><a href="{{ url('view-prf') }}"><i class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">View/Approve PRF</span></a>
                    </li>

                    <li><a href="{{ url('approved/view-prf') }}"><i class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">View Approved PRF</span></a>
                    </li>


                    @can('create_prf')
                    @endcan
                    <!-- <li><a href="{{ url('prf/payment') }}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Customer Payment</span></a>
                    </li> 
                    <li><a href="{{ url('customer/lodgement/confirmation') }}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level" class=" text-wrap" >Confirm Lodgements</span></a>
                    </li>
                    -->
                    <li><a href="{{ url('/warehouse/inventory') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">Warehouse Inventory</span></a>
                    </li>
                    <li><a href="{{ url('/dasboard/salesrep/sales-summery/') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">Sales report</span></a>
                    </li>


                </ul>
            </div>
        </li>
    @endcan


    {{-- Lodgement --}}

    <!-- PRF -->
    @can('view_prf')
        <li class="bold"><a class="collapsible-header waves-effect waves-cyan "
                href="JavaScript:void(0)"><i class="material-icons">fast_forward</i><span class="menu-title"
                    data-i18n="Menu levels">Lodgements</span></a>
            <div class="collapsible-body">
                <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                    @can('create_prf')

                        <li><a href="{{ url('customer/lodgement/confirm') }}"><i
                                    class="material-icons">radio_button_unchecked</i><span
                                    data-i18n="Second level">View/Confirm</span></a>
                        </li>

                        <li><a href="{{ url('customer/lodgement/confirmation') }}"><i
                                    class="material-icons">radio_button_unchecked</i><span
                                    data-i18n="Second level">View Lodgements</span></a>
                        </li>
                         <li><a href="{{ url('/lodgements/create') }}"><i class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">Create Lodgements</span></a>
                        </li>
                    @endcan
                    {{-- <li><a href="{{ url('customer/lodgement/confirmation') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">View Confirmed Lodgements</span></a>
                    </li> --}}


                    @can('create_prf')
                    @endcan
                    <!-- <li><a href="{{ url('/lodgements/view') }}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Customer Payment</span></a>
                    </li> 
                    <li><a href="{{ url('customer/lodgement/confirmation') }}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level" class=" text-wrap" >Confirm Lodgements</span></a>
                    </li>
                    -->



                </ul>
            </div>
        </li>
    @endcan

    <!-- Stock transfer -->
    @can('view_stock_transfer')
        <li class="bold"><a class="collapsible-header waves-effect waves-cyan "
                href="JavaScript:void(0)"><i class="material-icons">fast_forward</i><span class="menu-title"
                    data-i18n="Menu levels">Stock Transfer</span></a>
            <div class="collapsible-body">
                <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                    @can('create_stock_transfer')

                        <li><a href="{{ url('/warehouse/stock-transfer') }}"><i
                                    class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">WH
                                    Stock Transfer</span></a>
                        </li>
                    @endcan

                    @can('approve_stock_transfer_l1')

                        <li><a href="{{ url('/warehouse/view-warehouse-transfer') }}"><i
                                    class="material-icons">radio_button_unchecked</i><span
                                    data-i18n="Second level">Approve WH ST</span></a>
                        </li>
                    @endcan

                    <li><a href="{{ url('/warehouse/stock-transfer/store-keeper') }}"><i
                                class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">
                                View Stock transfers</span></a>
                    </li>




                </ul>
            </div>
        </li>
    @endcan




    <!-- Customer -->
    @can('view_customers')
        <li class="bold"><a class="collapsible-header waves-effect waves-cyan "
                href="JavaScript:void(0)"><i class="material-icons">person_outline</i><span class="menu-title"
                    data-i18n="Menu levels">Customers</span></a>
            <div class="collapsible-body">
                <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                    @can('create_customers')
                        <li><a href="{{ url('/add-customer') }}"><i
                                    class="material-icons">radio_button_unchecked</i><span
                                    data-i18n="Second level">Create New Customer</span></a>
                        </li>
                    @endcan
                    <li><a href="{{ url('/customers') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">View Customers</span></a>
                    </li>
                    @can('approve_lodgement_l1')
                        <li><a href="{{ url('customer/lodgement/confirmation') }}"><i
                                    class="material-icons">radio_button_unchecked</i><span data-i18n="Second level"
                                    class=" text-wrap">Confirm Lodgements</span></a>
                        </li>
                    @endcan

                </ul>
            </div>
        </li>
    @endcan


    <!-- Store keeper -->
    @can('storekeeper')
        <li class="bold"><a class="collapsible-header waves-effect waves-cyan "
                href="JavaScript:void(0)"><i class="material-icons">event_available</i><span
                    class="menu-title" data-i18n="Menu levels">Warehouse</span></a>
            <div class="collapsible-body">
                <ul class="collapsible collapsible-sub" data-collapsible="accordion">

                    <li><a href="{{ url('/prf/store-keeper') }}"><i
                                class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">
                                Issue Goods</span></a>
                    </li>
                    <li><a href="{{ url('/storekeeper/issue-history') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">Issued goods History </span></a>
                    </li>

                    <li><a href="{{ url('/pro/store-keeper') }}"><i
                                class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">
                                Receive goods</span></a>
                    </li>

                    <li><a href="{{ url('/storekeeper/receive-history') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">Received goods History</span></a>
                    </li>

                    <li><a href="{{ url('/warehouse/inventory') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">Inventory</span></a>
                    </li>

                </ul>
            </div>
        </li>
    @endcan

    <!-- Station Sales-->
    @can('view_substore_sales')
        {{-- <li class="bold"><a class="collapsible-header waves-effect waves-cyan "
                href="JavaScript:void(0)"><i class="material-icons">local_gas_station</i><span
                    class="menu-title" data-i18n="Menu levels">Station</span></a>
            <div class="collapsible-body">
                <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                    <li><a href="{{ url('/stations/view') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">View Stations</span></a>
                    </li>
                    @can('post_substore_sales')
                        <li><a href="{{ url('/substore/days-transactions/submit') }}"><i
                                    class="material-icons">radio_button_unchecked</i><span
                                    data-i18n="Second level">Post Sales</span></a>
                        </li>
                    @endcan
                    <li><a href="{{ url('/substore/days-transactions/view') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">View /Confirm Sales</span></a>
                    </li>
                    <li><a href="{{ url('/substore/lodgement') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">Sales Lodgements</span></a>
                    </li>
                    <li><a href="{{ url('/substore/inventory') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">Inventory</span></a>
                    </li>


                </ul>
            </div>
        </li> --}}
    @endcan

    <!-- Lube Bay Services-->
    @can('view_lubebay_sales')
        <li class="bold"><a class="collapsible-header waves-effect waves-cyan "
                href="JavaScript:void(0)"><i class="material-icons">drive_eta</i><span class="menu-title"
                    data-i18n="Menu levels">Retail Outlet</span></a>
            <div class="collapsible-body">
                <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                     <li><a href="{{ url('/lubebays/view') }}"><i
                                    class="material-icons">radio_button_unchecked</i><span
                                    data-i18n="Second level">Retail Outlet</span></a>
                        </li>
                    @can('post_lubebay_sales')
                        <li><a href="{{ url('/lubebay/days-transactions/submit') }}"><i
                                    class="material-icons">radio_button_unchecked</i><span
                                    data-i18n="Second level">Retail Outlet Services</span></a>
                        </li>
                    @endcan
                    <li><a href="{{ url('/lubebay/days-transactions/view') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">Confirm Service Sales</span></a>
                    </li>

                    <li><a href="{{ url('/lubebay/lodgement') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">Lodgement</span></a>
                    </li>
                </ul>
            </div>
        </li>
    @endcan

    <!--General Expenses-->
    @can('view_general_expenses')
        <li class="bold"><a class="collapsible-header waves-effect waves-cyan "
                href="JavaScript:void(0)"><i class="material-icons">book</i><span class="menu-title"
                    data-i18n="Menu levels">Expenses</span></a>
            <div class="collapsible-body">
                <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                    @can('add_general_expenses')
                        <li><a href="{{ url('/expense/add-expense') }}"><i
                                    class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Add
                                    Expense</span></a>
                        </li>
                    @endcan
                    <li><a href="{{ url('/expense/view-expenses') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">View /Approve Expense</span></a>
                    </li>

                </ul>
            </div>
        </li>
    @endcan

    {{-- <!-- Lubebay Expenses -->
    @can('view_lubebay_expenses')
        <li class="bold"><a class="collapsible-header waves-effect waves-cyan "
                href="JavaScript:void(0)"><i class="material-icons">book</i><span class="menu-title"
                    data-i18n="Menu levels">Lubebay Expenses</span></a>
            <div class="collapsible-body">
                <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                    @can('add_lubebay_expenses')<li><a href="{{ url('/lubebay/expense/add-expense') }}"><i
                                    class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Add
                                    Expense</span></a>
                        </li>
                    @endcan
                    <li><a href="{{ url('/lubebay/expense/view-expenses') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">View /Approve Expense</span></a>
                    </li>

                </ul>
            </div>
        </li>
    @endcan --}}

    <!-- add access cntrl -->
    <li class="bold"><a class="collapsible-header waves-effect waves-cyan "
            href="JavaScript:void(0)"><i class="material-icons">book</i><span class="menu-title"
                data-i18n="Menu levels">Reports</span></a>
        <div class="collapsible-body">
            <ul class="collapsible collapsible-sub" data-collapsible="accordion">

                <li><a href="{{ url('/reports') }}"><i class="material-icons">radio_button_unchecked</i><span
                            data-i18n="Second level">Reports</span></a>
                </li>
                <li><a href="{{ route('reports.customers') }}"><i class="material-icons">radio_button_unchecked</i><span
                            data-i18n="Second level">Customers</span></a>
                </li>
                <li><a href="{{ route('reports.sales') }}"><i class="material-icons">radio_button_unchecked</i><span
                            data-i18n="Second level">Sales</span></a>
                </li>
                <li><a href="{{ route('reports.customers') }}"><i class="material-icons">radio_button_unchecked</i><span
                            data-i18n="Second level">Products</span></a>
                </li>
                <li><a href="{{ route('reports.customers') }}"><i class="material-icons">radio_button_unchecked</i><span
                            data-i18n="Second level">Sub Stores</span></a>
                </li>
                <li><a href="{{ route('reports.customers') }}"><i class="material-icons">radio_button_unchecked</i><span
                            data-i18n="Second level">Lube Stores</span></a>
                </li>
                <!-- <li><a href="{{ url('/reports/lubebay/income-statement/') }}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Lubebay Ledger</span></a>
                </li>
                <li><a href="{{ url('/reports/lubebay/income-statement/') }}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">P & L</span></a>
                <li><a href="{{ url('/accounts/account/1') }}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Loan Repayment</span></a>
                 -->
            </ul>
        </div>
    </li>


    <!-- add access cntrl -->
    <li class="bold"><a class="collapsible-header waves-effect waves-cyan "
            href="JavaScript:void(0)"><i class="material-icons">book</i><span class="menu-title"
                data-i18n="Menu levels">Accounts</span></a>
        <div class="collapsible-body">
            <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                <li><a href="{{ url('/customers') }}"><i
                            class="material-icons">radio_button_unchecked</i><span
                            data-i18n="Second level">Customer Accounts </span></a>
                </li>
                <li><a href="{{ url('/accounts/view-all-accounts') }}"><i
                            class="material-icons">radio_button_unchecked</i><span
                            data-i18n="Second level">System Accounts</span></a>
                </li>
                <li><a href="{{ url('/accounts/sage-account') }}"><i
                            class="material-icons">radio_button_unchecked</i><span
                            data-i18n="Second level">Sage account</span></a>
                </li>

            </ul>
        </div>
    </li>

    <!-- Admin Features -->
    @can('use_admin_features')
        <li class="navigation-header"><a class="navigation-header-text">Admin Features</a><i
                class="navigation-header-icon material-icons">more_horiz</i>
        </li>
        <!-- system users -->
        <li class="bold"><a class="collapsible-header waves-effect waves-cyan "
                href="JavaScript:void(0)"><i class="material-icons">settings</i><span class="menu-title"
                    data-i18n="Menu levels">System Users</span></a>
            <div class="collapsible-body">
                <ul class="collapsible collapsible-sub" data-collapsible="accordion">

                    <li><a href="{{ url('/admin/users/create-user') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">Create Users</span></a>
                    </li>

                    <li><a href="{{ url('/admin/users/view-users') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">View User</span></a>
                    </li>



                </ul>
            </div>
        </li>

        <!-- System Products -->
        <li class="bold"><a class="collapsible-header waves-effect waves-cyan "
                href="JavaScript:void(0)"><i class="material-icons">settings</i><span class="menu-title"
                    data-i18n="Menu levels">System Products</span></a>
            <div class="collapsible-body">
                <ul class="collapsible collapsible-sub" data-collapsible="accordion">

                    <li><a href="{{ url('/admin/products/create-product') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">Create Product</span></a>
                    </li>

                    <li><a href="{{ url('/admin/products/view-products') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">View Products</span></a>
                    </li>
                    <li><a href="{{ url('/admin/products/update-pricescheme') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">Update Price scheme</span></a>
                    </li>
                    <li><a href="{{ url('/admin/inventory-adjustment') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">Inventory Adjustment</span></a>
                    </li>
                    <li><a href="{{ url('/admin/prf/reversal') }}"><i
                                class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Prf
                                Reversal</span></a>
                    </li>
                    <li><a href="{{ url('/admin/sst/reversal') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">Substore sales reversal</span></a>
                    </li>
                    <li><a href="{{ url('/warehouse/stock-transfer') }}"><i
                                class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">WH
                                Stock Transfer</span></a>
                    </li>
                    <li><a href="{{ url('/warehouse/view-warehouse-transfer') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">Approve WH ST</span></a>
                    </li>
                </ul>
            </div>
        </li>


        <!-- System Lubebay Services -->
        <li class="bold"><a class="collapsible-header waves-effect waves-cyan "
                href="JavaScript:void(0)"><i class="material-icons">settings</i><span class="menu-title"
                    data-i18n="Menu levels">Lubebay Services</span></a>
            <div class="collapsible-body">
                <ul class="collapsible collapsible-sub" data-collapsible="accordion">

                    <li><a href="{{ url('/admin/lubebay-services/create-service') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">Create Service</span></a>
                    </li>

                    <li><a href="{{ url('/admin/lubebay-services/view-services') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">View Services</span></a>
                    </li>


                </ul>
            </div>
        </li>
        <!-- add access cntrl -->
        <li class="bold"><a class="collapsible-header waves-effect waves-cyan "
                href="JavaScript:void(0)"><i class="material-icons">settings</i><span class="menu-title"
                    data-i18n="Menu levels">Expense types</span></a>
            <div class="collapsible-body">
                <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                    <li><a href="{{ url('/admin/expense/view-expensetypes') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">BAYSCOM expense type </span></a>
                    </li>
                    <li><a href="{{ url('/admin/expense/create-expensetype') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">Create M expense type</span></a>
                    </li>
                    <li><a href="{{ url('/admin/lubebay/expense/view-expensetypes') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">Lubebay expense type </span></a>
                    </li>
                    <li><a href="{{ url('/admin/lubebay/expense/create-expensetype') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">Create L expense type</span></a>
                    </li>

                </ul>
            </div>
        </li>
        <!-- System create substation Lubebay warehouses-->
        <li class="bold"><a class="collapsible-header waves-effect waves-cyan "
                href="JavaScript:void(0)"><i class="material-icons">settings</i><span class="menu-title"
                    data-i18n="Menu levels">Facilities</span></a>
            <div class="collapsible-body">
                <ul class="collapsible collapsible-sub" data-collapsible="accordion">

                    <li><a href="{{ url('/admin/create/station-lubebay') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">Create Lubebay</span></a>
                    </li>

                    <li><a href="{{ url('/admin/create/station-lubebay') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">Create Substore</span></a>
                    </li>

                    <li><a href="{{ url('/admin/create/warehouse') }}"><i
                                class="material-icons">radio_button_unchecked</i><span
                                data-i18n="Second level">Create Warehouse</span></a>
                    </li>

                    <!--                         
                    <li><a href="{{ url('/admin/create/station-lubebay') }}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Warehouse</span></a>
                    </li>

                    <li><a href="{{ url('/admin/create/station-lubebay') }}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Cerate Location</span></a>
                    </li> -->


                </ul>
            </div>
        </li>

    @endcan

    <li class="bold">
        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
        <a class="waves-effect waves-cyan " href="#"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                class="material-icons">settings_power</i><span class="menu-title"
                data-i18n="Changelog">Logout</span></a>
    </li>

    <li class="bold"><a class="waves-effect waves-cyan " href="beta.bayscomenergy.com"
            target="_blank"><i class="material-icons">help_outline</i><span class="menu-title"
                data-i18n="Support">Support</span></a>
    </li>
</ul>
<div class="navigation-background"></div><a
    class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium gradient-45deg-yellow-red darken-1 waves-effect waves-light hide-on-large-only"
    href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
</aside>
