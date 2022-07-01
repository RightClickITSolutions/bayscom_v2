@extends('layouts.mofad')

@section('head')
    @parent()
@endsection()

@section('side_nav')
    @parent()
@endsection

@section('top_nav')
    @parent()
@endsection

@section('content')
    @include('includes.post_status')

    <!-- STI -->
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card ">
                <div class="card-content ">
                    <h4 class="header">MOFAD CUSTOMERS REPORTS</h4>
                </div>
            </div>

            <div class="card ">
                <div class="card-content ">

                    {!! $dataTable->table() !!}
                </div>
            </div>


        </div>
        <div>
        </div>
    @endsection

    @section('footer')
        @parent()
    @endsection

    @section('footer_scripts')
        @parent()

        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
        <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
        <script src="/vendor/datatables/buttons.server-side.js"></script>
        {!! $dataTable->scripts() !!}

    @endsection
