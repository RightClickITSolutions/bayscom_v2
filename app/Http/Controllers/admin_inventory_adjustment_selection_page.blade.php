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
        
                <h4 class="header">Substore Inventory Adjustment</h4>
                <div class="row">
                    <form class="col s12" method="post" action="{{url('/admin/inventory-adjustment/')}}">
                    {{csrf_field()}}
                    <input type="hidden" name="adjustment_type" value="substore">
                    
                    <div class="row">
                        <div class="input-field col m4 s6">
                        <select name="substore" class="form-control  browser-default"> 
                            <option value="">Select Substore</option>
                            @foreach($substores as $substore)
                            <option value="{{$substore->id}}">{{$substore->name}}</option>
                            @endforeach
                        

                        </select>
                        </div>
                        <div class="input-field col m4 s6">
                        <select name="product" class="form-control  browser-default"> 
                            @foreach($products as $product)
                            <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                        

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
        
                <h4 class="header">Warehouse Inventory Adjustment</h4>
                <div class="row">
                    <form class="col s12" method="post" action="{{url('/admin/inventory-adjustment/')}}">
                    {{csrf_field()}}
                    <input type="hidden" name="adjustment_type" value="warehouse">
                    <div class="row">
                        <div class="input-field col m4 s6">
                        <select name="warehouse" class="form-control  browser-default"> 
                            <option value="">Select warehouse</option>
                            @foreach($warehouses as $warehouse)
                            <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                            @endforeach
                        

                        </select>
                        </div>
                        <div class="input-field col m4 s6">
                        <select name="product" class="form-control  browser-default"> 
                            @foreach($products as $product)
                            <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                        

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
    