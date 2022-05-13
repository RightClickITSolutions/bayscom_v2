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

<div class="col s12">
    <div class="container">
        <div class="section section-data-tables">
            <!-- <div class="card">
                <div class="card-content">
                    <p class="caption mb-0">Lubebay List</p>
                </div>
            </div> -->
            <!-- DataTables example -->
            <div class="row">
                <div class="col s12 m12 l12">
                    <div id="button-trigger" class="card card card-default scrollspy">
                        <div class="card-content">
                            <h4 class="card-title"></h4>
                            <div class="row">
                                
                                <div class="col s12">
                                    <table id="data-table-simple" class="display">
                                
                                        <tbody>
                                            @foreach($lubebay_list as $lubebay)
                                        <tr>
                                            <td>
                                            <a href="{{url('/reports/lubebay/income-statement/'.$lubebay->id)}}">{{$lubebay->name}}</a>
                                            
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
@endsection
    