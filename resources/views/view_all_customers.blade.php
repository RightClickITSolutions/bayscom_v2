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
                                <p class="caption mb-0">List Of all customers</p>
                            </div>
                        </div>
                        <!-- DataTables example -->
                        <div class="row">
                            <div class="col s12 m12 l12">
                               @if (session()->has('status'))
                                  <script type="application/javascript">
                                      Swal.fire({
                                          icon: 'success',
                                          // title: 'Oops...',
                                          text: 'Customer Edited',
                                          // footer: '<a href="">Why do I have this issue?</a>'
                                      })
                                  </script>
                              @endif
                               @if (session()->has('status-balance'))
                                    <script type="application/javascript">
                                        Swal.fire({
                                            icon: 'success',
                                            // title: 'Oops...',
                                            text: 'Balance has been changed',
                                            // footer: '<a href="">Why do I have this issue?</a>'
                                        })
                                    </script>
                                @endif
                                <div id="button-trigger" class="card card card-default scrollspy">
                                    <div class="card-content">
                                        <h4 class="card-title">Customers</h4>
                                        <div class="row">
                                            
                                            <div class="col s12">
                                                <table id="data-table-simple" class="display">
                                            <thead>
                                                    <th>
                                                      ID
                                                    </th>
                                                  
                                                    <th>
                                                      Customer Name
                                                    </th>
                                                    <th>
                                                      Customer Type
                                                    </th>
                                                    <th>
                                                      State
                                                    </th>
                                                    
                                                    <th>
                                                      Balance
                                                    </th>
                                                    <th>
                                                    view orders
                                                    </th>
                                                    <th>
                                                      Transactions
                                                    </th>
                                                    
                                                    <th>
                                                      Status
                                                    </th>
                                                    <th>
                                                      Actions 
                                                    </th>
                                                  </thead>
                                                  <tbody>
                                                      @foreach($customers as $customer)
                                                    <tr>
                                                      <td>
                                                        <a href="{{url('/customer/'.$customer->id)}}">{{$customer->id}}</a>
                                                      </td>
                                                      
                                                      <td>
                                                      {{ucwords($customer->name)}}
                                                      </td>
                                                      <td>
                                                      {{$customer->customerType->name}}
                                                      </td>
                                                      
                                                      <td>
                                                      {{$customer->state()->name }}
                                                      </td>
                                                     
                                                      <td>
                                                      {{number_format($customer->balance,2)}}
                                                      {{-- <a class="btn-edit" href="{{url('customer/edit/balance/'.$customer->id)}}"><i class="fa fa-edit"></i></a> --}}
                                                      </td>
                                                      
                                                      <td>
                                                      <a href="{{url('/customer/orders/'.$customer->id)}}">View orders</a>
                                                      </td>

                                                      <td>
                                                      <a href="{{url('/customer/transactions/'.$customer->id)}}">View Transctions</a>
                                                      </td>
                                                      
                                                      <td>
                                                          @if($customer->trashed())
                                                          Disabled
                                                          @else
                                                          Active
                                                          @endif
                                                      </td>
                                                      <td class="action-btn-row">
                                                         <a class="btn-edit" href="{{url('customer/edit/'.$customer->id)}}"><i class="fa fa-edit"></i></a>
                                                          <a class="btn-delete" href="{{url('customer/delete/'.$customer->id)}}"><i class="fa fa-times"></i></a>
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
      
     
   
     
   