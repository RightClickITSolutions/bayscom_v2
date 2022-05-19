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
                                <p class="caption mb-0">List Of all Warehouses</p>
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
                                        <h4 class="card-title">Warehouses</h4>
                                        <div class="row">
                                            
                                            <div class="col s12">
                                                <table id="data-table-simple" class="display">
                                            <thead>
                                                    <th>
                                                      ID
                                                    </th>
                                                  
                                                    <th>
                                                       Name
                                                    </th>
                                                    <th>
                                                      State
                                                    </th>
                                                    
                                                    <th>
                                                      Actions 
                                                    </th>
                                                  </thead>
                                                  <tbody>
                                                    @foreach ($warehouse_list as $item)
                                                        <tr>
                                                        <td>{{ $item->id }}</td>
                                                        <td>{{ $item->name }}</td>
                                                        @if ($item->state == 1)
                                                            <td>Abuja</td>
                                                        @endif
                                                        @if ($item->state == 2)
                                                            <td>Kano</td>
                                                        @endif
                                                        <td class="action-btn-row">
                                                            <a class="btn-edit" href="{{url('admin/retail-outlet/edit/'.$item->id)}}"><i class="fa fa-edit"></i></a>
                                                            <a class="btn-delete" href="{{url('admin/retail-outlet/delete/'.$item->id)}}"><i class="fa fa-times"></i></a>
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
      
     
   
     
   