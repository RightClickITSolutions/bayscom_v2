@extends('layouts.mofad')

@section('head')
    @parent()
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/cards-basic.css')}}">
@endsection()

@section('side_nav')
@parent()
@endsection

@section('top_nav')
    @parent()
@endsection

@section('content')


                    <div class="row">
                       <div class="col s12 m12 l12">
                            <div class="card ">
                                <div class="card-content ">
                                    <h4 class="header">Lubebays(s)</h4>
                                    <p>Lubebays(s)</p>
                                </div>
                            </div>
                        <div>
                    </div>

                    
                        
                        <div class="row">
                            @foreach($lubebays_list as $lubebay)
                            <div class="col s12 m6 l6">
                                <div class="card horizontal">
                                    <div class="card-image"><img src="{{asset('assets/img/lubebay-image-1.jpg')}}" alt="" /></div>
                                    <div class="card-stacked">
                                        <div class="card-content">
                                            <h5>Stations: {{$lubebay->name}} </h5>
                                            
                                        </div>
                                        <div class="card-action">
                                            <a href="{{url('lubebay/lodgement-history/'.$lubebay->id)}}" class="waves-effect waves-light btn orange darken-4">Lodgements</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>    
                   
        
@endsection

@section('footer')
@parent()
@endsection

@section('footer_scripts')
@parent()
@endsection
    