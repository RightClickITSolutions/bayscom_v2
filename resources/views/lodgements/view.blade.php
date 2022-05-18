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
       @if (session()->has('status'))
          <script type="application/javascript">
              Swal.fire({
                  icon: 'success',
                  // title: 'Oops...',
                  text: 'Lodgement Reverse successfully.',
                  // footer: '<a href="">Why do I have this issue?</a>'
              })
          </script>
      @endif
      @if (session()->has('status_error'))
            <script type="application/javascript">
                Swal.fire({
                    icon: 'error',
                    // title: 'Oops...',
                    text: 'Error while reversing lodgement.',
                    // footer: '<a href="">Why do I have this issue?</a>'
                })
            </script>
      @endif
      <div class="col s12">
                <div class="container">
                    <div class="section section-data-tables">
                        <div class="card">
                            <div class="card-content">
                                <p class="caption mb-0">Customer Lodgements</p>
                            </div>
                        </div>
                        <!-- DataTables example -->
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div id="button-trigger" class="card card card-default scrollspy">
                                    <div class="card-content">
                                        <h4 class="card-title">Customer lodgemnts </h4>
                                        <div class="row">
                                        <div class="col s12 pull-right">
                                            </div>
                                            <div class="col s12">
                                                <table id="data-table-simple" class="display">
                                                  <thead class="">
                                                    <th>
                                                      ID
                                                    </th>
                                                    <th>
                                                      Customer
                                                    </th>
                                                  
                                                    
                                                    <th>
                                                      Total Lodged
                                                    </th>
                                                   
                                                    <th>
                                                      Date
                                                    </th>
                                                    <th>
                                                      Lodged By
                                                    </th>
                                                    <th>
                                                      Teller No/Bank ref
                                                    </th>
                                                    @can('approve_lodgement_l1')
                                                        <td>
                                                          Confirm
                                                        </td>
                                                      @endcan
                                                      <td>
                                                        Status
                                                      </td>
                                                                                                     
                                                    <th>
                                                      Action
                                                    </th>
                                                  </thead>
                                                  <tbody>
                                                      @foreach($customer_payment_transactions as $lodgment)
                                                    <tr>
                                                    <td>
                                                    {{$lodgment->id}}
                                                    </td>
                                                      <td>
                                                        {{$lodgment->customer->name}}
                                                      </td>
                                                      
                                                      
                                                      <td>
                                                      {{number_format($lodgment->amount,2)}}
                                                      </td>
                                                      
                                                      
                                                      <td>
                                                      {{$lodgment->created_at}}
                                                      </td>
                                                      <td>
                                                      {{$lodgment->lodgedBy->name}}
                                                      </td>
                                                      <td>
                                                      {{$lodgment->reference_number}}
                                                      </td>
                                                      @can('approve_lodgement_l1')
                                                        <td>
                                                            
                                                            @if($lodgment->approval !=null && $lodgment->approval->l1!=0)
                                                                {{$lodgment->approvedBy('l1')}}
                                                            @elseif($lodgment->approval ==null )
                                                                {{$lodgment->approvedBy('l1')?? "-" }}
                                                            @else
                                                                @include('includes.approve_form',['action'=>'/approve-customer-lodgement','process_id'=>$lodgment->id,'process_type'=>'CUSTOMER_LODGEMENT','level'=>'l1','button_label'=>'Confirm'])
                                                                <br>
                                                                @include('includes.decline_form',['action'=>'/approve-customer-lodgement','process_id'=>$lodgment->id,'process_type'=>'CUSTOMER_LODGEMENT','level'=>'l1'])
                                                                
                                                            
                                                            @endif
                                                        
                                                        </td>
                                                      @endcan
                                                      <td>
                                                        {{$lodgment->approval_status}}
                                                      </td>
                                                      
                                                     @if ($lodgment->approval_status == 'CONFIRMED')
                                                         <td>
                                                           <a href="{{ url('customer/lodgement/reversal/' .$lodgment->id) }}">
                                                            Reverse Lodgement
                                                          </a>
                                                         </td>
                                                     @endif
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
      
     