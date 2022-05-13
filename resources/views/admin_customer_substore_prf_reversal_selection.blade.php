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

<div class="row">
    <div class="col s12 m12 l12">
        <div class="card ">
            <div class="card-content ">
        
                <h4 class="header">Substore PRF Reversal</h4>
                <div class="row">
                    <form class="col s12" method="post" action="{{url('/dasboard/salesrep/sales-summery/')}}">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="input-field col m4 s6">
                        <select name="user" class="form-control  browser-default"> 
                            <option value="">Select Substore</option>
                            @foreach($substores as $substore)
                            <option value="{{$substore->id}}">{{$substore->name}}</option>
                            @endforeach
                        

                        </select>
                        </div>
                        <div class="input-field col m4 s6">
                        <select name="month" class="form-control  browser-default"> 
                            <option value="">Select Month</option>
                            <option value="1" {{ ( old('month') == 1) ? "selected='selected'":""  }}>January</option>
                            <option {{ ( old('month') == 2) ? "selected='selected'":""  }}value="2">Ferbruary</option>
                            <option {{ ( old('month') == 3) ? "selected='selected'":""  }}value="3">March</option>
                            <option {{ ( old('month') == 4) ? "selected='selected'":""  }}value="4">April</option>
                            <option {{ ( old('month') == 5) ? "selected='selected'":""  }}value="5">May</option>
                            <option {{ ( old('month') == 6) ? "selected='selected'":""  }}value="6">June</option>
                            <option {{ ( old('month') == 7) ? "selected='selected'":""  }}value="7">July</option>
                            <option {{ ( old('month') == 8) ? "selected='selected'":""  }}value="8">August</option>
                            <option {{ ( old('month') == 9) ? "selected='selected'":""  }}value="9">September</option>
                            <option {{ ( old('month') == 10) ? "selected='selected'":""  }}value="10">October</option>
                            <option {{ ( old('month') == 11) ? "selected='selected'":""  }}value="11">November</option>
                            <option {{ ( old('month') == 12) ? "selected='selected'":""  }}value="12">December</option>
                            
                        

                        </select>
                        </div>
                        <div class="input-field  col m4 s6">
                        <button class=" btn btn-primary green darken-3" type="submit"> Open</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    <div>
</div>

<div class="row">
    <div class="col s12 m12 l12">
        <div class="card ">
            <div class="card-content ">
        
                <h4 class="header">Customer Prf/h4>
                <div class="row">
                    <form class="col s12" method="post" action="{{url('/dasboard/salesrep/sales-summery/')}}">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="input-field col m4 s6">
                        <select name="user" class="form-control  browser-default"> 
                            <option value="">Select Substore</option>
                            @foreach($customers as $customer)
                            <option value="{{$customer->id}}">{{$customer->name}}</option>
                            @endforeach
                        

                        </select>
                        </div>
                        <div class="input-field col m4 s6">
                        <select name="month" class="form-control  browser-default"> 
                            <option value="">Select Month</option>
                            <option value="1" {{ ( old('month') == 1) ? "selected='selected'":""  }}>January</option>
                            <option {{ ( old('month') == 2) ? "selected='selected'":""  }}value="2">Ferbruary</option>
                            <option {{ ( old('month') == 3) ? "selected='selected'":""  }}value="3">March</option>
                            <option {{ ( old('month') == 4) ? "selected='selected'":""  }}value="4">April</option>
                            <option {{ ( old('month') == 5) ? "selected='selected'":""  }}value="5">May</option>
                            <option {{ ( old('month') == 6) ? "selected='selected'":""  }}value="6">June</option>
                            <option {{ ( old('month') == 7) ? "selected='selected'":""  }}value="7">July</option>
                            <option {{ ( old('month') == 8) ? "selected='selected'":""  }}value="8">August</option>
                            <option {{ ( old('month') == 9) ? "selected='selected'":""  }}value="9">September</option>
                            <option {{ ( old('month') == 10) ? "selected='selected'":""  }}value="10">October</option>
                            <option {{ ( old('month') == 11) ? "selected='selected'":""  }}value="11">November</option>
                            <option {{ ( old('month') == 12) ? "selected='selected'":""  }}value="12">December</option>
                            
                        

                        </select>
                        </div>
                        <div class="input-field  col m4 s6">
                        <button class=" btn btn-primary green darken-3" type="submit"> Open</button>
                        </div>
                    </div>
                    </form>
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
@endsection
    