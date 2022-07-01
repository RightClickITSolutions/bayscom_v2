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

@if(isset($stations_list))
                    <div class="row">
                       <div class="col s12 m12 l12">
                            <div class="card ">
                                <div class="card-content ">
                                    <h4 class="header">Station(s)</h4>
                                    <p>Stations(s)</p>
                                </div>
                            </div>
                        <div>
                    </div>

                    
                        
                        <div class="row">
                            @foreach($tation_substore_list as $substore)
                            <div class="col s12 m6 l6">
                                <div class="card horizontal">
                                    <div class="card-image"><img src="{{asset('assets/img/lubricant-image-1.jpg')}}" alt="" /></div>
                                    <div class="card-stacked">
                                        <div class="card-content">
                                            <h5>Stations/Store name </h5>
                                            
                                        </div>
                                        <div class="card-action">
                                            <a href="{{url('substore/lodgements-history/'.$substore->id)}}" class="waves-effect waves-light btn red darken-4">Lodgements</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>    
                    @endif
        
@endsection

@section('footer')
@parent()
@endsection

@section('footer_scripts')
@parent()
@endsection
    