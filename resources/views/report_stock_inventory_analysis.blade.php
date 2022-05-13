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


    <div class="col s12 m12 l12">
        <div class="card ">
            <div class="card-content ">
            <br><br><br><br>
                <h4 class="header">MOFAD STOCK INVENORY ANALYSIS</h4>
                <p> <a href="{{url('reports/sia/download')}}" class="waves-effect waves-light btn  green darken-4">Download</a>
            </div>
        </div>
    <div>


                    
                        
                          
                   
        
@endsection

@section('footer')
@parent()
@endsection

@section('footer_scripts')
@parent()
@endsection
    