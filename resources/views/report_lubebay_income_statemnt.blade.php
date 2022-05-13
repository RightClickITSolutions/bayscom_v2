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
                                <p class="caption mb-0">Salerep Sales report</p>
                            </div>
                        </div>
                        <!-- DataTables example -->
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div id="button-trigger" class="card card card-default scrollspy">
                                    <div class="card-content">
                                        <h4 class="card-title">{{$lubebay->name}}</h4>
                                        <div class="row">
                                            
                                            <div class="col s12">
                                                <table id="" class="display striped">
                                            <thead>
                                                    <th>
                                                     Tilte
                                                    </th>
                                                  
                                                    <th>
                                                      Revenue
                                                    </th>
                                                    <th>
                                                      Expenses
                                                    </th>
                                                    
                                                    <th>
                                                     <a href="{{url('/accounts/account-view-details/'.$lubebay->account)}}" >View all tranactions</a>
                                                    </th>
                                                    
                                                    
                                                  </thead>
                                                  <tbody>
                                                      
                                                      
                                                    <tr>
                                                        <td></td>
                                                      <td>
                                                      {{$lubebay_data['revenue']}}
                                                      </td>
                                                      <td>
                                                      - 
                                                      </td>
                                                      <td>
                                                      <a href="{{url('/accounts/account-view-details/'.$lubebay->account)}}" >View all tranactions</a>
                                                      </td>                                                  
                                                   
                                                      
                                                    </tr>
                                                    <tr>
                                                    <td></td>
                                                      <td>
                                                      -
                                                      </td>
                                                      <td>
                                                       {{$lubebay_data['expenses']}}
                                                      </td>
                                                      <td>
                                                      <a href="{{url('/accounts/account-view-details/'.$lubebay->account)}}" >View all tranactions</a>
                                                      </td>                                                  
                                                   
                                                      
                                                    </tr>
                                                    
                                                  </tbody>
                                                  <hr>
                                                  <tfoot>
                                                  <th>

                                                  </th>
                                                    <th colspan="3">
                                                      
                                                      TOTAL
                                                    </th>
                                                    
                                                    <th>
                                                       {{number_format($total_order_value,2)}}
                                                    </th>
                                                    <th>
                                                        {{number_format($total_amount_paid,2)}}
                                                    </th>
                                                    <th>
                                                        {{number_format($total_amount_outstanding,2)}}
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
      
     
   
     
   