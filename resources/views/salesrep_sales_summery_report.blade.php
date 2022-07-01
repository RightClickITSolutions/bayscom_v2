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
                                        <h4 class="card-title">Sales Report: {{$sales_rep}}  {{$month}} </h4>
                                        @can('access_all_entities')
                                        <div class="row">
                                          <form class="col s12" method="post" action="{{url('/dasboard/salesrep/sales-summery/')}}">
                                            {{csrf_field()}}
                                            <div class="row">
                                              <div class="input-field col m4 s6">
                                                <select name="user" class="form-control  browser-default"> 
                                                    <option value="">Select User</option>
                                                    @foreach($system_users as $user )
                                                    <option value="{{ $user->id }}">{{ucwords($user->name)}}</option>
                                                    @endforeach
                                                

                                                </select>
                                              </div>
                                              <div class="input-field col m4 s6">
                                                <select name="month" class="form-control  browser-default"> 
                                                    <option value="">Select Month</option>
                                                    <option value="1" {{ ( old('month') == 1) ? "selected='selected'":""  }}>January</option>
                                                    <option {{ ( old('month') == 2) ? "selected='selected'":""  }}value="2">Ferbruary</option>
                                                    <option {{ ( old('month') == 3) ? "selected='selected'":""  }}value="3">March</option>
                                                    <option {{ ( old('month') == 4) ? "selected='selected'":""  }}value="4">April</option>
                                                    <option {{ ( old('month') == 5) ? "selected='selected'":""  }}value="5">May</option>
                                                    <option {{ ( old('month') == 6) ? "selected='selected'":""  }}value="6">June</option>
                                                    <option {{ ( old('month') == 7) ? "selected='selected'":""  }}value="7">July</option>
                                                    <option {{ ( old('month') == 8) ? "selected='selected'":""  }}value="8">August</option>
                                                    <option {{ ( old('month') == 9) ? "selected='selected'":""  }}value="9">September</option>
                                                    <option {{ ( old('month') == 10) ? "selected='selected'":""  }}value="10">October</option>
                                                    <option {{ ( old('month') == 11) ? "selected='selected'":""  }}value="11">November</option>
                                                    <option {{ ( old('month') == 12) ? "selected='selected'":""  }}value="12">December</option>
                                                    
                                                

                                                </select>
                                              </div>
                                              <div class="input-field  col m4 s6">
                                               <button class=" btn btn-primary green darken-3" type="submit"> Open</button>
                                              </div>
                                            </div>
                                          </form>
                                        </div>
                                        @endcan
                                        <div class="row">
                                            
                                            <div class="col s12">
                                                <table id="" class="display striped">
                                            <thead>
                                                    <th>
                                                      Order ID
                                                    </th>
                                                  
                                                    <th>
                                                      Customer Name
                                                    </th>
                                                    
                                                    <th>
                                                      Sales rep
                                                    </th>
                                                    
                                                    <th>
                                                       Total sales
                                                    </th>
                                                    <th>
                                                        Total Amount Recieved
                                                    </th>
                                                    <th>
                                                      Total Customer Outstanding balance
                                                    </th>
                                                    
                                                    
                                                  </thead>
                                                  <tbody>
                                                      
                                                      @foreach($sales_rep_client_orders as $sales_rep_client_orders)
                                                    <tr>
                                                      <td>
                                                      @foreach($sales_rep_client_orders['client_order_ids'] as $client_order_id)
                                                      @endforeach
                                                        <a href="{{url('/prf/payment-history/'.$client_order_id)}}">{{$client_order_id}}</a>
                                                      </td>
                                                      
                                                      <td>
                                                      {{$sales_rep_client_orders['client_name']}}
                                                      </td>
                                                     
                                                      
                                                      <td>
                                                      {{$sales_rep_client_orders['sales_rep']}}
                                                      </td>
                                                     
                                                      <td>
                                                      {{number_format($sales_rep_client_orders['client_total_order_value'],2)}}
                                                      </td>

                                                      
                                                      <td>
                                                      {{number_format($sales_rep_client_orders['client_total_payments'],2)}}
                                                      </td>

                                                      <td>
                                                      {{number_format($sales_rep_client_orders['client_balance'],2)}}
                                                      </td>
                                                      
                                                   
                                                      
                                                    </tr>
                                                    @endforeach
                                                  </tbody>
                                                  
                                                  <tfoot class="grey">
                                                  
                                                  <th>

                                                  </th>
                                                    <th colspan="2">
                                                      
                                                      TOTAL
                                                    </th>
                                                    
                                                    <th  colspan="2">
                                                       {{number_format($grand_total_sales_value,2)}}
                                                    </th>
                                                    <th  colspan="2">
                                                     
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
      
     
   
     
   