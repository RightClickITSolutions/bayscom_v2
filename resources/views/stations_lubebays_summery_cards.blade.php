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
                        @foreach($stations_list as $station)
                            <div class="col s12 m6 l6">
                                <div class="card horizontal">
                                    <div class="card-image"><img src="{{asset('assets/img/lubricant-image-1.jpg')}}" alt="" /></div>
                                    <div class="card-stacked">
                                        <div class="card-content">
                                        <h5>{{ucwords($station->name)}}</h5>
                                        <div class="divider mt-2"></div>
                                            <table class="table table-condensed table-striped conde">
                                                
                                                    <tr>
                                                        <td>Total sales</td>: <td>{{number_format($station->total_sales(),2)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Lodged</td>: <td>{{number_format($station->total_lodgements(),2)}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Unlodged </td>: <td>{{number_format($station->total_lodgements()-$station->total_sales(),2)}}</td>
                                                    </tr>
                                                
                                            </table>
                                        </div>
                                        <div class="card-action">
                                            <a href="{{url('/dashboard/substore/'.$station->id)}}" class="waves-effect waves-light btn orange darken-4">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>    
                    @endif

                    @if(isset($lubebays_list))
                    <div class="row">
                       <div class="col s12 m12 l12">
                            <div class="card ">
                                <div class="card-content ">
                                    <h4 class="header">LubeBays</h4>
                                    <p>Lubebays</p>
                                </div>
                            </div>
                        <div>
                    </div>

                    
                        
                        <div class="row">
                            <!-- <div class="col s12 m6 l6">
                                <div class="card horizontal">
                                    <div class="card-image"><img src="{{asset('assets/img/lubricant-image-1.jpg')}}" alt="" /></div>
                                    <div class="card-stacked">
                                        <div class="card-content">
                                            <h5>Stations/Store name </h5>
                                            <div class="divider mt-2"></div>
                                            <table class="table table-condensed table-striped conde">
                                                
                                                    <tr>
                                                        <td>Total units sold</td>: <td>200</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total value</td>: <td>200</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Lodged</td>: <td>200</td>
                                                    </tr>
                                                
                                            </table>
                                        </div>
                                        <div class="card-action">
                                            <a href="#!" class="waves-effect waves-light btn red darken-4">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            @foreach($lubebays_list as $lubebay)
                            <div class="col s12 m6 l6">
                                <div class="card horizontal">
                                    <div class="card-image"><img src="{{asset('assets/img/service-image-3.jpg')}}" alt="" /></div>
                                    <div class="card-stacked">
                                        <div class="card-content">
                                            <h5>{{ucwords($lubebay->name)}}</h5>
                                            <div class= "divider mt-2"></div>

                                                <table class="table table-condensed table-striped conde">
                                                        <th colspan="2">Lubebay<br>Services </th><th colspan="2">Lubebay Products </th>
                                                        <tr>
                                                            <td>Total sales</td>: <td>{{number_format($lubebay->total_sales())}}</td>  
                                                            <td>Total sales</td>: <td>{{number_format($lubebay->substore->total_sales(),2)}}</td> 
                                                        </tr>
                                                        <tr>
                                                            <td>Expenses</td>: <td>{{number_format($lubebay->total_expense())}}</td>
                                                            <td></td><td></td>
                                                        </tr>
                                                        <tr>
                                                            <td> Lodged</td>: <td>{{number_format($lubebay->total_lodgements())}}</td>
                                                            <td>Total Lodged</td>: <td>{{number_format($lubebay->substore->total_lodgements(),2)}}</td>
                                                        </tr>
                                                    
                                                </table>
                                                
                                            </div>
                                            <div class="card-action">
                                                <a href="{{url('/dashboard/lubebay/'.$lubebay->id)}}" class="waves-effect waves-light btn orange darken-4">View Details</a>
                                            </div>
                                        
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                        </div>
                   
                    @endif

                    @if(isset($lubebays_and_substores_list))
                    <div class="row">
                            <div class="col s12 m6 l6">
                                <div class="card horizontal">
                                    <div class="card-image"><img src="{{asset('assets/img/lubricant-image-1.jpg')}}" alt="" /></div>
                                    <div class="card-stacked">
                                        <div class="card-content">
                                            <h5>Stations/Store name </h5>
                                            <div class="divider mt-2"></div>
                                            <table class="table table-condensed table-striped conde">
                                                
                                                    <tr>
                                                        <td>Total units sold</td>: <td>200</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total value</td>: <td>200</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Lodged</td>: <td>200</td>
                                                    </tr>
                                                
                                            </table>
                                        </div>
                                        <div class="card-action">
                                            <a href="#!" class="waves-effect waves-light btn red darken-4">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col s12 m6 l6">
                                <div class="card horizontal">
                                    <div class="card-image"><img src="{{asset('assets/img/service-image-3.jpg')}}" alt="" /></div>
                                    <div class="card-stacked">
                                        <div class="card-content">
                                        <h5>Stations/Stores name </h5>
                                        <div class="divider mt-2"></div>
                                            <table class="table table-condensed table-striped conde">
                                                
                                                    <tr>
                                                        <td>Total units sold</td>: <td>200</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total value</td>: <td>200</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Total Lodged</td>: <td>200</td>
                                                    </tr>
                                                
                                            </table>
                                        </div>
                                        <div class="card-action">
                                            <a href="#!" class="waves-effect waves-light btn orange darken-4">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    @endif
   
                    
        
@endsection

@section('footer')
@parent()
@endsection

@section('footer_scripts')
@parent()
@endsection
    