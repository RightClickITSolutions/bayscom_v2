@extends('layouts.mofad')
@section('head')
    <!-- BEGIN: Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/dashboard.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/dashboard-modern.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/intro.css') }}">
    <!-- END: Page Level CSS-->
    <!-- BEGIN: VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/flag-icon/css/flag-icon.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/vendors/data-tables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/vendors/data-tables/css/select.dataTables.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/animate-css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/chartist-js/chartist.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/vendors/chartist-js/chartist-plugin-tooltip.css') }}">


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
                    <p class="caption mb-0">Mofad Transactions </p>

                    <form action="{{ url('/dashboard/directsales') }}" method="post">
                        {{ csrf_field() }}
                        <div class="input-field col m4 s12">
                            <label class="bmd-label-floating">From: {{ $start_date->format('d-m-y') }}</label>
                            <input name="start_date" value="{{ old('start_date') }}" type="date"
                                placeholder="{{ old('start_date') }}" class="form-control date-input">

                        </div>
                        <div class="input-field col m4 s12">
                            <label class="bmd-label-floating">To: {{ $end_date->format('d-m-y') }}</label>
                            <input name="end_date" value="{{ old('end_date') }}" type="date" placeholder=""
                                class="form-control date-input">

                        </div>

                        <div class="input-field col m4 s12">
                            <button class="btn green darken-2" type="submit"> Open </button>
                        </div>
                    </form>

                </div>
            </div>
            <div class="section">


              <div id="barchart_material" style="width: 1020px; height: 350px;"></div>



                <!-- Current substores balance & total transactions cards-->
                <div class="row vertical-modern-dashboard">

                    <div class="col s12 m6 l6 animate fadeLeft">
                        <!-- Total Transaction -->
                        <div class="card">
                            <div class="card-content">
                                <h4 class="card-title mb-0">Total product sale <i
                                        class="material-icons float-right">more_vert</i></h4>
                                <p class="medium-small">Direct Sales</p>
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
                                <h6 class="mb-0 mt-0 display-flex justify-content-between">Product Sales<i
                                        class="material-icons float-right">more_vert</i>
                                </h6>
                                <p class="medium-small">This Months Lodgements</p>
                                <div class="current-balance-container">
                                    <div id="current-balance-donut-chart" class="current-balance-shadow"></div>
                                </div>
                                <h5 class="center-align">₦ <?= number_format($mofad_total_direct_sales) ?></h5>
                                <p class="medium-small center-align">Total sales</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Current balance & total transactions cards-->
                <div class="card">
                    <div class="card-content">
                        <h4 class="card-title">Direct Sale
                        </h4>
                        <div class="row">
                            <div class="col s12">
                                <table id="scroll-dynamic" class="display scroll-dynamic">
                                    <thead>
                                        <tr>
                                            <th>Product </th>
                                            <th>Quantity</th>
                                            <th>Total Value</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($comipled_product_list as $product_summery)
                                            <tr>

                                                <td>{{ $product_summery['product_name'] }}</td>
                                                <td>{{ number_format($product_summery['total_quantity']) }}</td>
                                                <td> ₦{{ number_format($product_summery['total_price'], 2) }}</td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Total </th>
                                            <th>{{ number_format($grand_total_quantity) }}</th>
                                            <th> ₦{{ number_format($grand_total_price) }}</th>
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
        <script src="{{ asset('app-assets/js/vendors.min.js') }}"></script>
        <!-- BEGIN VENDOR JS-->
        <!-- BEGIN PAGE VENDOR JS-->
        <script src="{{ asset('app-assets/vendors/chartjs/chart.min.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/chartist-js/chartist.min.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/chartist-js/chartist-plugin-tooltip.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/chartist-js/chartist-plugin-fill-donut.min.js') }}"></script>
        <!-- END PAGE VENDOR JS-->
        @parent()



        <!-- BEGIN PAGE LEVEL JS-->
        <!-- <script src="{{ asset('app-assets/js/scripts/dashboard-ecommerce.js') }}"></script> -->
        <!-- <script src="{{ asset('app-assets/js/scripts/dashboard-modern.js') }}"></script> -->
        <!-- <script src="{{ asset('app-assets/js/scripts/intro.js') }}"></script> -->
        <!-- END PAGE LEVEL JS-->



        <!-- BEGIN PAGE VENDOR JS-->
        <script src="{{ asset('app-assets/vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}">
        </script>
        <script src="{{ asset('app-assets/vendors/data-tables/js/dataTables.select.min.js') }}"></script>
        <!-- END PAGE VENDOR JS-->


        <!-- BEGIN PAGE LEVEL JS-->
        <!-- <script src="{{ asset('app-assets/js/scripts/data-tables.js') }}"></script> -->

        <script src="https://www.gstatic.com/charts/loader.js">
        </script>

        <script>
            google.charts.load('current', {
                'packages': ['bar']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable(
                    <?= $graph_data ?>
                );

                var options = {
                    chart: {
                        title: 'Company Performance',
                        subtitle: 'Sales, Expenses, and Profit: 2014-2017',
                    },
                    bars: 'horizontal' // Required for Material Bar Charts.
                };

                var chart = new google.charts.Bar(document.getElementById('barchart_material'));

                chart.draw(data, google.charts.Bar.convertOptions(options));
            }
        </script>


        <script>
            // Donut chart
            // -----------
            console.log('test test');
            var grand_total_price = <?= $mofad_total_direct_sales ?>;
            var grand_total_lodged = <?= $mofad_total_direct_sales_lodgement ?>;
            console.log(grand_total_price);
            console.log(<?= json_encode($graph_data) ?>);

            var CurrentBalanceDonutChart = new Chartist.Pie(
                "#current-balance-donut-chart", {
                    labels: [1, 2],
                    series: [{
                            meta: "Lodged",
                            value: (grand_total_lodged)
                        },
                        {
                            meta: "Remaining",
                            value: (
                                <?= $mofad_total_direct_sales - $mofad_total_direct_sales_lodgement ? $mofad_total_direct_sales - $mofad_total_direct_sales_lodgement : 1 ?>
                            )
                        }
                    ]
                }, {
                    donut: true,
                    donutWidth: 8,
                    showLabel: false,
                    plugins: [
                        Chartist.plugins.tooltip({
                            class: "current-balance-tooltip",
                            appendToBody: true
                        }),
                        Chartist.plugins.fillDonut({
                            items: [{
                                content: '<p  class="small text-center">Lodged</p><h5 class="mt-0 mb-0 small">₦ {{ number_format($mofad_total_direct_sales_lodgement) }}</h5>'
                            }]
                        })
                    ]
                }
            );



            // Total Transaction
            // -----------------
            var TotalTransactionLine = new Chartist.Line(
                "#total-transaction-line-chart", {
                    labels: <?= $graph_label_array ?>,
                    series: [<?= json_encode($graph_sales_array) ?>]
                }, {
                    chartPadding: 0,
                    axisX: {
                        showLabel: true,
                        showGrid: true
                    },
                    axisY: {
                        labelInterpolationFnc: function(value) {
                            return (value / 1000).toLocaleString() + ' K'
                        },
                        onlyInteger: true,
                        showLabel: true,
                        showGrid: true,
                        low: 0,
                        high: <?= $highest_graph_value ?>,
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
                        class: data.value.y === 35 ?
                            "ct-point ct-point-circle" : "ct-point ct-point-circle-transperent"
                    })
                    data.element.replace(circle)
                }
            })

            /*
             * DataTables - Tables
             */


            $(function() {

                // Simple Data Table

                $('#data-table-simple').DataTable({
                    "responsive": false,
                    "order": [
                        [0, 'dsc']
                    ],
                });

                // Row Grouping Table

                var table = $('#data-table-row-grouping').DataTable({
                    "responsive": true,
                    "columnDefs": [{
                        "visible": false,
                        "targets": 2
                    }],
                    "order": [
                        [2, 'asc']
                    ],
                    "displayLength": 25,
                    "drawCallback": function(settings) {
                        var api = this.api();
                        var rows = api.rows({
                            page: 'current'
                        }).nodes();
                        var last = null;

                        api.column(2, {
                            page: 'current'
                        }).data().each(function(group, i) {
                            if (last !== group) {
                                $(rows).eq(i).before(
                                    '<tr class="group"><td colspan="5">' + group + '</td></tr>'
                                );

                                last = group;
                            }
                        });
                    }
                });

                // Page Length Option Table

                $('#page-length-option').DataTable({
                    "responsive": true,
                    "lengthMenu": [
                        [10, 25, 50, -1],
                        [10, 25, 50, "All"]
                    ]
                });

                // Dynmaic Scroll table

                $('.scroll-dynamic').DataTable({
                    "responsive": true,
                    scrollY: '50vh',
                    scrollCollapse: true,
                    paging: false,
                    "order": [
                        [1, 'dsc']
                    ],
                })

                //original form changed to class selector for multiple tables
                // $('#scroll-dynamic').DataTable({
                //   "responsive": true,
                //   scrollY: '50vh',
                //   scrollCollapse: true,
                //   paging: false
                // })

                // Horizontal And Vertical Scroll Table

                $('#scroll-vert-hor').DataTable({
                    "scrollY": 200,
                    "scrollX": true
                })

                // Multi Select Table

                $('#multi-select').DataTable({
                    responsive: true,
                    "paging": true,
                    "ordering": false,
                    "info": false,
                    "columnDefs": [{
                        "visible": false,
                        "targets": 2
                    }],


                });

            });



            // Datatable click on select issue fix
            $(window).on('load', function() {
                $(".dropdown-content.select-dropdown li").on("click", function() {
                    var that = this;
                    setTimeout(function() {
                        if ($(that).parent().parent().find('.select-dropdown').hasClass('active')) {
                            // $(that).parent().removeClass('active');
                            $(that).parent().parent().find('.select-dropdown').removeClass('active');
                            $(that).parent().hide();
                        }
                    }, 100);
                });
            });

            var checkbox = $('#multi-select tbody tr th input')
            var selectAll = $('#multi-select .select-all')

            // Select A Row Function

            $(document).ready(function() {
                checkbox.on('click', function() {
                    $(this).parent().parent().parent().toggleClass('selected');
                })

                checkbox.on('click', function() {
                    if ($(this).attr("checked")) {
                        $(this).attr('checked', false);
                    } else {
                        $(this).attr('checked', true);
                    }
                })


                // Select Every Row 

                selectAll.on('click', function() {
                    $(this).toggleClass('clicked');
                    if (selectAll.hasClass('clicked')) {
                        $('#multi-select tbody tr').addClass('selected');
                    } else {
                        $('#multi-select tbody tr').removeClass('selected');
                    }

                    if ($('#multi-select tbody tr').hasClass('selected')) {
                        checkbox.prop('checked', true);

                    } else {
                        checkbox.prop('checked', false);

                    }
                })
            })
        </script>

    @endsection
