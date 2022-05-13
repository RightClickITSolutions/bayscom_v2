@extends('layouts.mofad')

@section('head')
    @parent()
    
   <!-- BEGIN: VENDOR CSS-->
   <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/flag-icon/css/flag-icon.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/data-tables/css/select.dataTables.min.css')}}">
    <!-- END: VENDOR CSS-->
@endsection()

@section('side_nav')
@parent()
@endsection

@section('top_nav')
    @parent()
@endsection

@section('content')
<div class="col s12">
                <div class="container">
                    <div class="section section-data-tables">
                        <div class="card">
                            <div class="card-content">
                                <p class="caption mb-0">List Of System Users customers</p>
                            </div>
                        </div>
                        <!-- DataTables example -->
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div id="button-trigger" class="card card card-default scrollspy">
                                    <div class="card-content">
                                        <h4 class="card-title">Users</h4>
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
                                                      Email
                                                    </th>
                                                                                                       
                                                    <th>
                                                      Role(s)
                                                    </th>
                                                    
                                                    <th>
                                                      Date Created
                                                    </th>
                                                    <th>
                                                    Edit
                                                    </th>

                                                    <th>
                                                    Delete
                                                    </th>
                                                    <th>
                                                    Status
                                                    </th>

                                                  </thead>
                                                  <tbody>
                                                      @foreach($users_list as $user)
                                                    <tr>
                                                      <td>
                                                        <a href="{{url('/admin/users/edit-user-accesses/'.$user->id)}}">{{$user->id}}</a>
                                                      </td>
                                                      
                                                      <td>
                                                      {{$user->name}}
                                                      </td>
                                                      <td>
                                                      {{$user->email}}
                                                      </td>
                                                      
                                                      <td>
                                                      @foreach($user->getRoleNames() as $role )
                                                        {{$role}},
                                                      @endforeach
                                                      </td>
                                                     
                                                      <td>
                                                      {{$user->created_at}}
                                                      </td>
                                                      <td>
                                                      <a class=" btn green darken-1" href="{{url('/admin/users/edit-user/'.$user->id)}}">Edit User</a>
                                                      </td>
                                                      <td>
                                                      <a class=" btn red darken-1" href="{{url('admin/users/delete-user/'.$user->id)}}">Delete User</a>
                                                      </td>
                                                      
                                                                                                           
                                                      <td>
                                                          @if($user->trashed())
                                                          Disabled
                                                          @else
                                                          Active
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
    