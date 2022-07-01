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
      
      <div class="col s12">
                <div class="container">
                    <div class="section section-data-tables">
                        <div class="card">
                            <div class="card-content">
                                <p class="caption mb-0">{{$warehouse->name}} {{$product->name()}} Bin Card</p>
                            </div>
                        </div>
                        <!-- DataTables example -->
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div id="button-trigger" class="card card card-default scrollspy">
                                    <div class="card-content">
                                        <h4 class="card-title">Product In Card as at {{now()}} </h4>
                                        <div class="row">
                                        
                                            <div class="col s12">
                                                <table id="data-table-simple" class="display">
                                                  <thead class="">
                                                    <th>
                                                      ID
                                                    </th>
                                                    <th>
                                                      Date
                                                    </th>
                                                    <th>
                                                      Order Type
                                                    </th>
                                                    <th>
                                                      Order ID
                                                    </th>
                                                    <th>
                                                      Recieved 
                                                    </th>
                                                    <th>
                                                      Issued 
                                                    </th>
                                                    <th>
                                                      Balance 
                                                    </th>
                                                    <th>
                                                      Recieved By
                                                    </th>
                                                                                
                                                    
                                                  </thead>
                                                  <tbody>
                                                      @foreach($stock_transactions as $stock_transaction)
                                                    <tr>
                                                    <td>
                                                    {{$stock_transaction->id}}
                                                    </td>
                                                      <td>
                                                      {{$stock_transaction->created_at}}
                                                      </td>
                                                      <td>
                                                      {{$stock_transaction->order_type}}
                                                      </td>
                                                      
                                                      
                                                      @if($stock_transaction->transaction_type == 'CREDIT' && $stock_transaction->order_type=='PRO')
                                                      <td>
                                                      
                                                      <a href="{{url('pro/view-details/'.$stock_transaction->order_id)}}">{{$stock_transaction->order_id}}</a>
                                                      </td>

                                                        <td>                                                      
                                                        {{$stock_transaction->quantity}}
                                                        </td>
                                                        <td>                                                      
                                                        - 
                                                        </td>
                                                      @elseif($stock_transaction->transaction_type == 'CREDIT' && $stock_transaction->order_type=='STOCK_TRANSFER')
                                                      <td>
                                                      
                                                      <a href="{{url('/warehouse/view-warehouse-transfer')}}">{{$stock_transaction->order_id}}</a>
                                                      </td>

                                                        <td>                                                      
                                                        {{$stock_transaction->quantity}}
                                                        </td>
                                                        <td>                                                      
                                                        - 
                                                        </td>
                                                      @elseif($stock_transaction->transaction_type == 'CREDIT' )
                                                      <td>
                                                      
                                                      {{$stock_transaction->order_id}}
                                                      </td>

                                                        <td>                                                      
                                                        {{$stock_transaction->quantity}}
                                                        </td>
                                                        <td>                                                      
                                                        - 
                                                        </td>
                                                      
                                                      @endif
                                                      @if($stock_transaction->transaction_type == 'DEBIT' && $stock_transaction->order_type=='PRF')
                                                      <td>
                                                      
                                                      <a href="{{url('prf/invoice/'.$stock_transaction->order_id)}}">{{$stock_transaction->order_id}}</a>
                                                      </td>
                                                        <td>                                                      
                                                        - 
                                                        </td>
                                                        <td>                                                      
                                                        {{$stock_transaction->quantity}}
                                                        </td>
                                                      @elseif($stock_transaction->transaction_type == 'DEBIT' && $stock_transaction->order_type=='STOCK_TRANSFER')
                                                      <td>
                                                      
                                                      <a href="{{url('/warehouse/view-warehouse-transfer')}}">{{$stock_transaction->order_id}}</a>
                                                      </td>
                                                        <td>                                                      
                                                        - 
                                                        </td>
                                                        <td>                                                      
                                                        {{$stock_transaction->quantity}}
                                                      </td>
                                                      @elseif($stock_transaction->transaction_type == 'DEBIT')
                                                      <td>
                                                      
                                                      {{$stock_transaction->order_id}}
                                                        </td>
                                                        <td>                                                      
                                                        - 
                                                        </td>
                                                        <td>                                                      
                                                        {{$stock_transaction->quantity}}
                                                      </td>
                                                      @endif  
                                                        <td>
                                                        {{$stock_transaction->stock_balance}}
                                                        </td>
                                                        <td>
                                                        {{$stock_transaction->createdBy()->name ?? "N/A"}}
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
      
     