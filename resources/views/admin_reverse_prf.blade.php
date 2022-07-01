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
                                <p class="caption mb-0">List of PRfs Raised</p>
                            </div>
                        </div>
                        <!-- DataTables example -->
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div id="button-trigger" class="card card card-default scrollspy">
                                    <div class="card-content">
                                        <h4 class="card-title">PRFs</h4>
                                        <div class="row">
                                            
                                            <div class="col s12">
                                                <table id="data-table-simple" class="display">
                                            <thead>
                                                    <th>
                                                      ID
                                                    </th>
                                                  
                                                    <th>
                                                      Total Value
                                                    </th>
                                                    <th>
                                                      Customer
                                                    </th>
                                                   
                                                    <!-- <th>
                                                      Expected Payment Date
                                                    </th> -->
                                                    <th>
                                                      Created by
                                                    </th>
                                                    <th>
                                                      Date
                                                    </th>
                                                   
                                                    <th>
                                                      Status
                                                    </th>
                                                  </thead>
                                                  <tbody>
                                                      @foreach($prf_list as $prf)
                                                    <tr>
                                                      <td>
                                                        <a href="{{url('/prf/invoice/'.$prf->id)}}">{{$prf->id}}</a>
                                                      </td>
                                                      
                                                      <td>
                                                      {{number_format($prf->order_total,2)}}
                                                      </td>
                                                      <td>
                                                      {{$prf->customer->name?? 'N/A'}}
                                                      </td>
                                                                                                          
                                                      <td>
                                                      {{$prf->createdBy->name}}
                                                      </td>
                                                      <td>
                                                      {{$prf->created_at}}
                                                      </td>
                                                     
                                                      @if(!$prf->reversed())
                                                      <td>
                                                            <a href="{{url('admin/prf/reversal/'.$prf->id)}}">Reverse </a>
                                                      </td>
                                                      @else
                                                      <td>
                                                            This PRF has been revered
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
      
     
   
     
   