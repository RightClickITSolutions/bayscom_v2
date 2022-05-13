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
                                            <div class="col s8 pull-right">
                                              <a href="{{url('/lubebay/lodgement/'.$lubebay->id)}}" class="btn cyan waves-effect waves-light green darken-1 right"> New payment/lodgement</a>
                                            </div>
                                            
                                            <div class="col s4 pull-right">
                                              <a href="{{url('/lubebay/lodgement/confirmation/'.$lubebay->id)}}" class="btn cyan waves-effect waves-light blue darken-1 right">View/Confirm lodgement</a>
                                            </div>
                                            

                                            <div class="col s12">
                                                <table id="data-table-simple" class="display">
                                                  <thead class="">
                                                    <th>
                                                     Date
                                                    </th>
                                                    <th>
                                                      services
                                                    </th>
                                                  
                                                    <th>
                                                     Lodgement
                                                    </th>
                                                    <th>
                                                      Underlodgment
                                                    </th>
                                                   
                                                                                                                                                        
                                                    
                                                  </thead>
                                                  <tbody>
                                                      @foreach($sales_lodgement_history as $sales_lodgment)
                                                    <tr>
                                                    <td>
                                                    {{$sales_lodgment->date}}
                                                    </td>
                                                      
                                                      
                                                      <td>
                                                      {{number_format($sales_lodgment->sales,2)}}
                                                      </td>
                                                      <td>
                                                      {{number_format($sales_lodgment->lodgement,2)}}
                                                      </td>
                                                      
                                                      <td>
                                                      {{number_format( -1*$sales_lodgment->underlodgement )}}
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
      
     