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
                <p class="caption mb-0">{{$warehouse->name}} :  Inventory Adjustment
                    
                </p>
            </div>
        </div>
        <div id="form-with-validation" class="card card card-default scrollspy col m12">
            <div class="card-content">
                <h4 class="card-title"> {{$product->name()}} : Current Inventory Qunatity: {{$warehouse->productInventory($product->id)}} </h4>
                <form action="{{url('admin/warehouse/inventory-adjustment/'.$warehouse->id.'/'.$product->id)}}" method="POST" >
                  {{csrf_field()}}
                
                    <div class="row">
                        <div class="input-field m4">
                            
                            <label class="bmd-label-floating">qauntity</label>
                            <input type="number" step="1" min="0" value=""  name="quantity" class="form-control">
                            <input type="hidden" name="adjustment_type" value="warehouse">         
                        </div>
                        <div class="input-field m4">
                            <select name="transaction_type" class="form-control  browser-default"> 
                                <option value="">Select Adjustment Type</option>
                                <option value="CREDIT">Add to Stock</option>
                                <option value="DEBIT">Remove from stock</option>

                            <select>
                        </div>
                    </div>
                    
                    <div class="row">              
                        <div class="input-field col s8">
                            <button class="btn cyan waves-effect waves-light green darken-1 right" type="submit" name="action">Post
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
    