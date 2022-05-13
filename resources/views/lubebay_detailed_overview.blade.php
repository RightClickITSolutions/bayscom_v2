@extends('layouts.mofad')
@section('head') 
    <!-- BEGIN: Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/dashboard.css')}}">
    <!-- END: Page Level CSS-->
     <!-- BEGIN: VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/flag-icon/css/flag-icon.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/data-tables/css/select.dataTables.min.css')}}">
    <!-- END: VENDOR CSS-->
    @parent()
   
@endsection()

      @section('side_nav')
        @parent()
      @endsection
      @section('top_nav')
            @parent()
      @endsection
      <!-- End Navbar -->
      @section('content')
         <div class="col s12">
                <div class="container">
                    <div class="section">
                        <!--card stats start-->
                        <div id="card-stats" class="pt-0">
                            <div class="row">
                                <div class="col s12 m12 l12 xl12">
                                    <div class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text animate fadeLeft">
                                        <div class="padding-4">
                                            <div class="row">
                                                <div class="col s12 m12">
                                                    <i class="material-icons background-round mt-5">drive_eta</i>
                                                    <p>Lubebays</p>
                                                </div>
                                                <div class="col s12 m12 right-align">
                                                    <h5 class="mb-0 white-text"></h5>
                                                    <p class="no-margin"s>Total earned</p>
                                                    <p>₦{{number_format($grand_total-$expense_grand_total,2)}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-content">
                                            <h4 class="card-title">Lubay Services earnings
                                            </h4>
                                            <div class="row">
                                                <div class="col s10">
                                                    <table id="scroll-dynamic" class="display scroll-dynamic">
                                                        <thead>
                                                            <tr>
                                                                <th>Lubebay </th>
                                                                <th>service Sales Total</th>
                                                                <th>Expense Total</th>
                                                                <th>Net Income</th>
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        
                                                            @foreach($compiled_lubebays as $lubebay)
                                                            <tr>
                                                            
                                                                <td>{{$lubebay['lubebay_name']}}</td>
                                                                <td>{{number_format($lubebay['lubebay_sales_totals'],2)}}</td>
                                                                <td>{{number_format($lubebay['lubebay_expense_totals'],2)}}</td>
                                                                <td>{{number_format(($lubebay['lubebay_sales_totals'] - $lubebay['lubebay_expense_totals']),2)}}</td>
                                                                
                                                            </tr>
                                                            @endforeach
                                                            
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>Total </th>
                                                                <th>{{number_format($grand_total ,2)}}</th>
                                                                <th>{{number_format($expense_grand_total ,2)}}</th>
                                                                <th>{{number_format($grand_total - $expense_grand_total ,2) }}</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                                
                            </div>
                        </div>
                        <!--card stats end-->

                       

                        <!--yearly & weekly revenue chart start-->
                        <!-- <div id="sales-chart">
                            <div class="row">
                                <div class="col s12 m8 l8">
                                    <div id="revenue-chart" class="card animate fadeUp">
                                        <div class="card-content">
                                            <h4 class="header mt-0">
                                                REVENUE FOR 2019
                                                <span class="purple-text small text-darken-1 ml-1">
                                                    <i class="material-icons">keyboard_arrow_up</i> 15.58 %</span>
                                                <a class="waves-effect waves-light btn gradient-45deg-purple-deep-orange gradient-shadow right">Details</a>
                                            </h4>
                                            <div class="row">
                                                <div class="col s12">
                                                    <div class="yearly-revenue-chart">
                                                        <canvas id="thisYearRevenue" class="firstShadow" height="350"></canvas>
                                                        <canvas id="lastYearRevenue" height="350"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m4 l4">
                                    <div id="weekly-earning" class="card animate fadeUp">
                                        <div class="card-content">
                                            <h4 class="header m-0">Earning <i class="material-icons right grey-text lighten-3">more_vert</i></h4>
                                            <p class="no-margin grey-text lighten-3 medium-small">Mon 15 - Sun 21</p>
                                            <h3 class="header">₦899.39 <i class="material-icons deep-orange-text text-accent-2">arrow_upward</i>
                                            </h3>
                                            <canvas id="monthlyEarning" class="" height="150"></canvas>
                                            <div class="center-align">
                                                <p class="lighten-3">Total Weekly Earning</p>
                                                <a class="waves-effect waves-light btn gradient-45deg-purple-deep-orange gradient-shadow">View
                                                    Full</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <!--yearly & weekly revenue chart end-->
                        <!-- Member online, Currunt Server load & Today's Revenue Chart start -->
                        <!-- <div id="daily-data-chart">
                            <div class="row">
                                <div class="col s12 m4 l4">
                                    <div class="card pt-0 pb-0 animate fadeLeft">
                                        <div class="dashboard-revenue-wrapper padding-2 ml-2">
                                            <span class="new badge gradient-45deg-light-blue-cyan gradient-shadow mt-2 mr-2">+ 42.6%</span>
                                            <p class="mt-2 mb-0">Total Customers</p>
                                            <p class="no-margin grey-text lighten-3">360 avg</p>
                                            <h5>3,450</h5>
                                        </div>
                                        <div class="sample-chart-wrapper" style="margin-bottom: -14px; margin-top: -75px;">
                                            <canvas id="custom-line-chart-sample-one" class="center"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m4 l4 animate fadeUp">
                                    <div class="card pt-0 pb-0">
                                        <div class="dashboard-revenue-wrapper padding-2 ml-2">
                                            <span class="new badge gradient-45deg-purple-deep-orange gradient-shadow mt-2 mr-2">+ 12%</span>
                                            <p class="mt-2 mb-0">Active Customers</p>
                                            <p class="no-margin grey-text lighten-3">High sales rate</p>
                                            <h5>+2500</h5>
                                        </div>
                                        <div class="sample-chart-wrapper" style="margin-bottom: -14px; margin-top: -75px;">
                                            <canvas id="custom-line-chart-sample-two" class="center"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m4 l4">
                                    <div class="card pt-0 pb-0 animate fadeRight">
                                        <div class="dashboard-revenue-wrapper padding-2 ml-2">
                                            <span class="new badge gradient-45deg-amber-amber gradient-shadow mt-2 mr-2">+ ₦900</span>
                                            <p class="mt-2 mb-0">Today's revenue</p>
                                            <p class="no-margin grey-text lighten-3">₦40,512 avg</p>
                                            <h5>₦ 22,300</h5>
                                        </div>
                                        <div class="sample-chart-wrapper" style="margin-bottom: -14px; margin-top: -75px;">
                                            <canvas id="custom-line-chart-sample-three" class="center"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <!-- Member online, Currunt Server load & Today's Revenue Chart start -->
                        
                    
                </div>
                <div class="content-overlay"></div>
            </div>
      @endsection

      @section('footer')
        @parent()
     
      @endsection
      @section('footer_scripts')
      @parent()
      
      
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="{{asset('app-assets/vendors/chartjs/chart.min.js')}}"></script>
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="{{asset('app-assets/js/scripts/dashboard-ecommerce.js')}}"></script>
    <!-- END PAGE LEVEL JS-->
    
    
    
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="{{asset('app-assets/vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/data-tables/js/dataTables.select.min.js')}}"></script>
    <!-- END PAGE VENDOR JS-->

   
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="{{asset('app-assets/js/scripts/data-tables.js')}}"></script>
    
        @endsection
      
   