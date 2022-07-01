@extends('layouts.mofad')
@section('head')
    <!-- BEGIN: VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/flag-icon/css/flag-icon.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/vendors/data-tables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('app-assets/vendors/data-tables/css/select.dataTables.min.css') }}">
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
                        <p class="caption mb-0">Transactions by </p>
                    </div>
                </div>
                <!-- DataTables example -->
                <div class="row">
                    <div class="col s12 m12 l12">
                        <div id="button-trigger" class="card card card-default scrollspy">
                            <div class="card-content">
                                <h4 class="card-title">Transactions</h4>
                                <div class="row">
                                    <div class="col s12 pull-right">
                                        <a href="#"
                                            class="btn cyan waves-effect waves-light green darken-1 right"> Add new customer
                                            payment/lodgement</a>
                                    </div>
                                    <div class="col s12">
                                        <table class="table table-bordered data-table">

                                            <thead>
                    
                                                <tr>
                    
                                                    <th>No</th>
                    
                                                    <th>Title</th>
                    
                                                    <th>Auther</th>
                    
                                                </tr>
                    
                                            </thead>
                    
                                            <tbody>
                    
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
        <script src="{{ asset('app-assets/vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}">
        </script>
        <script src="{{ asset('app-assets/vendors/data-tables/js/dataTables.select.min.js') }}"></script>
        <!-- END PAGE VENDOR JS-->


        <!-- BEGIN PAGE LEVEL JS-->
        <!-- <script src="{{ asset('app-assets/js/scripts/data-tables.js') }}"></script> -->

        <script type="text/javascript">

            $(document).ready(function() {
         
                 $('.data-table').DataTable({
         
                     processing: true,
         
                     serverSide: true,
         
                     ajax: "{{ url('/customer/transactions/23') }}",
         
                     columns: [
         
                         {data: 'id', name: 'id'},
         
                         {data: 'amount', name: 'amount'},
         

         
                     ]
         
                 });
         
             });
         
         </script>
         
    @endsection
