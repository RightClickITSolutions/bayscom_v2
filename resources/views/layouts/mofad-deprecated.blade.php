<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    @section('head')
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Mofad">
    <meta name="keywords" content="MOFAD Proprietory systems">
    <meta name="author" content="Right Click">
    <title>MOFAD | {{$page_tittle ?? ''}}</title>
    <link rel="apple-touch-icon" href="{{asset('app-assets/images/favicon/apple-touch-icon-152x152.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('app-assets/images/favicon/favicon-32x32.')}}png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- JQUERY: -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    
    <!-- BEGIN: VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/vendors.min.css')}}">
    <!-- END: VENDOR CSS-->
     <!-- BEGIN: VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/sweetalert/sweetalert.css')}}">
    <!-- END: VENDOR CSS-->
    <!-- BEGIN: Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/themes/vertical-gradient-menu-template/materialize.cs')}}s">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/themes/vertical-gradient-menu-template/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/user-profile-page.css')}}">
    <!-- END: Page Level CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/custom/custom.css')}}">
    <!-- END: Custom CSS-->
    @show
</head>
<!-- END: Head-->

<body class="vertical-layout page-header-light vertical-menu-collapsible vertical-gradient-menu preload-transitions 2-columns   " data-open="click" data-menu="vertical-gradient-menu" data-col="2-columns">

    <!-- BEGIN: Header-->
    <header class="page-topbar" id="header">
        <div class="navbar navbar-fixed">
            <nav class="navbar-main navbar-color nav-collapsible sideNav-lock navbar-light">
                <div class="nav-wrapper">
                    <div class="header-search-wrapper hide-on-med-and-down"><i class="material-icons">search</i>
                        <!-- <input class="header-search-input z-depth-2" type="text" name="Search" placeholder="Explore Materialize" data-search="template-list">
                        <ul class="search-list collection display-none"></ul> -->
                    </div>
                    <ul class="navbar-list right hide">
                        <li class="dropdown-language"><a class="waves-effect waves-block waves-light translation-button" href="#" data-target="translation-dropdown"><span class="flag-icon flag-icon-gb"></span></a></li>
                        <li class="hide-on-med-and-down"><a class="waves-effect waves-block waves-light toggle-fullscreen" href="javascript:void(0);"><i class="material-icons">settings_overscan</i></a></li>
                        <li class="hide-on-large-only search-input-wrapper"><a class="waves-effect waves-block waves-light search-button" href="javascript:void(0);"><i class="material-icons">search</i></a></li>
                        <li><a class="waves-effect waves-block waves-light notification-button" href="javascript:void(0);" data-target="notifications-dropdown"><i class="material-icons">notifications_none<small class="notification-badge">5</small></i></a></li>
                        <li><a class="waves-effect waves-block waves-light profile-button" href="javascript:void(0);" data-target="profile-dropdown"><span class="avatar-status avatar-online"><img src="{{asset('app-assets/images/avatar/avatar-7.png')}}" alt="avatar"><i></i></span></a></li>
                        <li><a class="waves-effect waves-block waves-light sidenav-trigger" href="#" data-target="slide-out-right"><i class="material-icons">format_indent_increase</i></a></li>
                    </ul>
                    <!-- translation-button-->
                    <ul class="dropdown-content " id="translation-dropdown">
                        <li class="dropdown-item"><a class="grey-text text-darken-1" href="#!" data-language="en"><i class="flag-icon flag-icon-gb"></i> English</a></li>
                        <li class="dropdown-item"><a class="grey-text text-darken-1" href="#!" data-language="fr"><i class="flag-icon flag-icon-fr"></i> French</a></li>
                        <li class="dropdown-item"><a class="grey-text text-darken-1" href="#!" data-language="pt"><i class="flag-icon flag-icon-pt"></i> Portuguese</a></li>
                        <li class="dropdown-item"><a class="grey-text text-darken-1" href="#!" data-language="de"><i class="flag-icon flag-icon-de"></i> German</a></li>
                    </ul>
                    <!-- notifications-dropdown-->
                    <ul class="dropdown-content" id="notifications-dropdown">
                        <li>
                            <h6>NOTIFICATIONS<span class="new badge">5</span></h6>
                        </li>
                        <li class="divider"></li>
                        <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle cyan small">add_shopping_cart</span> A new order has been placed!</a>
                            <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">2 hours ago</time>
                        </li>
                        <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle red small">stars</span> Completed the task</a>
                            <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">3 days ago</time>
                        </li>
                        <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle teal small">settings</span> Settings updated</a>
                            <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">4 days ago</time>
                        </li>
                        <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle deep-orange small">today</span> Director meeting started</a>
                            <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">6 days ago</time>
                        </li>
                        <li><a class="black-text" href="#!"><span class="material-icons icon-bg-circle amber small">trending_up</span> Generate monthly report</a>
                            <time class="media-meta grey-text darken-2" datetime="2015-06-12T20:50:48+08:00">1 week ago</time>
                        </li>
                    </ul>
                    <!-- profile-dropdown-->
                    <ul class="dropdown-content " id="profile-dropdown">
                        <li><a class="grey-text text-darken-1" href="user-profile-page.html"><i class="material-icons">person_outline</i> Profile</a></li>
                        <li><a class="grey-text text-darken-1" href="app-chat.html"><i class="material-icons">chat_bubble_outline</i> Chat</a></li>
                        <li><a class="grey-text text-darken-1" href="page-faq.html"><i class="material-icons">help_outline</i> Help</a></li>
                        <li class="divider"></li>
                        <li><a class="grey-text text-darken-1" href="user-lock-screen.html"><i class="material-icons">lock_outline</i> Lock</a></li>
                        <li><a class="grey-text text-darken-1" href="user-login.html"><i class="material-icons">keyboard_tab</i> Logout</a></li>
                    </ul>
                </div>
                <nav class="display-none search-sm">
                    <div class="nav-wrapper">
                        <form>
                            <div class="input-field search-input-sm">
                                <input class="search-box-sm mb-0" type="search" required="" id="search" data-search="template-list">
                                <label class="label-icon" for="search"><i class="material-icons search-sm-icon">search</i></label><i class="material-icons search-sm-close">close</i>
                                <ul class="search-list collection search-list-sm display-none"></ul>
                            </div>
                        </form>
                    </div>
                </nav>
            </nav>
        </div>
    </header>
    <!-- END: Header-->
    <ul class="display-none" id="default-search-main">
        <li class="auto-suggestion-title"><a class="collection-item" href="#">
                <h6 class="search-title">FILES</h6>
            </a></li>
        <li class="auto-suggestion"><a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar"><img src="{{asset('app-assets/images/icon/pdf-image.png')}}" width="24" height="30" alt="sample image"></div>
                        <div class="member-info display-flex flex-column"><span class="black-text">Two new item submitted</span><small class="grey-text">Marketing Manager</small></div>
                    </div>
                    <div class="status"><small class="grey-text">17kb</small></div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar"><img src="{{asset('app-assets/images/icon/doc-image.png')}}" width="24" height="30" alt="sample image"></div>
                        <div class="member-info display-flex flex-column"><span class="black-text">52 Doc file Generator</span><small class="grey-text">FontEnd Developer</small></div>
                    </div>
                    <div class="status"><small class="grey-text">550kb</small></div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar"><img src="{{asset('app-assets/images/icon/xls-image.png')}}" width="24" height="30" alt="sample image"></div>
                        <div class="member-info display-flex flex-column"><span class="black-text">25 Xls File Uploaded</span><small class="grey-text">Digital Marketing Manager</small></div>
                    </div>
                    <div class="status"><small class="grey-text">20kb</small></div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar"><img src="{{asset('app-assets/images/icon/jpg-image.png')}}" width="24" height="30" alt="sample image"></div>
                        <div class="member-info display-flex flex-column"><span class="black-text">Anna Strong</span><small class="grey-text">Web Designer</small></div>
                    </div>
                    <div class="status"><small class="grey-text">37kb</small></div>
                </div>
            </a></li>
        <li class="auto-suggestion-title"><a class="collection-item" href="#">
                <h6 class="search-title">MEMBERS</h6>
            </a></li>
        <li class="auto-suggestion"><a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar"><img class="circle" src="{{asset('app-assets/images/avatar/avatar-7.png')}}" width="30" alt="sample image"></div>
                        <div class="member-info display-flex flex-column"><span class="black-text">John Doe</span><small class="grey-text">UI designer</small></div>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar"><img class="circle" src="{{asset('app-assets/images/avatar/avatar-8.png')}}" width="30" alt="sample image"></div>
                        <div class="member-info display-flex flex-column"><span class="black-text">Michal Clark</span><small class="grey-text">FontEnd Developer</small></div>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar"><img class="circle" src="{{asset('app-assets/images/avatar/avatar-10.png')}}" width="30" alt="sample image"></div>
                        <div class="member-info display-flex flex-column"><span class="black-text">Milena Gibson</span><small class="grey-text">Digital Marketing</small></div>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="collection-item" href="#">
                <div class="display-flex">
                    <div class="display-flex align-item-center flex-grow-1">
                        <div class="avatar"><img class="circle" src="{{asset('app-assets/images/avatar/avatar-12.png')}}" width="30" alt="sample image"></div>
                        <div class="member-info display-flex flex-column"><span class="black-text">Anna Strong</span><small class="grey-text">Web Designer</small></div>
                    </div>
                </div>
            </a></li>
    </ul>
    <ul class="display-none" id="page-search-title">
        <li class="auto-suggestion-title"><a class="collection-item" href="#">
                <h6 class="search-title">PAGES</h6>
            </a></li>
    </ul>
    <ul class="display-none" id="search-not-found">
        <li class="auto-suggestion"><a class="collection-item display-flex align-items-center" href="#"><span class="material-icons">error_outline</span><span class="member-info">No results found.</span></a></li>
    </ul>



    <!-- BEGIN: SideNav-->
    @section('side_nav')
    <aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-dark gradient-45deg-yellow-red sidenav-gradient sidenav-active-rounded">
        <div class="brand-sidebar">
            <h1 class="logo-wrapper"><a class="brand-logo darken-1" href="{{url('/home')}}"><img class="hide-on-med-and-down " src="{{asset('app-assets/images/logo/materialize-logo.p')}}ng" alt="materialize logo" /><img class="show-on-medium-and-down hide-on-med-and-up" src="{{asset('app-assets/images/logo/materialize-logo-color.png')}}" alt="materialize logo" /><span class="logo-text hide-on-med-and-down">OFAD</span></a><a class="navbar-toggler" href="#"><i class="material-icons">radio_button_checked</i></a></h1>
        </div>
        <ul class="sidenav sidenav-collapsible leftside-navigation collapsible gradient-45deg-yellow-red sidenav-fixed menu-shadow" id="slide-out" data-menu="menu-navigation" data-collapsible="menu-accordion">
            @can('view_dashboard')
            @endcan
            <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i class="material-icons">settings_input_svideo</i><span class="menu-title" data-i18n="Dashboard">Dashboard</span><span class="badge badge pill orange float-right mr-10">5</span></a>
                <div class="collapsible-body">
                    <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                         <!-- <li><a href="{{url('/dashboard')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Modern">Main</span></a> </li> -->

                        <li><a href="{{url('/dashboard/directsales/')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Analytics">Direct Sales</span></a>
                        </li>
                        <li><a href="{{url('/states')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Analytics">Direct sales By state</span></a>
                        <!-- </li>
                        <li><a href="{{url('/warehouses')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Analytics">Direct sales by W/H</span></a>
                        </li> -->
                        <li><a href="{{url('/stations')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="eCommerce">Retail Stations Sales</span></a>
                        </li>
                        <li><a href="{{url('/lubebays')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Analytics">Lubebay Sales </span></a>
                        </li>
                        
                        
                        
                    </ul>
                </div>
            </li>
           
            <li class="navigation-header"><a class="navigation-header-text">Applications</a><i class="navigation-header-icon material-icons">more_horiz</i>
            </li>

            <!-- //PRO -->
            @can('view_pro')
            <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i class="material-icons">local_shipping</i><span class="menu-title" data-i18n="Menu levels">PRO</span></a>
                <div class="collapsible-body">
                    <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                        
                        @can('create_pro')
                        <li><a href="{{url('create-pro')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Create PRO</span></a>
                        </li>
                        @endcan
                       
                         <li><a href="{{url('view-pro')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">View/Approve PRO</span></a>
                        </li>
                    </ul>
                </div>
            </li>
            @endcan

            <!-- PRF -->
            @can('view_prf')
            <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i class="material-icons">fast_forward</i><span class="menu-title" data-i18n="Menu levels">PRF</span></a>
                <div class="collapsible-body">
                    <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                        @can('create_prf')
                        
                        <li><a href="{{url('create-prf')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Create PRF</span></a>
                        </li>
                        @endcan

                        <li><a href="{{url('view-prf')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">View/Approve PRF</span></a>
                        </li>

                        
                        @can('create_prf')
                        @endcan
                        <!-- <li><a href="{{url('prf/payment')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Customer Payment</span></a>
                        </li> 
                        <li><a href="{{url('customer/lodgement/confirmation')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level" class=" text-wrap" >Confirm Lodgements</span></a>
                        </li>
                        -->
                        <li><a href="{{ url('/warehouse/inventory')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Warehouse Inventory</span></a>
                        </li>
                        <li><a href="{{url('/dasboard/salesrep/sales-summery/')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Sales report</span></a>
                        </li>
                        
                        
                    </ul>
                </div>
            </li>
            @endcan

            <!-- Stock transfer -->
            @can('view_stock_transfer')
            <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i class="material-icons">fast_forward</i><span class="menu-title" data-i18n="Menu levels">Stock Transfer</span></a>
                <div class="collapsible-body">
                    <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                        @can('create_stock_transfer')
                        
                        <li><a href="{{ url('/warehouse/stock-transfer')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">WH Stock Transfer</span></a>
                        </li>
                        @endcan
                        
                        @can('approve_stock_transfer_l1')
                          
                        <li><a href="{{ url('/warehouse/view-warehouse-transfer')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Approve WH ST</span></a>
                        </li>
                        @endcan

                        <li><a href="{{url('/warehouse/stock-transfer/store-keeper')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level"> View Stock transfers</span></a>
                        </li>

                        
                       
                        
                    </ul>
                </div>
            </li>
            @endcan
           

                      

            <!-- Customer -->
             @can('view_customers')
             <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i class="material-icons">person_outline</i><span class="menu-title" data-i18n="Menu levels">Customers</span></a>
                <div class="collapsible-body">
                    <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                        @can('create_customers')
                        <li><a href="{{ url('/add-customer')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Create New Customer</span></a>
                        </li>
                        @endcan
                        <li><a href="{{ url('/customers')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">View Customers</span></a>
                        </li>
                        @can('approve_lodgement_l1')
                        <li><a href="{{url('customer/lodgement/confirmation')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level" class=" text-wrap">Confirm Lodgements</span></a>
                        </li>
                        @endcan
                        
                    </ul>
                </div>
            </li>
            @endcan


            <!-- Store keeper -->
            @can('storekeeper')
            <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i class="material-icons">event_available</i><span class="menu-title" data-i18n="Menu levels">Store keeper</span></a>
                <div class="collapsible-body">
                    <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                        
                        <li><a href="{{url('/prf/store-keeper')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level"> Issue Goods</span></a>
                        </li>
                        <li><a href="{{url('/storekeeper/issue-history')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Issued goods History </span></a>
                        </li>

                        <li><a href="{{url('/pro/store-keeper')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level"> Receive goods</span></a>
                        </li>
                        
                        <li><a href="{{url('/storekeeper/receive-history')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Received goods History</span></a>
                        </li>

                        <li><a href="{{ url('/warehouse/inventory')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Inventory</span></a>
                        </li>
                        
                    </ul>
                </div>
            </li>
            @endcan

            <!-- Station Sales-->
            @can('view_substore_sales')
            <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i class="material-icons">local_gas_station</i><span class="menu-title" data-i18n="Menu levels">Station</span></a>
                <div class="collapsible-body">
                    <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                        @can('post_substore_sales')
                        <li><a href="{{ url('/substore/days-transactions/submit')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Post Sales</span></a>
                        </li>
                        @endcan
                        <li><a href="{{ url('/substore/days-transactions/view')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">View /Confirm Sales</span></a>
                        </li>
                        <li><a href="{{ url('/substore/lodgement')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Sales Lodgements</span></a>
                        </li>
                        <li><a href="{{ url('/substore/inventory')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Inventory</span></a>
                        </li>
                        
                        
                    </ul>
                </div>
            </li>
            @endcan

             <!-- Lube Bay Services-->
             @can('view_lubebay_sales')
             <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i class="material-icons">drive_eta</i><span class="menu-title" data-i18n="Menu levels">Lube Bay</span></a>
                <div class="collapsible-body">
                    <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                        @can('post_lubebay_sales')
                        <li><a href="{{ url('/lubebay/days-transactions/submit')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Lubebay Services</span></a>
                        </li>
                        @endcan
                        <li><a href="{{ url('/lubebay/days-transactions/view')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Confirm Service Sales</span></a>
                        </li>
                        
                        <li><a href="{{ url('/lubebay/lodgement')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Lodgement</span></a>
                        </li>
                        <hr>
                        @can('post_lubebay_sales')
                        <li><a href="{{ url('/lubebay/substore/days-transactions/submit')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Lubricant Sales</span></a>
                        </li>
                        
                        @endcan
                        <li><a href="{{ url('/lubebay/substore/days-transactions/view')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level" class=" text-wrap">Confirm Lubricant Sale</span></a>
                        </li>
                        
                        <li><a href="{{ url('/lubebay/substore/lodgement')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Lubricant Lodgements</span></a>
                        </li>
                        <li><a href="{{ url('/substore/inventory')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Inventory</span></a>
                        </li>
                    </ul>
                </div>
            </li>
            @endcan

            <!--General Expenses-->
            @can('view_general_expenses')
            <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i class="material-icons">book</i><span class="menu-title" data-i18n="Menu levels">Mofad Main Expenses</span></a>
                <div class="collapsible-body">
                    <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                        @can('add_general_expenses')
                        <li><a href="{{ url('/expense/add-expense')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Add Expense</span></a>
                        </li>
                        @endcan
                        <li><a href="{{ url('/expense/view-expenses')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">View /Approve Expense</span></a>
                        </li>
                        
                    </ul>
                </div>
            </li>
            @endcan

            <!-- Lubebay Expenses -->
            @can('view_lubebay_expenses')
            <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i class="material-icons">book</i><span class="menu-title" data-i18n="Menu levels">Lubebay Expenses</span></a>
                <div class="collapsible-body">
                    <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                        @can('add_lubebay_expenses')<li><a href="{{ url('/lubebay/expense/add-expense')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Add Expense</span></a>
                        </li>
                        @endcan
                        <li><a href="{{ url('/lubebay/expense/view-expenses')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">View /Approve Expense</span></a>
                        </li>
                        
                    </ul>
                </div>
            </li>
            @endcan
            
            <!-- add access cntrl -->
            <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i class="material-icons">book</i><span class="menu-title" data-i18n="Menu levels">Reports</span></a>
                <div class="collapsible-body">
                    <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                    
                        <li><a href="{{ url('/reports')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Reports</span></a>
                        </li>
                        <!-- <li><a href="{{ url('/reports/lubebay/income-statement/')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Lubebay Ledger</span></a>
                        </li>
                        <li><a href="{{ url('/reports/lubebay/income-statement/')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">P & L</span></a>
                        <li><a href="{{ url('/accounts/account/1')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Loan Repayment</span></a>
                         -->
                    </ul>
                </div>
            </li>

            
            <!-- add access cntrl -->
            <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i class="material-icons">book</i><span class="menu-title" data-i18n="Menu levels">Accounts</span></a>
                <div class="collapsible-body">
                    <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                    <li><a href="{{ url('/customers')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Customer Accounts </span></a>
                        </li>
                        <li><a href="{{ url('/accounts/view-all-accounts')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">System Accounts</span></a>
                        </li>
                        <li><a href="{{ url('/accounts/sage-account')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Sage account</span></a>
                        </li>
                        
                    </ul>
                </div>
            </li>

            <!-- Admin Features -->
            @can('use_admin_features')
            <li class="navigation-header"><a class="navigation-header-text">Admin Features</a><i class="navigation-header-icon material-icons">more_horiz</i>
            </li>
            <!-- system users -->
            <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i class="material-icons">settings</i><span class="menu-title" data-i18n="Menu levels">System Users</span></a>
                <div class="collapsible-body">
                    <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                      
                        <li><a href="{{ url('/admin/users/create-user')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Create Users</span></a>
                        </li>
                        
                        <li><a href="{{ url('/admin/users/view-users')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">View User</span></a>
                        </li>

                       
                        
                    </ul>
                </div>
            </li>

            <!-- System Products -->
            <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i class="material-icons">settings</i><span class="menu-title" data-i18n="Menu levels">System Products</span></a>
                <div class="collapsible-body">
                    <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                        
                        <li><a href="{{ url('/admin/products/create-product')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Create Product</span></a>
                        </li>
                        
                        <li><a href="{{ url('/admin/products/view-products')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">View Products</span></a>
                        </li>
                        <li><a href="{{ url('/admin/products/update-pricescheme')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Update Price scheme</span></a>
                        </li>
                        <li><a href="{{ url('/admin/inventory-adjustment')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Inventory Adjustment</span></a>
                        </li>
                        <li><a href="{{ url('/admin/prf/reversal')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Prf Reversal</span></a>
                        </li>
                        <li><a href="{{ url('/admin/sst/reversal')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Substore sales reversal</span></a>
                        </li>
                        <li><a href="{{ url('/warehouse/stock-transfer')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">WH Stock Transfer</span></a>
                        </li>
                        <li><a href="{{ url('/warehouse/view-warehouse-transfer')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Approve WH ST</span></a>
                        </li>
                    </ul>
                </div>
            </li>

            
            <!-- System Lubebay Services -->
            <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i class="material-icons">settings</i><span class="menu-title" data-i18n="Menu levels">Lubebay Services</span></a>
                <div class="collapsible-body">
                    <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                      
                        <li><a href="{{ url('/admin/lubebay-services/create-service')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Create  Service</span></a>
                        </li>
                        
                        <li><a href="{{ url('/admin/lubebay-services/view-services')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">View Services</span></a>
                        </li>

                        
                    </ul>
                </div>
            </li>
            <!-- add access cntrl -->
            <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i class="material-icons">settings</i><span class="menu-title" data-i18n="Menu levels">Expense types</span></a>
                <div class="collapsible-body">
                    <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                        <li><a href="{{ url('/admin/expense/view-expensetypes')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">MOFAD expense type </span></a>
                        </li>
                        <li><a href="{{ url('/admin/expense/create-expensetype')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Create M expense type</span></a>
                        </li>
                        <li><a href="{{ url('/admin/lubebay/expense/view-expensetypes')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Lubebay expense type </span></a>
                        </li>
                        <li><a href="{{ url('/admin/lubebay/expense/create-expensetype')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Create L expense type</span></a>
                        </li>
                        
                    </ul>
                </div>
            </li>
            <!-- System create substation Lubebay warehouses-->
            <li class="bold"><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)"><i class="material-icons">settings</i><span class="menu-title" data-i18n="Menu levels">Facilities</span></a>
                <div class="collapsible-body">
                    <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                      
                        <li><a href="{{ url('/admin/create/station-lubebay')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Create Lubebay</span></a>
                        </li>
                        
                        <li><a href="{{ url('/admin/create/station-lubebay')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Create Substore</span></a>
                        </li>

                        <li><a href="{{ url('/admin/create/warehouse')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Create Warehouse</span></a>
                        </li>

