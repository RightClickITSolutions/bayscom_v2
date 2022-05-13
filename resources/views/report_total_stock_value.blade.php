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
                                <p class="caption mb-0">TOTAL Inventory Value</p>
                            </div>
                        </div>
                        <!-- DataTables example -->
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div id="button-trigger" class="card card card-default scrollspy">
                                    <div class="card-content">
                                        <h4 class="card-title"></h4>
                                        <div class="row">
                                            
                                            <div class="col s12">
                                                <table id="" class="display striped">
                                            <thead>
                                                    <th>
                                                      Description
                                                    </th>
                                                  
                                                    <th>
                                                      Value
                                                    </th>
                                                    
                                                    
                                                    
                                                  </thead>
                                                  <tbody>
                                                    <tr>
                                                        <td>
                                                          <a href="{{url('/accounts/view-all-accounts')}}">
                                                            TOTAL Stock Inventory Value
                                                            <a>
                                                        </td>
                                                        <td>
                                                            {{$total_inventory_value}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                        <a href="{{url('/accounts/view-all-accounts')}}">
                                                            TOTAL Account balances
                                                            <a>
                                                        </td>
                                                        <td>
                                                            {{number_format($total_account_balances)}}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <a href="{{url('/customers')}}"> TOTAL Customer Credit<a>
                                                        </td>
                                                        <td>
                                                            {{number_format(-$total_customer_credit)}}
                                                        </td>
                                                    </tr>
                                                  </tbody>
                                                  <hr>
                                                  <tfoot>
                                                  
                                                    <th>
                                                      
                                                      TOTAL
                                                    </th>
                                                    
                                                    <th>
                                                       {{number_format($total_account_balances+$total_customer_credit+$total_inventory_value,2)}}
                                                    </th>
                                                    
                                                    
                                                    
                                                  </tfoot>
                                                  <hr>
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
    <script src="{{asset('app-assets/js/scripts/data-tables.js')}}"></script>
    
      @endsection
      
     
   
     
   