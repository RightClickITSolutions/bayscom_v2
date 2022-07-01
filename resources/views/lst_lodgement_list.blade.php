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
                                <p class="caption mb-0">{{$lubebay->name}}Lubebay lodgement History</p>
                            </div>
                        </div>
                        <!-- DataTables example -->
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div id="button-trigger" class="card card card-default scrollspy">
                                    <div class="card-content">
                                        <h4 class="card-title">Lubebay service revenue posts </h4>
                                        <div class="row">
                                            
                                            <div class="col s12">
                                                <table id="data-table-simple" class="display">
                                                  <thead class="">
                                                    <th>
                                                      ID
                                                    </th>
                                                  
                                                    <th>
                                                      Total Value
                                                    </th>
                                                    <th>
                                                      Total Lodged
                                                    </th>
                                                    <th>
                                                      Under Lodgement
                                                    </th>
                                                    <th>
                                                      Date
                                                    </th>
                                                    <th>
                                                      Lodge payment
                                                    </th>
                                                  
                                                    
                                                  </thead>
                                                  <tbody>
                                                      @foreach($lst_list as $lst)
                                                    <tr>
                                                      <td>
                                                        {{$lst->id}}
                                                      </td>
                                                      
                                                      <td>
                                                      {{number_format($lst->total_amount,2)}}
                                                      </td>
                                                      <td>
                                                      {{number_format($lst->totallodgments())}}
                                                      </td>
                                                      <td>
                                                      {{number_format($lst->totalUnderlodgments())}}
                                                      </td>
                                                      <td>
                                                      {{$lst->created_at}}
                                                      </td>
                                                      <td>
                                                      <a class="btn btn-success green darken-1" href="{{url('/lubebay/services-lodgement/'.$lst->id)}}">Lodge Payment</a>
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
      
     