<!--                         
                        <li><a href="{{ url('/admin/create/station-lubebay')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Warehouse</span></a>
                        </li>

                        <li><a href="{{ url('/admin/create/station-lubebay')}}"><i class="material-icons">radio_button_unchecked</i><span data-i18n="Second level">Cerate Location</span></a>
                        </li> -->

                        
                    </ul>
                </div>
            </li>

            @endcan

            <li class="bold">
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
            <a class="waves-effect waves-cyan " href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="material-icons">settings_power</i><span class="menu-title" data-i18n="Changelog">Logout</span></a>
            </li>
            
            <li class="bold"><a class="waves-effect waves-cyan " href="beta.bayscomenergy.com" target="_blank"><i class="material-icons">help_outline</i><span class="menu-title" data-i18n="Support">Support</span></a>
            </li>
        </ul>
        <div class="navigation-background"></div><a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium gradient-45deg-yellow-red darken-1 waves-effect waves-light hide-on-large-only" href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
    </aside>
    @show
    <!-- END: SideNav-->

    <!-- BEGIN: Page Main-->
    <div id="main">
        <div class="row">
            <div class="pt-3 pb-1 breadcrumbs-bg-image" id="breadcrumbs-wrapper"  data-image="/app-assets/images/gallery/breadcrumb-bg2.jpg" style="background-image: url(/app-assets/images/gallery/breadcrumb-bg2.jpg);">
                <!-- Search for small screen-->
                <div class="container">
                    <div class="row">
                        <div class="col s12 m6 l6">
                            <h5 class="breadcrumbs-title mt-0 mb-0"><span>{{$page_tittle ?? "MOFAD"}}</span></h5>
                        </div>
                        <div class="col s12 m6 l6 right-align-md">
                            <ol class="breadcrumbs mb-0">
                                <li class="breadcrumb-item"><a href="index.html">{{$page_subtittle ?? ""}}</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            @section('content')
            <div class="col s12">
                <div class="container">
                    <div class="section">
                        <div class="row user-profile mt-1 ml-0 mr-0">
                            <img class="responsive-img" alt="" src="{{asset('app-assets/images/gallery/profile-bg.png')}}">
                        </div>
                        <div class="section" id="user-profile">
                            <div class="row">
                                <!-- User Profile Feed -->
                                <!-- <div class="col s12 m4 l3 user-section-negative-margin">
                                    <div class="row">
                                        <div class="col s12 center-align">
                                            <img class="responsive-img circle z-depth-5" width="200" src="{{asset('app-assets/images/user/12.jpg')}}" alt="">
                                            <br>
                                            <a class="waves-effect waves-light btn mt-5 border-radius-4"> Follow</a>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col s6">
                                            <h6>Follower</h6>
                                            <h5 class="m-0"><a href="#">540</a></h5>
                                        </div>
                                        <div class="col s6">
                                            <h6>Following</h6>
                                            <h5 class="m-0"><a href="#">128</a></h5>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col s12">
                                            <p class="m-0">Performance</p>
                                            <p class="m-0"><a href="#">56</a> and <a href="#">42</a> reviews</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row user-projects">
                                        <h6 class="col s12">Projects</h6>
                                        <div class="col s4">
                                            <img class="responsive-img photo-border mt-10" alt="" src="{{asset('app-assets/images/gallery/35.png')}}">
                                        </div>
                                        <div class="col s4">
                                            <img class="responsive-img photo-border mt-10" alt="" src="{{asset('app-assets/images/gallery/36.png')}}">
                                        </div>
                                        <div class="col s4">
                                            <img class="responsive-img photo-border mt-10" alt="" src="{{asset('app-assets/images/gallery/37.png')}}">
                                        </div>
                                        <div class="col s4">
                                            <img class="responsive-img photo-border mt-10" alt="" src="{{asset('app-assets/images/gallery/38.png')}}">
                                        </div>
                                        <div class="col s4">
                                            <img class="responsive-img photo-border mt-10" alt="" src="{{asset('app-assets/images/gallery/39.png')}}">
                                        </div>
                                        <div class="col s4">
                                            <img class="responsive-img photo-border mt-10" alt="" src="{{asset('app-assets/images/gallery/40.png')}}">
                                        </div>
                                        <div class="col s4">
                                            <img class="responsive-img photo-border mt-10" alt="" src="{{asset('app-assets/images/gallery/41.png')}}">
                                        </div>
                                        <div class="col s4">
                                            <img class="responsive-img photo-border mt-10" alt="" src="{{asset('app-assets/images/gallery/42.png')}}">
                                        </div>
                                        <div class="col s4">
                                            <img class="responsive-img photo-border mt-10" alt="" src="{{asset('app-assets/images/gallery/43.png')}}">
                                        </div>
                                    </div>
                                    <hr class="mt-5">
                                    <div class="row">
                                        <div class="col s12">
                                            <h6>Boosts</h6>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col s2 mt-2 pr-0 circle">
                                            <a href="#"><img class="responsive-img circle" src="{{asset('app-assets/images/user/1.jpg')}}" alt=""></a>
                                        </div>
                                        <div class="col s9">
                                            <a href="#">
                                                <p class="m-0">Micheal S. Castilleja</p>
                                            </a>
                                            <p class="m-0 amber-text"><span class="material-icons star-width">star_rate</span> <span class="material-icons star-width">star_rate</span>
                                                <span class="material-icons star-width">star_rate</span> <span class="material-icons star-width">star_rate</span>
                                                <span class="material-icons star-width">star_rate</span></p>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col s2 mt-2 pr-0 circle">
                                            <a href="#"><img class="responsive-img circle" src="{{asset('app-assets/images/user/11.jpg')}}" alt=""></a>
                                        </div>
                                        <div class="col s9">
                                            <a href="#">
                                                <p class="m-0">Thomas A. Carranza</p>
                                            </a>
                                            <p class="m-0 amber-text"><span class="material-icons star-width">star_rate</span> <span class="material-icons star-width">star_rate</span>
                                                <span class="material-icons star-width">star_rate</span> <span class="material-icons star-width">star_rate</span>
                                                <span class="material-icons star-width">star_rate</span></p>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col s2 mt-2 pr-0 circle">
                                            <a href="#"><img class="responsive-img circle" src="{{asset('app-assets/images/user/5.jpg')}}" alt=""></a>
                                        </div>
                                        <div class="col s9">
                                            <a href="#">
                                                <p class="m-0">Micheal Bryant</p>
                                            </a>
                                            <p class="m-0 amber-text"><span class="material-icons star-width">star_rate</span> <span class="material-icons star-width">star_rate</span>
                                                <span class="material-icons star-width">star_rate</span> <span class="material-icons star-width">star_rate</span>
                                                <span class="material-icons star-width">star_rate</span></p>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col s2 mt-2 pr-0 circle pb-2">
                                            <a href="#"><img class="responsive-img circle" src="{{asset('app-assets/images/user/8.jpg')}}" alt=""></a>
                                        </div>
                                        <div class="col s9">
                                            <a href="#">
                                                <p class="m-0">Wiley J. Bryant</p>
                                            </a>
                                            <p class="m-0 amber-text"><span class="material-icons star-width">star_rate</span> <span class="material-icons star-width">star_rate</span>
                                                <span class="material-icons star-width">star_rate</span> <span class="material-icons star-width">star_rate</span>
                                                <span class="material-icons star-width">star_rate</span></p>
                                        </div>
                                    </div>
                                </div> -->
                                <!-- User Post Feed -->
                                <div class="col s12 m12 l12">
                                    <div class="row">
                                        <div class="card user-card-negative-margin z-depth-0" id="feed">
                                            <div class="card-content card-border-gray">
                                                <div class="row">
                                                    <div class="col s12">
                                                        <h5>{{Auth::user()->name ?? ''}}</h5>
                                                        <p><span class="amber-text"><span class="material-icons star-width vertical-align-middle">star_rate</span>
                                                                <span class="material-icons star-width vertical-align-middle">star_rate</span> <span class="material-icons star-width vertical-align-middle">star_rate</span>
                                                                <span class="material-icons star-width vertical-align-middle">star_rate</span> <span class="material-icons star-width vertical-align-middle">star_rate</span></span></p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col s12">
                                                        <ul class="tabs card-border-gray mt-4">
                                                            <li class="tab col m3 s6 p-0"><a class="active" href="#test1">
                                                                    <i class="material-icons vertical-align-middle">crop_portrait</i> Info
                                                                </a></li>
                                                            
                                                        </ul>
                                                    </div>
                                                </div>
                                               
                                                <hr class="mt-5">
                                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Today Highlight -->
                                <!-- <div class="col s12 m12 l3 hide-on-med-and-down">
                                    <div class="row mt-5">
                                        <div class="col s12">
                                            <h6>Today Highlight</h6>
                                            <img class="responsive-img card-border z-depth-2 mt-2" src="{{asset('app-assets/images/gallery/post-3.png')}}" alt="">
                                            <p><a href="#">Meeting with clients</a></p>
                                            <p>Crediting isn’t required, but is appreciated and allows photographers to gain exposure. Copy the text
                                                below or embed a credit badge</p>
                                        </div>
                                    </div>
                                    <hr class="mt-5">
                                    <div class="row">
                                        <div class="col s12">
                                            <h6>Who to follow</h6>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col s2 mt-2 pr-0 circle">
                                            <a href="#"><img class="responsive-img circle" src="{{asset('app-assets/images/user/2.jpg')}}" alt=""></a>
                                        </div>
                                        <div class="col s9">
                                            <a href="#">
                                                <p class="m-0">Frank Goodman</p>
                                            </a>
                                            <p class="m-0 grey-text lighten-3">Senior architect</p>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col s2 mt-2 pr-0 circle">
                                            <a href="#"><img class="responsive-img circle" src="{{asset('app-assets/images/user/7.jpg')}}" alt=""></a>
                                        </div>
                                        <div class="col s9">
                                            <a href="#">
                                                <p class="m-0">Luiza Ales</p>
                                            </a>
                                            <p class="m-0 grey-text lighten-3">Senior Developer</p>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col s2 mt-2 pr-0 circle">
                                            <a href="#"><img class="responsive-img circle" src="{{asset('app-assets/images/user/4.jpg')}}" alt=""></a>
                                        </div>
                                        <div class="col s9">
                                            <a href="#">
                                                <p class="m-0">Robbin Drummo</p>
                                            </a>
                                            <p class="m-0 grey-text lighten-3">Graphic Designer</p>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col s2 mt-2 pr-0 circle">
                                            <a href="#"><img class="responsive-img circle" src="{{asset('app-assets/images/user/8.jpg')}}" alt=""></a>
                                        </div>
                                        <div class="col s9">
                                            <a href="#">
                                                <p class="m-0">Myles Steven</p>
                                            </a>
                                            <p class="m-0 grey-text lighten-3">Senior Developer</p>
                                        </div>
                                    </div>
                                    <hr class="mt-5">
                                    <div class="row">
                                        <div class="col s12">
                                            <h6>Latest Updates</h6>
                                            <p class="latest-update">Make Metronic<span class="right"> <a href="#">+480</a> </span></p>
                                            <p class="latest-update">Programming Language <span class="right"> <a href="#">+12</a> </span></p>
                                            <p class="latest-update">Project completed <span class="right"> <a href="#">+570</a> </span></p>
                                            <p class="latest-update">New Customer <span class="right"><a href="#">+120</a> </span></p>
                                            <p class="latest-update">Annual Companies<span class="right"> <a href="#">+890</a> </span></p>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div><!-- START RIGHT SIDEBAR NAV -->
                    <aside id="right-sidebar-nav">
                        <div id="slide-out-right" class="slide-out-right-sidenav sidenav rightside-navigation">
                            <div class="row">
                                <div class="slide-out-right-title">
                                    <div class="col s12 border-bottom-1 pb-0 pt-1">
                                        <div class="row">
                                            <div class="col s2 pr-0 center">
                                                <i class="material-icons vertical-text-middle"><a href="#" class="sidenav-close">clear</a></i>
                                            </div>
                                            <div class="col s10 pl-0">
                                                <ul class="tabs">
                                                    <li class="tab col s4 p-0">
                                                        <a href="#messages" class="active">
                                                            <span>Messages</span>
                                                        </a>
                                                    </li>
                                                    <li class="tab col s4 p-0">
                                                        <a href="#settings">
                                                            <span>Settings</span>
                                                        </a>
                                                    </li>
                                                    <li class="tab col s4 p-0">
                                                        <a href="#activity">
                                                            <span>Activity</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="slide-out-right-body">
                                    <div id="messages" class="col s12">
                                        <div class="collection border-none">
                                            <input class="header-search-input mt-4 mb-2" type="text" name="Search" placeholder="Search Messages" />
                                            <ul class="collection right-sidebar-chat p-0">
                                                <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0" data-target="slide-out-chat">
                                                    <span class="avatar-status avatar-online avatar-50"><img src="{{asset('app-assets/images/avatar/avatar-7.png')}}" alt="avatar" />
                                                        <i></i>
                                                    </span>
                                                    <div class="user-content">
                                                        <h6 class="line-height-0">Elizabeth Elliott</h6>
                                                        <p class="medium-small blue-grey-text text-lighten-3 pt-3">Thank you</p>
                                                    </div>
                                                    <span class="secondary-content medium-small">5.00 AM</span>
                                                </li>
                                                <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0" data-target="slide-out-chat">
                                                    <span class="avatar-status avatar-online avatar-50"><img src="{{asset('app-assets/images/avatar/avatar-1.png')}}" alt="avatar" />
                                                        <i></i>
                                                    </span>
                                                    <div class="user-content">
                                                        <h6 class="line-height-0">Mary Adams</h6>
                                                        <p class="medium-small blue-grey-text text-lighten-3 pt-3">Hello Boo</p>
                                                    </div>
                                                    <span class="secondary-content medium-small">4.14 AM</span>
                                                </li>
                                                <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0" data-target="slide-out-chat">
                                                    <span class="avatar-status avatar-off avatar-50"><img src="{{asset('app-assets/images/avatar/avatar-2.png')}}" alt="avatar" />
                                                        <i></i>
                                                    </span>
                                                    <div class="user-content">
                                                        <h6 class="line-height-0">Caleb Richards</h6>
                                                        <p class="medium-small blue-grey-text text-lighten-3 pt-3">Hello Boo</p>
                                                    </div>
                                                    <span class="secondary-content medium-small">4.14 AM</span>
                                                </li>
                                                <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0" data-target="slide-out-chat">
                                                    <span class="avatar-status avatar-online avatar-50"><img src="{{asset('app-assets/images/avatar/avatar-3.png')}}" alt="avatar" />
                                                        <i></i>
                                                    </span>
                                                    <div class="user-content">
                                                        <h6 class="line-height-0">Caleb Richards</h6>
                                                        <p class="medium-small blue-grey-text text-lighten-3 pt-3">Keny !</p>
                                                    </div>
                                                    <span class="secondary-content medium-small">9.00 PM</span>
                                                </li>
                                                <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0" data-target="slide-out-chat">
                                                    <span class="avatar-status avatar-online avatar-50"><img src="{{asset('app-assets/images/avatar/avatar-4.png')}}" alt="avatar" />
                                                        <i></i>
                                                    </span>
                                                    <div class="user-content">
                                                        <h6 class="line-height-0">June Lane</h6>
                                                        <p class="medium-small blue-grey-text text-lighten-3 pt-3">Ohh God</p>
                                                    </div>
                                                    <span class="secondary-content medium-small">4.14 AM</span>
                                                </li>
                                                <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0" data-target="slide-out-chat">
                                                    <span class="avatar-status avatar-off avatar-50"><img src="{{asset('app-assets/images/avatar/avatar-5.png')}}" alt="avatar" />
                                                        <i></i>
                                                    </span>
                                                    <div class="user-content">
                                                        <h6 class="line-height-0">Edward Fletcher</h6>
                                                        <p class="medium-small blue-grey-text text-lighten-3 pt-3">Love you</p>
                                                    </div>
                                                    <span class="secondary-content medium-small">5.15 PM</span>
                                                </li>
                                                <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0" data-target="slide-out-chat">
                                                    <span class="avatar-status avatar-online avatar-50"><img src="{{asset('app-assets/images/avatar/avatar-6.png')}}" alt="avatar" />
                                                        <i></i>
                                                    </span>
                                                    <div class="user-content">
                                                        <h6 class="line-height-0">Crystal Bates</h6>
                                                        <p class="medium-small blue-grey-text text-lighten-3 pt-3">Can we</p>
                                                    </div>
                                                    <span class="secondary-content medium-small">8.00 AM</span>
                                                </li>
                                                <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0" data-target="slide-out-chat">
                                                    <span class="avatar-status avatar-off avatar-50"><img src="{{asset('app-assets/images/avatar/avatar-7.png')}}" alt="avatar" />
                                                        <i></i>
                                                    </span>
                                                    <div class="user-content">
                                                        <h6 class="line-height-0">Nathan Watts</h6>
                                                        <p class="medium-small blue-grey-text text-lighten-3 pt-3">Great!</p>
                                                    </div>
                                                    <span class="secondary-content medium-small">9.53 PM</span>
                                                </li>
                                                <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0" data-target="slide-out-chat">
                                                    <span class="avatar-status avatar-off avatar-50"><img src="{{asset('app-assets/images/avatar/avatar-8.png')}}" alt="avatar" />
                                                        <i></i>
                                                    </span>
                                                    <div class="user-content">
                                                        <h6 class="line-height-0">Willard Wood</h6>
                                                        <p class="medium-small blue-grey-text text-lighten-3 pt-3">Do it</p>
                                                    </div>
                                                    <span class="secondary-content medium-small">4.20 AM</span>
                                                </li>
                                                <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0" data-target="slide-out-chat">
                                                    <span class="avatar-status avatar-online avatar-50"><img src="{{asset('app-assets/images/avatar/avatar-1.png')}}" alt="avatar" />
                                                        <i></i>
                                                    </span>
                                                    <div class="user-content">
                                                        <h6 class="line-height-0">Ronnie Ellis</h6>
                                                        <p class="medium-small blue-grey-text text-lighten-3 pt-3">Got that</p>
                                                    </div>
                                                    <span class="secondary-content medium-small">5.20 AM</span>
                                                </li>
                                                <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0" data-target="slide-out-chat">
                                                    <span class="avatar-status avatar-online avatar-50"><img src="{{asset('app-assets/images/avatar/avatar-9.png')}}" alt="avatar" />
                                                        <i></i>
                                                    </span>
                                                    <div class="user-content">
                                                        <h6 class="line-height-0">Daniel Russell</h6>
                                                        <p class="medium-small blue-grey-text text-lighten-3 pt-3">Thank you</p>
                                                    </div>
                                                    <span class="secondary-content medium-small">12.00 AM</span>
                                                </li>
                                                <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0" data-target="slide-out-chat">
                                                    <span class="avatar-status avatar-off avatar-50"><img src="{{asset('')}}app-assets/images/avatar/avatar-10.png" alt="avatar" />
                                                        <i></i>
                                                    </span>
                                                    <div class="user-content">
                                                        <h6 class="line-height-0">Sarah Graves</h6>
                                                        <p class="medium-small blue-grey-text text-lighten-3 pt-3">Okay you</p>
                                                    </div>
                                                    <span class="secondary-content medium-small">11.14 PM</span>
                                                </li>
                                                <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0" data-target="slide-out-chat">
                                                    <span class="avatar-status avatar-off avatar-50"><img src="{{asset('')}}app-assets/images/avatar/avatar-11.png" alt="avatar" />
                                                        <i></i>
                                                    </span>
                                                    <div class="user-content">
                                                        <h6 class="line-height-0">Andrew Hoffman</h6>
                                                        <p class="medium-small blue-grey-text text-lighten-3 pt-3">Can do</p>
                                                    </div>
                                                    <span class="secondary-content medium-small">7.30 PM</span>
                                                </li>
                                                <li class="collection-item right-sidebar-chat-item sidenav-trigger display-flex avatar pl-5 pb-0" data-target="slide-out-chat">
                                                    <span class="avatar-status avatar-online avatar-50"><img src="{{asset('')}}app-assets/images/avatar/avatar-12.png" alt="avatar" />
                                                        <i></i>
                                                    </span>
                                                    <div class="user-content">
                                                        <h6 class="line-height-0">Camila Lynch</h6>
                                                        <p class="medium-small blue-grey-text text-lighten-3 pt-3">Leave it</p>
                                                    </div>
                                                    <span class="secondary-content medium-small">2.00 PM</span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div id="settings" class="col s12">
                                        <p class="setting-header mt-8 mb-3 ml-5 font-weight-900">GENERAL SETTINGS</p>
                                        <ul class="collection border-none">
                                            <li class="collection-item border-none">
                                                <div class="m-0">
                                                    <span>Notifications</span>
                                                    <div class="switch right">
                                                        <label>
                                                            <input checked type="checkbox" />
                                                            <span class="lever"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="collection-item border-none">
                                                <div class="m-0">
                                                    <span>Show recent activity</span>
                                                    <div class="switch right">
                                                        <label>
                                                            <input type="checkbox" />
                                                            <span class="lever"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="collection-item border-none">
                                                <div class="m-0">
                                                    <span>Show recent activity</span>
                                                    <div class="switch right">
                                                        <label>
                                                            <input type="checkbox" />
                                                            <span class="lever"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="collection-item border-none">
                                                <div class="m-0">
                                                    <span>Show Task statistics</span>
                                                    <div class="switch right">
                                                        <label>
                                                            <input type="checkbox" />
                                                            <span class="lever"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="collection-item border-none">
                                                <div class="m-0">
                                                    <span>Show your emails</span>
                                                    <div class="switch right">
                                                        <label>
                                                            <input type="checkbox" />
                                                            <span class="lever"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="collection-item border-none">
                                                <div class="m-0">
                                                    <span>Email Notifications</span>
                                                    <div class="switch right">
                                                        <label>
                                                            <input checked type="checkbox" />
                                                            <span class="lever"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <p class="setting-header mt-7 mb-3 ml-5 font-weight-900">SYSTEM SETTINGS</p>
                                        <ul class="collection border-none">
                                            <li class="collection-item border-none">
                                                <div class="m-0">
                                                    <span>System Logs</span>
                                                    <div class="switch right">
                                                        <label>
                                                            <input type="checkbox" />
                                                            <span class="lever"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="collection-item border-none">
                                                <div class="m-0">
                                                    <span>Error Reporting</span>
                                                    <div class="switch right">
                                                        <label>
                                                            <input type="checkbox" />
                                                            <span class="lever"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="collection-item border-none">
                                                <div class="m-0">
                                                    <span>Applications Logs</span>
                                                    <div class="switch right">
                                                        <label>
                                                            <input checked type="checkbox" />
                                                            <span class="lever"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="collection-item border-none">
                                                <div class="m-0">
                                                    <span>Backup Servers</span>
                                                    <div class="switch right">
                                                        <label>
                                                            <input type="checkbox" />
                                                            <span class="lever"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="collection-item border-none">
                                                <div class="m-0">
                                                    <span>Audit Logs</span>
                                                    <div class="switch right">
                                                        <label>
                                                            <input type="checkbox" />
                                                            <span class="lever"></span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div id="activity" class="col s12">
                                        <div class="activity">
                                            <p class="mt-5 mb-0 ml-5 font-weight-900">SYSTEM LOGS</p>
                                            <ul class="widget-timeline mb-0">
                                                <li class="timeline-items timeline-icon-green active">
                                                    <div class="timeline-time">Today</div>
                                                    <h6 class="timeline-title">Homepage mockup design</h6>
                                                    <p class="timeline-text">Melissa liked your activity.</p>
                                                    <div class="timeline-content orange-text">Important</div>
                                                </li>
                                                <li class="timeline-items timeline-icon-cyan active">
                                                    <div class="timeline-time">10 min</div>
                                                    <h6 class="timeline-title">Melissa liked your activity Drinks.</h6>
                                                    <p class="timeline-text">Here are some news feed interactions concepts.</p>
                                                    <div class="timeline-content green-text">Resolved</div>
                                                </li>
                                                <li class="timeline-items timeline-icon-red active">
                                                    <div class="timeline-time">30 mins</div>
                                                    <h6 class="timeline-title">12 new users registered</h6>
                                                    <p class="timeline-text">Here are some news feed interactions concepts.</p>
                                                    <div class="timeline-content">
                                                        <img src="{{asset('')}}app-assets/images/icon/pdf.png" alt="document" height="30" width="25" class="mr-1">Registration.doc
                                                    </div>
                                                </li>
                                                <li class="timeline-items timeline-icon-indigo active">
                                                    <div class="timeline-time">2 Hrs</div>
                                                    <h6 class="timeline-title">Tina is attending your activity</h6>
                                                    <p class="timeline-text">Here are some news feed interactions concepts.</p>
                                                    <div class="timeline-content">
                                                        <img src="{{asset('')}}app-assets/images/icon/pdf.png" alt="document" height="30" width="25" class="mr-1">Activity.doc
                                                    </div>
                                                </li>
                                                <li class="timeline-items timeline-icon-orange">
                                                    <div class="timeline-time">5 hrs</div>
                                                    <h6 class="timeline-title">Josh is now following you</h6>
                                                    <p class="timeline-text">Here are some news feed interactions concepts.</p>
                                                    <div class="timeline-content red-text">Pending</div>
                                                </li>
                                            </ul>
                                            <p class="mt-5 mb-0 ml-5 font-weight-900">APPLICATIONS LOGS</p>
                                            <ul class="widget-timeline mb-0">
                                                <li class="timeline-items timeline-icon-green active">
                                                    <div class="timeline-time">Just now</div>
                                                    <h6 class="timeline-title">New order received urgent</h6>
                                                    <p class="timeline-text">Melissa liked your activity.</p>
                                                    <div class="timeline-content orange-text">Important</div>
                                                </li>
                                                <li class="timeline-items timeline-icon-cyan active">
                                                    <div class="timeline-time">05 min</div>
                                                    <h6 class="timeline-title">System shutdown.</h6>
                                                    <p class="timeline-text">Here are some news feed interactions concepts.</p>
                                                    <div class="timeline-content blue-text">Urgent</div>
                                                </li>
                                                <li class="timeline-items timeline-icon-red">
                                                    <div class="timeline-time">20 mins</div>
                                                    <h6 class="timeline-title">Database overloaded 89%</h6>
                                                    <p class="timeline-text">Here are some news feed interactions concepts.</p>
                                                    <div class="timeline-content">
                                                        <img src="{{asset('')}}app-assets/images/icon/pdf.png" alt="document" height="30" width="25" class="mr-1">Database-log.doc
                                                    </div>
                                                </li>
                                            </ul>
                                            <p class="mt-5 mb-0 ml-5 font-weight-900">SERVER LOGS</p>
                                            <ul class="widget-timeline mb-0">
                                                <li class="timeline-items timeline-icon-green active">
                                                    <div class="timeline-time">10 min</div>
                                                    <h6 class="timeline-title">System error</h6>
                                                    <p class="timeline-text">Melissa liked your activity.</p>
                                                    <div class="timeline-content red-text">Error</div>
                                                </li>
                                                <li class="timeline-items timeline-icon-cyan">
                                                    <div class="timeline-time">1 min</div>
                                                    <h6 class="timeline-title">Production server down.</h6>
                                                    <p class="timeline-text">Here are some news feed interactions concepts.</p>
                                                    <div class="timeline-content blue-text">Urgent</div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Slide Out Chat -->
                        <ul id="slide-out-chat" class="sidenav slide-out-right-sidenav-chat">
                            <li class="center-align pt-2 pb-2 sidenav-close chat-head">
                                <a href="#!"><i class="material-icons mr-0">chevron_left</i>Elizabeth Elliott</a>
                            </li>
                            <li class="chat-body">
                                <ul class="collection">
                                    <li class="collection-item display-flex avatar pl-5 pb-0" data-target="slide-out-chat">
                                        <span class="avatar-status avatar-online avatar-50"><img src="{{asset('')}}app-assets/images/avatar/avatar-7.png" alt="avatar" />
                                        </span>
                                        <div class="user-content speech-bubble">
                                            <p class="medium-small">hello!</p>
                                        </div>
                                    </li>
                                    <li class="collection-item display-flex avatar justify-content-end pl-5 pb-0" data-target="slide-out-chat">
                                        <div class="user-content speech-bubble-right">
                                            <p class="medium-small">How can we help? We're here for you!</p>
                                        </div>
                                    </li>
                                    <li class="collection-item display-flex avatar pl-5 pb-0" data-target="slide-out-chat">
                                        <span class="avatar-status avatar-online avatar-50"><img src="{{asset('')}}app-assets/images/avatar/avatar-7.png" alt="avatar" />
                                        </span>
                                        <div class="user-content speech-bubble">
                                            <p class="medium-small">I am looking for the best admin template.?</p>
                                        </div>
                                    </li>
                                    <li class="collection-item display-flex avatar justify-content-end pl-5 pb-0" data-target="slide-out-chat">
                                        <div class="user-content speech-bubble-right">
                                            <p class="medium-small">Materialize admin is the responsive materializecss admin template.</p>
                                        </div>
                                    </li>

                                    <li class="collection-item display-grid width-100 center-align">
                                        <p>8:20 a.m.</p>
                                    </li>

                                    <li class="collection-item display-flex avatar pl-5 pb-0" data-target="slide-out-chat">
                                        <span class="avatar-status avatar-online avatar-50"><img src="{{asset('')}}app-assets/images/avatar/avatar-7.png" alt="avatar" />
                                        </span>
                                        <div class="user-content speech-bubble">
                                            <p class="medium-small">Ohh! very nice</p>
                                        </div>
                                    </li>
                                    <li class="collection-item display-flex avatar justify-content-end pl-5 pb-0" data-target="slide-out-chat">
                                        <div class="user-content speech-bubble-right">
                                            <p class="medium-small">Thank you.</p>
                                        </div>
                                    </li>
                                    <li class="collection-item display-flex avatar pl-5 pb-0" data-target="slide-out-chat">
                                        <span class="avatar-status avatar-online avatar-50"><img src="{{asset('')}}app-assets/images/avatar/avatar-7.png" alt="avatar" />
                                        </span>
                                        <div class="user-content speech-bubble">
                                            <p class="medium-small">How can I purchase it?</p>
                                        </div>
                                    </li>

                                    <li class="collection-item display-grid width-100 center-align">
                                        <p>9:00 a.m.</p>
                                    </li>

                                    <li class="collection-item display-flex avatar justify-content-end pl-5 pb-0" data-target="slide-out-chat">
                                        <div class="user-content speech-bubble-right">
                                            <p class="medium-small">From ThemeForest.</p>
                                        </div>
                                    </li>
                                    <li class="collection-item display-flex avatar justify-content-end pl-5 pb-0" data-target="slide-out-chat">
                                        <div class="user-content speech-bubble-right">
                                            <p class="medium-small">Only $24</p>
                                        </div>
                                    </li>
                                    <li class="collection-item display-flex avatar pl-5 pb-0" data-target="slide-out-chat">
                                        <span class="avatar-status avatar-online avatar-50"><img src="{{asset('')}}app-assets/images/avatar/avatar-7.png" alt="avatar" />
                                        </span>
                                        <div class="user-content speech-bubble">
                                            <p class="medium-small">Ohh! Thank you.</p>
                                        </div>
                                    </li>
                                    <li class="collection-item display-flex avatar pl-5 pb-0" data-target="slide-out-chat">
                                        <span class="avatar-status avatar-online avatar-50"><img src="{{asset('')}}app-assets/images/avatar/avatar-7.png" alt="avatar" />
                                        </span>
                                        <div class="user-content speech-bubble">
                                            <p class="medium-small">I will purchase it for sure.</p>
                                        </div>
                                    </li>
                                    <li class="collection-item display-flex avatar justify-content-end pl-5 pb-0" data-target="slide-out-chat">
                                        <div class="user-content speech-bubble-right">
                                            <p class="medium-small">Great, Feel free to get in touch on</p>
                                        </div>
                                    </li>
                                    <li class="collection-item display-flex avatar justify-content-end pl-5 pb-0" data-target="slide-out-chat">
                                        <div class="user-content speech-bubble-right">
                                            <p class="medium-small">https://pixinvent.ticksy.com/</p>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="center-align chat-footer">
                                <form class="col s12" onsubmit="slideOutChat()" action="javascript:void(0);">
                                    <div class="input-field">
                                        <input id="icon_prefix" type="text" class="search" />
                                        <label for="icon_prefix">Type here..</label>
                                        <a onclick="slideOutChat()"><i class="material-icons prefix">send</i></a>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </aside>
                    <!-- END RIGHT SIDEBAR NAV -->
                    <div style="bottom: 50px; right: 19px;" class="fixed-action-btn direction-top"><a class="btn-floating btn-large gradient-45deg-yellow-red gradient-shadow"><i class="material-icons">add</i></a>
                        <ul>
                            <!-- <li><a href="css-helpers.html" class="btn-floating blue"><i class="material-icons">help_outline</i></a></li>
                            <li><a href="cards-extended.html" class="btn-floating green"><i class="material-icons">widgets</i></a></li>
                            <li><a href="app-calendar.html" class="btn-floating amber"><i class="material-icons">today</i></a></li>
                            <li><a href="app-email.html" class="btn-floating red"><i class="material-icons">mail_outline</i></a></li> -->
                        </ul>
                    </div>
                </div>
                <div class="content-overlay"></div>
            </div>
            @show
        </div>
    </div>
    <!-- END: Page Main-->

    <!-- BEGIN: Footer-->

    <footer class="page-footer footer footer-static footer-light navbar-border navbar-shadow">
        @section('footer')
        <div class="footer-copyright">
            <div class="container"><span>&copy; 2020 <a href="www.rightcliclsolutions.com" target="_blank">RightClick </a> All rights reserved.</span><span class="right hide-on-small-only"> <a href="">MOFAD</a></span></div>
        </div>
        @show
    </footer>
    @section('footer_scripts')
    <!-- JQUERY: -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <!-- BEGIN VENDOR JS-->
    <script src="{{asset('app-assets/js/vendors.min.js')}}"></script>
    <!-- BEGIN VENDOR JS-->

    <!-- BEGIN PAGE VENDOR JS-->
    <script src="{{asset('app-assets/vendors/sweetalert/sweetalert.min.js')}}"></script>
    <!-- END PAGE VENDOR JS-->

    <!-- BEGIN PAGE VENDOR JS-->
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN THEME  JS-->
    <script src="{{asset('app-assets/js/plugins.js')}}"></script>
    <script src="{{asset('app-assets/js/search.js')}}"></script>
    <script src="{{asset('app-assets/js/custom/custom-script.js')}}"></script>
    <!-- END THEME  JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="{{asset('app-assets/js/scripts/extra-components-sweetalert.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/ui-alerts.js')}}"></script>
    <!-- END PAGE LEVEL JS-->

    <script>
		
    
    $(document).ready(function() {
      
      @if(isset($post_status) && $post_status=='SUCCESS')
      {
        swal({
            title: 'success',
            icon: 'success'
          });
      }
      @elseif(isset($post_status) && $post_status=='FAILED')
      {
        swal({
          title: 'Error',
          icon: 'error'
        })
      }
      @endif
      
    });

    

	</script>
     
    @show
</body>

</html>