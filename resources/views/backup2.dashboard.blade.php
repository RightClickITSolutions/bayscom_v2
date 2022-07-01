@extends('layouts.mofad')
@section('head') 
    <!-- BEGIN: Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/dashboard.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/dashboard-modern.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/intro.css')}}">
    <!-- END: Page Level CSS-->
     <!-- BEGIN: VENDOR CSS-->
   <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/flag-icon/css/flag-icon.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/data-tables/css/select.dataTables.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/animate-css/animate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/chartist-js/chartist.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/chartist-js/chartist-plugin-tooltip.css')}}">
    
   
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

                        <!-- Current substores balance & total transactions cards-->
                        <div class="row vertical-modern-dashboard">
                            
                            <div class="col s12 m6 l6 animate fadeLeft">
                                <!-- Total Transaction -->
                                <div class="card">
                                    <div class="card-content">
                                        <h4 class="card-title mb-0">Total product sale <i class="material-icons float-right">more_vert</i></h4>
                                        <p class="medium-small">This week's transaction</p>
                                        <div class="total-transaction-container">
                                            <div id="total-transaction-line-chart" class="total-transaction-shadow"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col s12 m6 l6">
                                <!-- Current Balance -->
                                <div class="card animate fadeRight">
                                    <div class="card-content">
                                        <h6 class="mb-0 mt-0 display-flex justify-content-between">Product Sales<i class="material-icons float-right">more_vert</i>
                                        </h6>
                                        <p class="medium-small">sales(₦1,000,000,/day)</p>
                                        <div class="current-balance-container">
                                            <div id="current-balance-donut-chart" class="current-balance-shadow"></div>
                                        </div>
                                        <h5 class="center-align">₦ <?=number_format($grand_total_price)?></h5>
                                        <p class="medium-small center-align">Total sales</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Current balance & total transactions cards-->
                        <div class="card">
                            <div class="card-content">
                                <h4 class="card-title">Station/lubebeay Product Sales / 
                                </h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="scroll-dynamic" class="display scroll-dynamic">
                                            <thead>
                                                <tr>
                                                    <th>Source</th>
                                                    <th>Total sales</th>
                                                    <th>Total Lodged</th>
                                                    <th>Total Outstanding</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                                @foreach($compiled_substores as $substore)
                                                <tr>
                                                
                                                    <td>{{$substore['substore_name']}}</td>
                                                    <td>{{number_format($substore['substore_sales_totals'],2)}}</td>
                                                    <td>{{number_format($substore['substore_lodgement_totals'],2)}}</td>
                                                    <td>{{number_format(($substore['substore_sales_totals'] - $substore['substore_lodgement_totals']),2)}}</td>
                                                    
                                                </tr>
                                                @endforeach
                                                
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Total </th>
                                                    <th>{{number_format($substores_grand_total ,2)}}</th>
                                                    <th>{{number_format($substores_lodgement_grand_total ,2)}}</th>
                                                    <th>{{number_format($substores_grand_total - $substores_lodgement_grand_total ,2) }}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--card stats products start-->
                        <!-- <div id="card-stats" class="pt-0">
                            <div class="row">
                                <div class="col s12 m6 l6 xl6">
                                    <div class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text animate fadeLeft">
                                        <div class="padding-4">
                                            <div class="row">
                                                <div class="col s7 m7">
                                                    <i class="material-icons background-round mt-5">KN</i>
                                                    <p>Total Sales</p>
                                                </div>
                                                <div class="col s5 m5 right-align">
                                                    <h5 class="mb-0 white-text">1555</h5>
                                                    <p class="no-margin">Total Sales</p>
                                                    <p>₦6,00,000.00</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-content">
                                            <h4 class="card-title">Product sales
                                            </h4>
                                            <div class="row">
                                                <div class="col s12">
                                                    <table id="scroll-dynamic" class="display scroll-dynamic">
                                                        <thead>
                                                            <tr>
                                                                <th>Product </th>
                                                                <th>Quatity</th>
                                                                <th>Total Value</th>
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        
                                                            @foreach($comipled_product_list as $product_summery)
                                                            <tr>
                                                            
                                                                <td>{{$product_summery['product_name']}}</td>
                                                                <td>{{$product_summery['total_quantity']}}</td>
                                                                <td>{{$product_summery['total_price']}}</td>
                                                                
                                                            </tr>
                                                            @endforeach
                                                            
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>Total </th>
                                                                <th>{{$grand_total_quantity}}</th>
                                                                <th>{{$grand_total_price}}</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12 m6 l6 xl6">
                                    <div class="card gradient-45deg-red-pink gradient-shadow min-height-100 white-text animate fadeLeft">
                                        <div class="padding-4">
                                            <div class="row">
                                                <div class="col s7 m7">
                                                    <i class="material-icons background-round mt-5">ABJ</i>
                                                    <p>Value</p>
                                                </div>
                                                <div class="col s5 m5 right-align">
                                                    <h5 class="mb-0 white-text">1885</h5>
                                                    <p class="no-margin">Total Sales</p>
                                                    <p>₦1,12,900</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-content">
                                            <h4 class="card-title">Product sales
                                            </h4>
                                            <div class="row">
                                                <div class="col s12">
                                                    <table id="scroll-dynamic" class="display scroll-dynamic">
                                                        <thead>
                                                            <tr>
                                                                <th>Product </th>
                                                                <th>Quatity</th>
                                                                <th>Total Value</th>
                                                                
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        
                                                        @foreach($comipled_product_list as $product_summery)
                                                        <tr>
                                                        
                                                            <td>{{$product_summery['product_name']}}</td>
                                                            <td>{{$product_summery['total_quantity']}}</td>
                                                            <td>{{$product_summery['total_price']}}</td>
                                                            
                                                        </tr>
                                                        @endforeach
                                                        
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Total </th>
                                                            <th>{{$grand_total_quantity}}</th>
                                                            <th>{{$grand_total_price}}</th>
                                                        </tr>
                                                    </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div> -->

                         <!-- Current lubebay balance & total transactions cards-->
                         <div class="row vertical-modern-dashboard">
                            
                         <div class="col s12 m6 l6 animate fadeLeft">
                                <!-- Total Transaction -->
                                <div class="card">
                                    <div class="card-content">
                                        <h4 class="card-title mb-0">Total product sale <i class="material-icons float-right">more_vert</i></h4>
                                        <p class="medium-small">This week's transaction</p>
                                        <div class="total-transaction-container">
                                            <div id="total-transaction-line-chart2" class="total-transaction-shadow"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col s12 m6 l6">
                                <!-- Current Balance -->
                                <div class="card animate fadeRight">
                                    <div class="card-content">
                                        <h6 class="mb-0 mt-0 display-flex justify-content-between">Services Sales<i class="material-icons float-right">more_vert</i>
                                        </h6>
                                        <p class="medium-small">This Week</p>
                                        <div class="current-balance-container">
                                            <div id="current-balance-donut-chart2" class="current-balance-shadow"></div>
                                        </div>
                                        <h5 class="center-align">₦ <?=number_format($grand_total_price,2)?></h5>
                                        <p class="medium-small center-align">Total Services sales</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Current balance & total transactions cards lubebay-->
                        <div class="card">
                            <div class="card-content">
                                <h4 class="card-title">Lubay Services earnings
                                </h4>
                                <div class="row">
                                    <div class="col s12">
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
                                                    <th>{{number_format($lubebays_grand_total ,2)}}</th>
                                                    <th>{{number_format($lubebays_expense_grand_total ,2)}}</th>
                                                    <th>{{number_format($lubebays_grand_total - $lubebays_expense_grand_total ,2) }}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--card stats end-->

                       
