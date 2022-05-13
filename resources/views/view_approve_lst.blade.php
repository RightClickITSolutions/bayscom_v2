@extends('layouts.mofad')
@section('head') 
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
                                <p class="caption mb-0">LubeBay Services</p>
                            </div>
                        </div>
                        <!-- DataTables example -->
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div id="button-trigger" class="card card card-default scrollspy">
                                    <div class="card-content">
                                        <h4 class="card-title">LubeBay Service</h4>
                                        <div class="row">
                                            
                                            <div class="col s12">
                                                <table id="data-table-simple" class="display">
                                                  <thead >
                                                  <th>
                                                  LST ID
                                                  </th>
                                                
                                                 
                                                  <th>
                                                  Total amount
                                                  </th>

                                                  <th>
                                                    Lubebay 
                                                  </th>

                                                  <th>
                                                    Lubebay admin
                                                  </th>
                                                  <th>
                                                    date posted
                                                  </th>
                                                  
                                                  <th>
                                                    Confiramtion
                                                  </th>
                                                </thead>
                                                <tbody>
                                                    @foreach($lst_list as $lst)
                                                  <tr>
                                                    <td>
                                                      <a href="{{url('lst/view-details/'.$lst->id)}}">{{$lst->id}}</a>
                                                    </td>
                                                    
                                                   
                                                    <td>
                                                    ₦ {{number_format($lst->total_amount,2)}}
                                                    </td>
                                                    <td>
                                                    {{$lst->lubebay->name}}
                                                    </td>
                                                    <td>
                                                    {{$lst->createdBy->name}}
                                                    </td>
                                                    <td>
                                                    {{$lst->updated_at}}
                                                    </td>
                                                    <td>
                                                    @if($lst->approval->l1!=0)
                                                          {{$lst->approvedBy('l1')}}
                                                        
                                                        @else
                                                          @include('includes.approve_form',['action'=>'/approve-lst','process_id'=>$lst->id,'process_type'=>'LST','level'=>'l1'])
                                                          <br>
                                                          @include('includes.decline_form',['action'=>'/approve-lst','process_id'=>$lst->id,'process_type'=>'LST','level'=>'l1'])
                                                          
                                                        
                                                        @endif
                                                          
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
      
   