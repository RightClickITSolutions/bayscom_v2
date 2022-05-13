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
                                <p class="caption mb-0">{{$substore->name}} {{$product->name()}} Bin Card</p>
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
                                                      @foreach($substore_stock_transactions as $substore_stock_transaction)
                                                    <tr>
                                                    <td>
                                                    {{$substore_stock_transaction->id}}
                                                    </td>
                                                      <td>
                                                      {{$substore_stock_transaction->created_at}}
                                                      </td>
                                                      @if($substore_stock_transaction->transaction_id == 'INV-ADJ' && $substore_stock_transaction->transaction_type == 'CREDIT')
                                                        <td>                                                      
                                                        Inventory Adjustment
                                                        </td>
                                                        <td>
                                                      <a href="#">{{$substore_stock_transaction->transaction_id}}</a>
                                                      
                                                      </td>
                                                      @elseif($substore_stock_transaction->transaction_type == 'CREDIT' &&  substr($substore_stock_transaction->transaction_id, 0,7) == 'SST_REV' )
                                                        <td>                                                      
                                                        Sales entry reversal
                                                        </td>
                                                        <td>
                                                      <a href="{{url('/sst/view-details/'.$substore_stock_transaction->transaction_id)}}">{{$substore_stock_transaction->transaction_id}}</a>
                                                      
                                                      </td>
                                                      @elseif($substore_stock_transaction->transaction_type == 'CREDIT' )
                                                        <td>                                                      
                                                        Warehouse supply
                                                        </td>
                                                        <td>
                                                      <a href="{{url('prf/view-details/'.$substore_stock_transaction->transaction_id)}}">{{$substore_stock_transaction->transaction_id}}</a>
                                                      
                                                      </td>
                                                      @elseif($substore_stock_transaction->transaction_id == 'INV-ADJ' && $substore_stock_transaction->transaction_type == 'DEBIT')
                                                        
                                                        <td>                                                      
                                                        Inventory Adjustment
                                                        </td>
                                                        <td>
                                                      <a href="#">{{$substore_stock_transaction->transaction_id}}</a>
                                                      
                                                      </td>
                                                      @elseif($substore_stock_transaction->transaction_type == 'DEBIT')
                                                        
                                                        <td>                                                      
                                                        Sales
                                                        </td>
                                                        <td>
                                                      <a href="{{url('sst/view-details/'.$substore_stock_transaction->transaction_id)}}">{{$substore_stock_transaction->transaction_id}}</a>
                                                      
                                                      </td>
                                                       
                                                      @else($substore_stock_transaction->transaction_type == 'DEBIT')
                                                        
                                                        <td>                                                      
                                                        N/A
                                                        </td>
                                                        <td>
                                                      <a href="{{url('sst/view-details/'.$substore_stock_transaction->transaction_id)}}">{{$substore_stock_transaction->transaction_id}}</a>
                                                      
                                                      </td>
                                                      @endif 
                                                      
                                                      
                                                      @if($substore_stock_transaction->transaction_type == 'CREDIT')
                                                        <td>                                                      
                                                        {{$substore_stock_transaction->quantity}}
                                                        </td>
                                                        <td>                                                      
                                                        - 
                                                        </td>
                                                      @endif
                                                      @if($substore_stock_transaction->transaction_type == 'DEBIT')
                                                        <td>                                                      
                                                        - 
                                                        </td>
                                                        <td>                                                      
                                                        {{$substore_stock_transaction->quantity}}
                                                        </td>
                                                      @endif  
                                                        <td>
                                                        {{$substore_stock_transaction->stock_balance}}
                                                        </td>
                                                        <td>
                                                        {{$substore_stock_transaction->createdBy() ?? 'N/A'}}
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
      
     