<!-- 
                        yearly & weekly revenue chart start
                        <div id="sales-chart">
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
      @section('footer_scripts')
      <script src="{{asset('app-assets/js/vendors.min.js')}}"></script>
    <!-- BEGIN VENDOR JS-->
      <!-- BEGIN PAGE VENDOR JS-->
    <script src="{{asset('app-assets/vendors/chartjs/chart.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/chartist-js/chartist.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/chartist-js/chartist-plugin-tooltip.js')}}"></script>
    <script src="{{asset('app-assets/vendors/chartist-js/chartist-plugin-fill-donut.min.js')}}"></script>
    <!-- END PAGE VENDOR JS-->
      @parent()
      
      
    
    <!-- BEGIN PAGE LEVEL JS-->
    <!-- <script src="{{asset('app-assets/js/scripts/dashboard-ecommerce.js')}}"></script> -->
    <!-- <script src="{{asset('app-assets/js/scripts/dashboard-modern.js')}}"></script> -->
    <!-- <script src="{{asset('app-assets/js/scripts/intro.js')}}"></script> -->
    <!-- END PAGE LEVEL JS-->
    
    
    
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="{{asset('app-assets/vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/data-tables/js/dataTables.select.min.js')}}"></script>
    <!-- END PAGE VENDOR JS-->

   
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="{{asset('app-assets/js/scripts/data-tables.js')}}"></script>

