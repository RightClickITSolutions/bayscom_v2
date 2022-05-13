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
                                <p class="caption mb-0">{{$account->account_name}} Transactions</p>
                            </div>
                        </div>
                        <!-- DataTables example -->
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div id="button-trigger" class="card card card-default scrollspy">
                                    <div class="card-content">
                                        <h4 class="card-title"><span class=" green-text">Balance: ₦ {{number_format($account->balance,2)}}</span> | <span class=" brown-text ">Book Balance: ₦{{number_format(($account->balance + $unrecieved_products_total),2)}}</span> | <a href="{{url('sage/unrecieved-products')}}"><span class="red-text ">  Unrecieved products: ₦{{number_format($unrecieved_products_total,2)}} </span> </a></h4>
                                        <div class="row">
                                            <div class="col s12 pull-right">
                                            <a href="{{url('/accounts/account/post-account-transaction/'.$account->id)}}" class="btn cyan waves-effect waves-light green darken-1 right"> DEBIT/CREDIT Account</a>
                                            </div>
                                            <div class="col s12">
                                                <table id="data-table-simple" class="display">
                                            <thead>
                                                    <th>
                                                      ID
                                                    </th>
                                                  
                                                    <th>
                                                      Debit
                                                    </th>
                                                    <th>
                                                      Credit
                                                    </th>
                                                                                                     
                                                    <th>
                                                      Balance
                                                    </th>
                                                    <th>
                                                      Date
                                                    </th>
                                                  </thead>
                                                  <tbody>
                                                      @foreach($account->transactions as $transaction)
                                                    <tr>
                                                      <td>
                                                        {{$transaction->id}}
                                                      </td>
                                                      
                                                      <td>
                                                      @if($transaction->transaction_type=='DEBIT')
                                                        {{number_format($transaction->amount,2)}}
                                                      @else
                                                      -
                                                      @endif
                                                      
                                                      </td>
                                                      <td>
                                                      @if($transaction->transaction_type=='CREDIT')
                                                        {{number_format($transaction->amount,2)}}
                                                      @else
                                                      -
                                                      @endif
                                                      </td>
                                                      
                                                      <td>
                                                      {{number_format($transaction->balance,2)}}
                                                      </td>
                                                      <td>
                                                          {{$transaction->created_at}}
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
      
     
   
     
   