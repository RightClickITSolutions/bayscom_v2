@extends('layouts.mofad')
@section('head') 
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
      @include('includes.post_status')
      <div class="col s12">
                <div class="container">
                    <div class="section section-data-tables">
                        <div class="card">
                            <div class="card-content">
                                <p class="caption mb-0">Orders by {{$customer->name}}</p>
                            </div>
                        </div>
                        <!-- DataTables example -->
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div id="button-trigger" class="card card card-default scrollspy">
                                    <div class="card-content">
                                        <h4 class="card-title">Orders</h4>
                                        <div class="row">
                                            
                                            <div class="col s12">
                                                <table id="data-table-simple" class="display">
                                            <thead>
                                                    <th>
                                                      ID
                                                    </th>
                                                    <th>
                                                      Date
                                                    </th>
                                                    <th>
                                                      Total Value
                                                    </th>
                                                    <th>
                                                      Payment
                                                    </th>
                                                    <!-- <th>
                                                      Expected Payment Date
                                                    </th> -->
                                                    <th>
                                                      Created by
                                                    </th>
                                                   
                                                    <th>
                                                      Status
                                                    </th>
                                                  </thead>
                                                  <tbody>
                                                      @foreach($customer->customerPrfs as $prf)
                                                    <tr>
                                                      <td>
                                                        <a href="{{url('/prf/payment-history/'.$prf->id)}}">{{$prf->transaction_id}}</a>
                                                      </td>
                                                      <td>
                                                      {{$prf->created_at}}
                                                      </td>
                                                      <td>
                                                      {{number_format($prf->order_total,2)}}
                                                      </td>
                                                      <td>
                                                      {{$prf->payment}}
                                                      </td>
                                                      <!-- <td>
                                                      {{$prf->payment_date}}
                                                      </td> -->
                                                      <td>
                                                      {{$prf->createdBy->name}}
                                                      </td>
                                                      <td>
                                                          {{$prf->approval_status}}
                                                      </td>
                                                    </tr>
                                                    @endforeach
                                                  </tbody>
                                                </table>
                                                </div>
                                        </div>
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
    @parent()
    
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="{{asset('app-assets/vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/data-tables/js/dataTables.select.min.js')}}"></script>
    <!-- END PAGE VENDOR JS-->

   
    <!-- BEGIN PAGE LEVEL JS-->
    <!-- <script src="{{asset('app-assets/js/scripts/data-tables.js')}}"></script> -->
    <script> 
    
/*
 * DataTables - Tables
 */


$(function () {

// Simple Data Table

$('#data-table-simple').DataTable({
  "responsive": false,
  "order": [
    [1, 'dsc']
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
  "drawCallback": function (settings) {
    var api = this.api();
    var rows = api.rows({
      page: 'current'
    }).nodes();
    var last = null;

    api.column(2, {
      page: 'current'
    }).data().each(function (group, i) {
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
$(window).on('load', function () {
$(".dropdown-content.select-dropdown li").on("click", function () {
  var that = this;
  setTimeout(function () {
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

$(document).ready(function () {
checkbox.on('click', function () {
  $(this).parent().parent().parent().toggleClass('selected');
})

checkbox.on('click', function () {
  if ($(this).attr("checked")) {
    $(this).attr('checked', false);
  } else {
    $(this).attr('checked', true);
  }
})


// Select Every Row 

selectAll.on('click', function () {
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
      
     
   
     
   