<script>
// Donut chart
  // -----------
  console.log('test test');
  var grand_total_price = <?=$grand_total_price?> ;
  var grand_total_lodged = <?=$grand_total_lodged?> ;
  console.log(grand_total_price);
  console.log(<?=json_encode($graph_values)?>);

  var CurrentBalanceDonutChart = new Chartist.Pie(
    "#current-balance-donut-chart",
    {
      labels: [1, 2],
      series: [
        { meta: "Lodged", value: (grand_total_lodged) },
        { meta: "Remaining", value: (<?=($grand_total_price-$grand_total_lodged)? ($grand_total_price-$grand_total_lodged): 1?>) }
      ]
    },
    {
      donut: true,
      donutWidth: 8,
      showLabel: false,
      plugins: [
        Chartist.plugins.tooltip({
          class: "current-balance-tooltip",
          appendToBody: true
        }),
        Chartist.plugins.fillDonut({
          items: [
            {
              content:
              '<p  class="small text-center">Lodged</p><h5 class="mt-0 mb-0 small">₦ {{number_format($grand_total_lodged)}}</h5>'
            }
          ]
        })
      ]
    }
  );

  var CurrentBalanceDonutChart2 = new Chartist.Pie(
    "#current-balance-donut-chart2",
    {
      labels: [1, 2],
      series: [
        { meta: "Lodged", value: (grand_total_lodged) },
        { meta: "Remaining", value: ((grand_total_price-grand_total_lodged)) }
      ]
    },
    {
      donut: true,
      donutWidth: 8,
      showLabel: false,
      plugins: [
        Chartist.plugins.tooltip({
          class: "current-balance-tooltip",
          appendToBody: true
        }),
        Chartist.plugins.fillDonut({
          items: [
            {
              content:
              '<p  class="small text-center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lodged</p><h5 class="mt-0 mb-0 small">₦ {{number_format($grand_total_lodged)}}</h5>'
            }
          ]
        })
      ]
    }
  );

 
  // Total Transaction
  // -----------------
  var TotalTransactionLine = new Chartist.Line(
    "#total-transaction-line-chart",
    {
      series: [<?=json_encode($graph_values)?>]
    },
    {
      chartPadding: 0,
      axisX: {
        showLabel: true,
        showGrid: true
      },
      axisY: {
        showLabel: true,
        showGrid: true,
        low:  0,
        high: 105,
        scaleMinSpace: 40
      },
      lineSmooth: Chartist.Interpolation.simple({
        divisor: 2
      }),
      plugins: [
        Chartist.plugins.tooltip({
          class: "total-transaction-tooltip",
          appendToBody: true
        })
      ],
      fullWidth: true
    }
  )

  TotalTransactionLine.on("created", function(data) {
    var defs = data.svg.querySelector("defs") || data.svg.elem("defs")
    defs
      .elem("linearGradient", {
        id: "lineLinearStats",
        x1: 0,
        y1: 0,
        x2: 1,
        y2: 0
      })
      .elem("stop", {
        offset: "0%",
        "stop-color": "rgba(255, 82, 249, 0.1)"
      })
      .parent()
      .elem("stop", {
        offset: "10%",
        "stop-color": "rgba(255, 82, 249, 1)"
      })
      .parent()
      .elem("stop", {
        offset: "30%",
        "stop-color": "rgba(255, 82, 249, 1)"
      })
      .parent()
      .elem("stop", {
        offset: "95%",
        "stop-color": "rgba(133, 3, 168, 1)"
      })
      .parent()
      .elem("stop", {
        offset: "100%",
        "stop-color": "rgba(133, 3, 168, 0.1)"
      })

    return defs
  }).on("draw", function(data) {
    var circleRadius = 5
    if (data.type === "point") {
      var circle = new Chartist.Svg("circle", {
        cx: data.x,
        cy: data.y,
        "ct:value": data.y,
        r: circleRadius,
        class:
          data.value.y === 35
            ? "ct-point ct-point-circle"
            : "ct-point ct-point-circle-transperent"
      })
      data.element.replace(circle)
    }
  })

  TotalTransactionLine = null;
  data = null;
   // Total Transaction
  // -----------------
  var TotalTransactionLine2 = new Chartist.Line(
    "#total-transaction-line-chart2",
    {
      series: [<?=json_encode($graph_values)?>]
    },
    {
      chartPadding: 0,
      axisX: {
        showLabel: true,
        showGrid: true
      },
      axisY: {
        showLabel: true,
        showGrid: true,
        low:  0,
        high: 105,
        scaleMinSpace: 40
      },
      lineSmooth: Chartist.Interpolation.simple({
        divisor: 2
      }),
      plugins: [
        Chartist.plugins.tooltip({
          class: "total-transaction-tooltip2",
          appendToBody: true
        })
      ],
      fullWidth: true
    }
  )

  TotalTransactionLine2.on("created", function(data) {
    var defs2 = data.svg.querySelector("defs2") || data.svg.elem("defs2")
    defs2
      .elem("linearGradient2", {
        id: "lineLinearStats",
        x1: 0,
        y1: 0,
        x2: 1,
        y2: 0
      })
      .elem("stop", {
        offset: "0%",
        "stop-color": "rgba(255, 82, 249, 0.1)"
      })
      .parent()
      .elem("stop", {
        offset: "10%",
        "stop-color": "rgba(255, 82, 249, 1)"
      })
      .parent()
      .elem("stop", {
        offset: "30%",
        "stop-color": "rgba(255, 82, 249, 1)"
      })
      .parent()
      .elem("stop", {
        offset: "95%",
        "stop-color": "rgba(133, 3, 168, 1)"
      })
      .parent()
      .elem("stop", {
        offset: "100%",
        "stop-color": "rgba(133, 3, 168, 0.1)"
      })

    return defs2
  }).on("draw", function(data) {
    var circleRadius = 0
    if (data.type === "point") {
      var circle = new Chartist.Svg("circle", {
        cx: data.x,
        cy: data.y,
        "ct:value": data.y,
        r: circleRadius,
        class:
          data.value.y === 0
            ? "ct-point ct-point-circle"
            : "ct-point ct-point-circle-transperent"
      })
      data.element.replace(circle)
    }
  })



  

  //       // -----------
  // var CurrentBalanceDonutChart = new Chartist.Pie(
  //   "#mofad-total-sales-current-balance-donut-chart",
  //   {
  //     labels: [1, 2],
  //     series: [
  //       { meta: "Total Sales", value: <?=$grand_total_price?> },
  //       { meta: "Lodged", value: <?=$grand_total_lodged?> }
  //     ]
  //   },
  //   {
  //     donut: true,
  //     donutWidth: 8,
  //     showLabel: false,
  //     plugins: [
        
  //       Chartist.plugins.fillDonut({
  //         items: [
  //           {
  //             content:
  //               '<p  class="small text-center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lodged</p><h5 class="mt-0 mb-0 small">₦ {{number_format($grand_total_lodged,2)}}</h5>'
  //           }
  //         ]
  //       })
  //     ]
  //   }
  // )

  // // Total Transaction
  // // -----------------
  // var TotalTransactionLine = new Chartist.Line(
  //   "#total-transaction-line-chart",
  //   {
  //     series: [[300, 1000, 400, 2000, 700, 4500, 2500 ]]
  //   },
  //   {
  //     chartPadding: 0,
  //     axisX: {
  //       showLabel: true,
  //       showGrid: true,
  //       low: 0, 
  //       high: 90,
  //       scaleMinSpace: 15
  //     },
  //     axisY: {
  //       showLabel: true,
  //       showGrid: true,
  //       low: 0, 
  //       high: 5000,
  //       scaleMinSpace: 40
  //     },
  //     lineSmooth: Chartist.Interpolation.simple({
  //       divisor: 2
  //     }),
  //     plugins: [
  //       Chartist.plugins.tooltip({
  //         class: "total-transaction-tooltip",
  //         appendToBody: true
  //       })
  //     ],
  //     fullWidth: true
  //   }
  // )

  // TotalTransactionLine.on("created", function(data) {
  //   var defs = data.svg.querySelector("defs") || data.svg.elem("defs")
  //   defs
  //     .elem("linearGradient", {
  //       id: "lineLinearStats",
  //       x1: 0,
  //       y1: 0,
  //       x2: 1,
  //       y2: 0
  //     })
  //     .elem("stop", {
  //       offset: "0%",
  //       "stop-color": "rgba(255, 82, 249, 0.1)"
  //     })
  //     .parent()
  //     .elem("stop", {
  //       offset: "10%",
  //       "stop-color": "rgba(255, 82, 249, 1)"
  //     })
  //     .parent()
  //     .elem("stop", {
  //       offset: "30%",
  //       "stop-color": "rgba(255, 82, 249, 1)"
  //     })
  //     .parent()
  //     .elem("stop", {
  //       offset: "95%",
  //       "stop-color": "rgba(133, 3, 168, 1)"
  //     })
  //     .parent()
  //     .elem("stop", {
  //       offset: "100%",
  //       "stop-color": "rgba(133, 3, 168, 0.1)"
  //     })

  //   return defs
  // }).on("draw", function(data) {
  //   var circleRadius = 5
  //   if (data.type === "point") {
  //     var circle = new Chartist.Svg("circle", {
  //       cx: data.x,
  //       cy: data.y,
  //       "ct:value": data.y,
  //       r: circleRadius,
  //       class:
  //         data.value.y === 3500
  //           ? "ct-point ct-point-circle"
  //           : "ct-point ct-point-circle-transperent"
  //     })
  //     data.element.replace(circle)
  //   }
  // })
   
  //         // -----------
  //       //   service
  // var CurrentBalanceDonutChart = new Chartist.Pie(
  //   "#mofad-total-services-current-balance-donut-chart",
  //   {
  //     labels: [1, 2],
  //     series: [
  //       { meta: "Total Sales", value: <?=$grand_total_price?> },
  //       { meta: "Lodged", value: <?=$grand_total_lodged?> }
  //     ]
  //   },
  //   {
  //     donut: true,
  //     donutWidth: 8,
  //     showLabel: false,
  //     plugins: [
        
  //       Chartist.plugins.fillDonut({
  //         items: [
  //           {
  //             content:
  //               '<p  class="small text-center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lodged</p><h5 class="mt-0 mb-0 small">₦ {{number_format($grand_total_lodged,2)}}</h5>'
  //           }
  //         ]
  //       })
  //     ]
  //   }
  // )

  // // Total Transaction
  // // -----------------
  // var TotalTransactionLine = new Chartist.Line(
  //   "#lubebay-total-transaction-line-chart",
  //   {
  //     series: [[300, 1000, 400, 2000, 700, 4500, 2500 ]]
  //   },
  //   {
  //     chartPadding: 0,
  //     axisX: {
  //       showLabel: true,
  //       showGrid: true,
  //       low: 0, 
  //       high: 90,
  //       scaleMinSpace: 15
  //     },
  //     axisY: {
  //       showLabel: true,
  //       showGrid: true,
  //       low: 0, 
  //       high: 5000,
  //       scaleMinSpace: 40
  //     },
  //     lineSmooth: Chartist.Interpolation.simple({
  //       divisor: 2
  //     }),
  //     plugins: [
  //       Chartist.plugins.tooltip({
  //         class: "total-transaction-tooltip",
  //         appendToBody: true
  //       })
  //     ],
  //     fullWidth: true
  //   }
  // )

  // TotalTransactionLine.on("created", function(data) {
  //   var defs = data.svg.querySelector("defs") || data.svg.elem("defs")
  //   defs
  //     .elem("linearGradient", {
  //       id: "lineLinearStats",
  //       x1: 0,
  //       y1: 0,
  //       x2: 1,
  //       y2: 0
  //     })
  //     .elem("stop", {
  //       offset: "0%",
  //       "stop-color": "rgba(255, 82, 249, 0.1)"
  //     })
  //     .parent()
  //     .elem("stop", {
  //       offset: "10%",
  //       "stop-color": "rgba(255, 82, 249, 1)"
  //     })
  //     .parent()
  //     .elem("stop", {
  //       offset: "30%",
  //       "stop-color": "rgba(255, 82, 249, 1)"
  //     })
  //     .parent()
  //     .elem("stop", {
  //       offset: "95%",
  //       "stop-color": "rgba(133, 3, 168, 1)"
  //     })
  //     .parent()
  //     .elem("stop", {
  //       offset: "100%",
  //       "stop-color": "rgba(133, 3, 168, 0.1)"
  //     })

  //   return defs
  // }).on("draw", function(data) {
  //   var circleRadius = 5
  //   if (data.type === "point") {
  //     var circle = new Chartist.Svg("circle", {
  //       cx: data.x,
  //       cy: data.y,
  //       "ct:value": data.y,
  //       r: circleRadius,
  //       class:
  //         data.value.y === 3500
  //           ? "ct-point ct-point-circle"
  //           : "ct-point ct-point-circle-transperent"
  //     })
  //     data.element.replace(circle)
  //   }
  // })

  
   
  

</script>
    
        @endsection
      
   