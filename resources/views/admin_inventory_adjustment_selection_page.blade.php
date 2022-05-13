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
      @include('includes.post_status')
        <div class="card">
            <div class="card-content">
                <p class="caption mb-0">Inventory Adjustment
                    
                </p>
            </div>
        </div>
        <div id="form-with-validation" class="card card card-default scrollspy col m12">
            <div class="card-content">
                <h4 class="card-title"> Warehouse inventory Adjustment</h4>
                <form action="{{url('/admin/inventory-adjustment/')}}" method="POST" >
                  {{csrf_field()}}
                
                    <div class="row">
                        <div class="input-field m4">
                            <select name="warehouse" class="form-control  browser-default"> 
                                <option value="">Select Warehouse</option>
                                @foreach($warehouses as $warehouse)
                                    <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                @endforeach

                            <select>

                        </div>

                        <div class="input-field m4">
                            
                            <select name="product" class="form-control  browser-default"> 
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                    <option value="{{$product->id}}">{{$product->name()}}</option>
                                @endforeach

                            <select>
                            <input type="hidden" name="adjustment_type" value="warehouse">         
                        </div>
                        
                    </div>
                    
                    <div class="row">              
                        <div class="input-field col s8">
                            <button class="btn cyan waves-effect waves-light green darken-1 right" type="submit" name="action">Open
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="form-with-validation" class="card card card-default scrollspy col m12">
            <div class="card-content">
                <h4 class="card-title"> Substore inventory Adjustment</h4>
                <form action="{{url('/admin/inventory-adjustment/')}}" method="POST" >
                  {{csrf_field()}}
                
                    <div class="row">
                        <div class="input-field m4">
                            <select name="substore" class="form-control  browser-default"> 
                                <option value="">Select substore</option>
                                @foreach($substores as $substore)
                                    <option value="{{$substore->id}}">{{$substore->name}}</option>
                                @endforeach

                            <select>

                        </div>

                        <div class="input-field m4">
                            
                            <select name="product" class="form-control  browser-default"> 
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                    <option value="{{$product->id}}">{{$product->name()}}</option>
                                @endforeach

                            <select>
                            <input type="hidden" name="adjustment_type" value="substore">         
                        </div>
                        
                    </div>
                    
                    <div class="row">              
                        <div class="input-field col s8">
                            <button class="btn cyan waves-effect waves-light green darken-1 right" type="submit" name="action">Open
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


    </div>  
@endsection

@section('footer')
@parent()
@endsection

@section('footer_scripts')
@parent()
@endsection
    