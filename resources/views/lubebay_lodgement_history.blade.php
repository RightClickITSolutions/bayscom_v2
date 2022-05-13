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
                                <p class="caption mb-0">{{$lubebay->name}} lodgement History</p>
                            </div>
                        </div>
                        <!-- DataTables example -->
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div id="button-trigger" class="card card card-default scrollspy">
                                    <div class="card-content">
                                        <h4 class="card-title">Lubebay service lodgements </h4>
                                        <div class="row">
                                        <div class="col s12 pull-right">
                                            <a href="{{url('/lubebay/lodgement/'.$lubebay->id)}}" class="btn cyan waves-effect waves-light green darken-1 right"> New payment/lodgement</a>
                                            </div>
                                            <div class="col s12">
                                                <table id="data-table-simple" class="display">
                                                  <thead class="">
                                                    <th>
                                                      ID
                                                    </th>
                                                    <th>
                                                      Asociated sales
                                                    </th>
                                                  
                                                    <th>
                                                      Total Value
                                                    </th>
                                                    <th>
                                                      Total Lodged
                                                    </th>
                                                   
                                                    <th>
                                                      Total under Lodgement
                                                    </th>
                                                    <th>
                                                      Date
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
                                                                                                     
                                                    
                                                  </thead>
                                                  <tbody>
                                                      @foreach($lubebay->lodgements() as $lodgment)
                                                    <tr>
                                                    <td>
                                                    {{$lodgment->id}}
                                                    </td>
                                                      <td>
                                                        @if( $lodgment->related_lst_sales!=null)
                                                            @foreach($lodgment->related_lst_sales as $sale)
                                                            <a href="{{url('lst/view-details/'.$sale->id)}}">{{$sale->id}}</a>
                                                            @endforeach
                                                        @endif
                                                      </td>
                                                      
                                                      <td>
                                                      {{number_format($lodgment->lst_lodgment_expected_value())}}
                                                      </td>
                                                      <td>
                                                      {{number_format($lodgment->amount,2)}}
                                                      </td>
                                                      
                                                      <td>
                                                      {{number_format( $lubebay->total_lodgements($start_time=null,$end_time=$lodgment->created_at) - $lubebay->total_sales($start_time=null,$end_time=$lodgment->created_at) )}}
                                                      </td>
                                                      <td>
                                                      {{$lodgment->created_at}}
                                                      </td>
                                                      <td>
                                                      {{$lodgment->bank_reference}}
                                                      </td>
                                                      @can('approve_lodgement_l1')
                                                        <td>
                                                            
                                                            @if($lodgment->approval->l1!=0)
                                                                {{$lodgment->approvedBy('l1')}}
                                                            @else
                                                                @include('includes.approve_form',['action'=>'/approve-lubebay-lodgement','process_id'=>$lodgment->id,'process_type'=>'ACCOUNT_TRANSACTION','level'=>'l1','button_label'=>'Confirm'])
                                                                <br>
                                                                @include('includes.decline_form',['action'=>'/approve-lubebay-lodgement','process_id'=>$lodgment->id,'process_type'=>'ACCOUNT_TRANSACTION','level'=>'l1'])
                                                                
                                                            
                                                            @endif
                                                        
                                                        </td>
                                                      @endcan
                                                      <td>
                                                        {{$lodgment->approval_status}}
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
      
     