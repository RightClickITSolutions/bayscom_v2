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
                      <div class="card">
                          <div class="card-content row">
                              <p class="caption mb-0">{{$lubebay->name}} Transactions </p>  
                                     
                                    <form action="{{url('/dashboard/lubebay/'.$lubebay->id)}}" method="post">
                                    {{csrf_field()}}
                                      <div class="input-field col m4 s12">
                                                  <label class="bmd-label-floating">From: {{$start_date->format('d-m-y')}}</label>
                                                  <input name="start_date"  value= "{{old('start_date')}}" type="date" placeholder="{{old('start_date')}}" class="form-control date-input" >
                                                  
                                      </div>
                                      <div class="input-field col m4 s12">
                                                  <label class="bmd-label-floating">To: {{$end_date->format('d-m-y')}}</label>
                                                  <input name="end_date" value= "{{old('end_date')}}" type="date" placeholder="" class="form-control date-input" >
                                                  
                                      </div>

                                      <div class="input-field col m4 s12">
                                        <button class="btn green darken-2" type="submit" > Open  </button>
                                      </div>
                                    </form>
                                      
                          </div>
                      </div>
                    <div class="section">

                        <!-- Current Lubebay balance & total transactions cards-->
                        <div class="row vertical-modern-dashboard">
                            
                            <div class="col s12 m6 l6 animate fadeLeft">
                                <!-- Total Transaction -->
                                
                                <div class="card">
                                    <div class="card-content">
                                        
                                            <h4 class="card-title mb-0">Service sales <i class="material-icons float-right">more_vert</i></h4>
                                            <p class="medium-small">{{$lubebay->name}} Transactions </p>
                                        
                                       
                                        
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
                                        <h6 class="mb-0 mt-0 display-flex justify-content-between">Service Sales<i class="material-icons float-right">more_vert</i>
                                        </h6>
                                        <p class="medium-small">{{$lubebay->name}} Months Lodgements</p>
                                        <div class="current-balance-container">
                                            <div id="current-balance-donut-chart" class="current-balance-shadow"></div>
                                        </div>
                                        <h5 class="center-align">₦ <?=number_format($lubebay_total_sales)?></h5>
                                        <p class="medium-small center-align">Total sales</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Current Lubebay balance & total transactions cards-->
                        <div class="card">
                            <div class="card-content">
                                <h4 class="card-title">Lubebay Services </h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="scroll-dynamic" class="display scroll-dynamic">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">Service</th>
                                                    <th>Quantity Sold</th>
                                                    <th>Unit Price</th>
                                                    <th colspan="2">Total Sales value</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                                @foreach($compiled_lubebay_services as $lubebay_service)
                                                <tr>
                                                
                                                    <td  colspan="2">{{$lubebay_service['service_name']}}</td>
                                                    <td>{{number_format($lubebay_service['service_quantity_sold'])}}</td>
                                                    <td>{{number_format($lubebay_service['service_price'],2)}}</td>
                                                    <td colspan="2">{{number_format($lubebay_service['service_total_sales_value'],2)}}</td>
                                                    
                                                    
                                                </tr>
                                                @endforeach
                                                
                                            </tbody>
                                            <tfoot>
                                              <tr>
                                                    <th colspan="3">Totals </th>
                                                    <th>Total Sales Revenue</th>
                                                    <th>Total Expenses</th>
                                                    <th>Total Profit</th>
                                              </tr>
                                              <tr>
                                                    <th colspan="3"></th>
                                                    <th>{{number_format($grand_total_service_total_sales_value,2)}}</th>
                                                    <th>{{number_format($grand_total_service_expense,2)}}</th>
                                                    <th>{{number_format($grand_total_service_profit,2)}}</th>
                                              </tr>
                                                
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Current substores balance & total transactions cards-->
                        <div class="row vertical-modern-dashboard">
                            
                            <div class="col s12 m6 l6 animate fadeLeft">
                                <!-- Total Transaction -->
                                <div class="card">
                                    <div class="card-content">
                                        <h4 class="card-title mb-0">Lubricant sales <i class="material-icons float-right">more_vert</i></h4>
                                        <p class="medium-small">{{$substore->name}}} Months's transaction</p>
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
                                        <h6 class="mb-0 mt-0 display-flex justify-content-between">Lubricant Sales<i class="material-icons float-right">more_vert</i>
                                        </h6>
                                        <p class="medium-small">{{$substore->name}}} Months Lodgements</p>
                                        <div class="current-balance-container">
                                            <div id="current-balance-donut-chart2" class="current-balance-shadow"></div>
                                        </div>
                                        <h5 class="center-align">₦ <?=number_format($substore_total_sales)?></h5>
                                        <p class="medium-small center-align">Total sales</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Current balance & total transactions cards-->
                        <div class="card">
                            <div class="card-content">
                                <h4 class="card-title">Lubebay Lubricant sales</h4>
                                <div class="row">
                                    <div class="col s12">
                                        <table id="scroll-dynamic" class="display scroll-dynamic">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Quantity Sold</th>
                                                    <th>Unit Price</th>
                                                    <th>Total Sales value</th>
                                                    <th>Total Profit</th>
                                                    <th>Total Comissions</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                                @foreach($compiled_substore_products as $substore_product)
                                                <tr>
                                                
                                                    <td>{{$substore_product['product_name']}}</td>
                                                    <td>{{number_format($substore_product['product_quantity_sold'])}}</td>
                                                    <td>{{number_format($substore_product['product_selling_price'],2)}}</td>
                                                    <td>{{number_format($substore_product['product_total_sales_value'],2)}}</td>
                                                    <td>{{number_format($substore_product['product_total_profit'],2)}}</td>
                                                    <td>{{number_format($substore_product['product_total_commission'],2)}}</td>
                                                    
                                                </tr>
                                                @endforeach
                                                
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="3">Total </th>
                                                    <th>{{number_format($grand_total_product_total_sales_value,2)}}</th>
                                                    <th>{{number_format($grand_total_product_total_profit,2)}}</th>
                                                    <th>{{number_format($grand_total_product_total_commission,2)}}</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    
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

