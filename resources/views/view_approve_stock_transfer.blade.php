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
                                <p class="caption mb-0">Warehouse Stock Transfers</p>
                            </div>
                        </div>
                        <!-- DataTables example -->
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div id="button-trigger" class="card card card-default scrollspy">
                                    <div class="card-content">
                                        <h4 class="card-title">Stock Transfers</h4>
                                        <div class="row">
                                            
                                            <div class="col s12">
                                                <table id="data-table-simple" class="display">
                                            <thead>
                                                    <th>
                                                      ID
                                                    </th>
                                                  
                                                    <th>
                                                      Origin Warehouse
                                                    </th>
                                                    <th>
                                                      Recipient Warehouse
                                                    </th>
                                                    <th>
                                                      Products
                                                    </th>
                                                    
                                                    <th>
                                                      Created by
                                                    </th>
                                                    <th>
                                                      Date
                                                    </th>
                                                    <!-- @can('approve_prf_l1')
                                                    <th>
                                                      Supervisor Approval
                                                    </th>
                                                    @endcan -->
                                                    @can('approve_prf_l2')
                                                    <th>
                                                      Final Approval
                                                    </th>
                                                    @endcan
                                                    <th>
                                                      Status
                                                    </th>
                                                  </thead>
                                                  <tbody>
                                                      @foreach($stock_transfer_list as $stock_transfer)
                                                    <tr>
                                                      <td>
                                                        {{$stock_transfer->id}}
                                                      </td>
                                                      
                                                      <td>
                                                      {{$stock_transfer->origin_warehouse->name}}
                                                      </td>
                                                      <td>
                                                      {{$stock_transfer->recipient_warehouse->name}}
                                                      </td>
                                                      <td>
                                                        <table>
                                                            <tr> <td>Product</td> <td>Quantity</td> </tr>
                                                            @foreach($stock_transfer->transfer_snapshot() as $product)
                                                            
                                                            <tr>
                                                            <td>{{$product->product_name}}</td> <td>{{$product->product_quantity}}</td>
                                                            <tr>
                                                            @endforeach
                                                        </table>
                                                      </td>
                                                      
                                                      <td>
                                                      {{$stock_transfer->createdBy->name}}
                                                      </td>
                                                      <td>
                                                      {{$stock_transfer->created_at}}
                                                      </td>
                                                      @can('approve_pro_l2')
                                                      <td>
                                                        
                                                          @if($stock_transfer->approval->l1!=0)
                                                            {{$stock_transfer->approvedBy('l1')}}
                                                        
                                                          @elseif($stock_transfer->approval->l2!=0)
                                                            {{$stock_transfer->approvedBy('l2')}}
                                                          
                                                          @else
                                                            @include('includes.approve_form',['action'=>'/approve-warehouse-stock-transfer','process_id'=>$stock_transfer->id,'process_type'=>'stock_transfer','level'=>'l1'])
                                                            <br>
                                                            @include('includes.decline_form',['action'=>'/approve-warehouse-stock-transfer','process_id'=>$stock_transfer->id,'process_type'=>'stock_transfer','level'=>'l1'])
                                                            
                                                          
                                                          @endif
                                                      
                                                      </td>
                                                      @endcan
                                                     
                                                      
                                                      <td>
                                                          {{$stock_transfer->approval_status}}
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
    <script src="{{asset('app-assets/js/scripts/data-tables.js')}}"></script>
    
      @endsection
      
     
   
     
   