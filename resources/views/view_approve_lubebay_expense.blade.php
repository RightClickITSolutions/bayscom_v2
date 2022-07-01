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
                                <p class="caption mb-0">LubeBay Expenses</p>
                            </div>
                        </div>
                        <!-- DataTables example -->
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div id="button-trigger" class="card card card-default scrollspy">
                                    <div class="card-content">
                                        <h4 class="card-title"> Expenses</h4>
                                        <div class="row">
                                            
                                            <div class="col s12">
                                                <table id="data-table-simple" class="display">
                                                
                                                    <thead >
                                                        <th>
                                                        Reques id
                                                        </th>
                                                        <th>
                                                        Requested By
                                                        </th>
                                                        <th>
                                                        Name 
                                                        </th>
                                                        <th>
                                                        Expense Type
                                                        </th>
                                                        <th>
                                                        Amount
                                                        </th>
                                                        <th>
                                                        Location
                                                        </th>
                                                        <th>
                                                        date Requested
                                                        </th>
                                                        
                                                        <th>
                                                        Approval
                                                        </th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($expense_list as $expense)
                                                        <tr>
                                                        <td>
                                                            {{$expense->id}}
                                                        </td>
                                                        
                                                        <td>
                                                        {{$expense->createdBy->name}}
                                                        </td>
                                                        <td>
                                                        {{$expense->name}}
                                                        </td>
                                                        <td>
                                                        {{$expense->expense_type}}
                                                        </td>
                                                        <td>
                                                        {{$expense->amount}}
                                                        
                                                        </td>
                                                        <td>
                                                        {{$expense->lubebay->name}}
                                                        
                                                        </td>
                                                        <td>
                                                        {{$expense->created_at}}
                                                        </td>
                                                        <td>
                                                        @if($expense->approval->l1!=0)
                                                                {{$expense->approvedBy('l1')}}
                                                            
                                                            @else
                                                                @include('includes.approve_form',['action'=>'lubebay/approve-expense','process_id'=>$expense->id,'process_type'=>'LUBEBAY_EXPENSE','level'=>'l1'])
                                                                <br>
                                                                @include('includes.decline_form',['action'=>'lubebay/approve-expense','process_id'=>$expense->id,'process_type'=>'LUBEBAY_EXPENSE','level'=>'l1'])
                                                                
                                                            
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
      
   