// Donut chart lubebay
  // -----------
  console.log('test test');
  var grand_total_price = <?=$lubebay_total_sales?> ;
  var lubebay_grand_total_lodged = <?=$lubebay_total_lodgement?> ;
  console.log(grand_total_price);
  console.log(<?=json_encode($graph_lubebay_sales_array)?>);

  var CurrentBalanceDonutChart = new Chartist.Pie(
    "#current-balance-donut-chart",
    {
      labels: [1, 2],
      series: [
        { meta: "Lodged", value: (lubebay_grand_total_lodged) },
        { meta: "Remaining", value: (<?=($lubebay_total_sales-$lubebay_total_lodgement)? ($lubebay_total_sales-$lubebay_total_lodgement): 1?>) }
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
              '<p  class="small text-center">Lodged</p><h5 class="mt-0 mb-0 small">₦ {{number_format($lubebay_total_lodgement)}}</h5>'
            }
          ]
        })
      ]
    }
  );

  
 
  // Total Transaction lubebaby 
  // -----------------
  var TotalTransactionLine = new Chartist.Line(
    "#total-transaction-line-chart",
    {
    labels: <?=$graph_label_array?>,
      series: [<?=json_encode($graph_lubebay_sales_array)?>]
    },
    {
      chartPadding: 0,
      axisX: {
        showLabel: true,
        showGrid: true
      },
      axisY: {
        labelInterpolationFnc: function(value) {
        return (value/1000).toLocaleString() + ' K'
        },
        onlyInteger: true,
        showLabel: true,
        showGrid: true,
        low:  0,
        high: <?=$highest_lubebay_graph_value ?>,
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



  // Donut chart lubebay substore
  // -----------
  console.log('test test');
  var grand_total_price = <?=$substore_total_sales?> ;
  var grand_total_lodged = <?=$substore_total_lodgement?> ;
  console.log(grand_total_price);
  console.log(<?=json_encode($graph_sales_array)?>);

  var CurrentBalanceDonutChart2 = new Chartist.Pie(
    "#current-balance-donut-chart2",
    {
      labels: [1, 2],
      series: [
        { meta: "Lodged", value: (grand_total_lodged) },
        { meta: "Remaining", value: (<?=($substore_total_sales-$substore_total_lodgement)? ($substore_total_sales-$substore_total_lodgement): 1?>) }
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
              '<p  class="small text-center">Lodged</p><h5 class="mt-0 mb-0 small">₦ {{number_format($substore_total_lodgement)}}</h5>'
            }
          ]
        })
      ]
    }
  );

  
 
  // Total Transaction lubebay subsstore 
  // -----------------
  var TotalTransactionLine2 = new Chartist.Line(
    "#total-transaction-line-chart2",
    {
    labels: <?=$graph_label_array?>,
      series: [<?=json_encode($graph_sales_array)?>]
    },
    {
      chartPadding: 0,
      axisX: {
        showLabel: true,
        showGrid: true
      },
      axisY: {
        labelInterpolationFnc: function(value) {
        return (value/1000).toLocaleString() + ' K'
        },
        onlyInteger: true,
        showLabel: true,
        showGrid: true,
        low:  0,
        high: <?=$highest_graph_value ?>,
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

  TotalTransactionLine2.on("created", function(data) {
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
   
  

</script>
    
        @endsection
      
   