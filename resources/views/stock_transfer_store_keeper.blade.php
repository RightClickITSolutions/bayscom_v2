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
                                <p class="caption mb-0">Issue Warehouse Stock Transfers </p>
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
                                                  <thead class=" ">
                                                    <th>
                                                      ID
                                                    </th>
                                                  
                                                    <th>
                                                    Products 
                                                    </th>
                                                    <th>
                                                    Origin Warhouse
                                                    </th>
                                                    <th>
                                                    Recipient Warehouse
                                                    </th>
                                                    <th>
                                                      Date Approved
                                                    </th>
                                                    
                                                    <th>
                                                      Checkout
                                                    </th>
                                                  </thead>
                                                  <tbody>
                                                      @foreach($stock_transfer_list as $stock_transfer)
                                                    <tr>
                                                      <td>
                                                        {{$stock_transfer->id}}
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
                                                      {{$stock_transfer->origin_warehouse->name}}
                                                      </td>
                                                      <td>
                                                      {{$stock_transfer->recipient_warehouse->name}}
                                                      </td>
                                                      <td>
                                                      {{$stock_transfer->createdBy->name}}
                                                      </td>
                                                      <td>
                                                      {{$stock_transfer->updated_at}}
                                                      </td>
                                                      <td>
                                                            <form action="{{url('warehouse/stock-transfer/store-keeper')}}" method="post">
                                                            {{csrf_field()}}
                                                            <input type="hidden" name="stock_transfer_id" value="{{$stock_transfer->id}}">
                                                            <button type="submit" class="btn btn-success">Issued</button>
                                                            </form>
                                                      </td>
                                                      
                                                      
                                                    </tr>
                                                    @endforeach
                                                  </tbody>
                                                </table>              </div>
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
   