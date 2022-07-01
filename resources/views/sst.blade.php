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
      <!-- End Navbar -->
      @section('content')
      @include('includes.post_status')
                <!-- Form with validation -->
            <form action="{{url('/substore/days-transactions/submit')}}" method="POST" >
                            
                <div class="col s12 m12 l12">
                    <div id="form-with-validation" class="card card card-default scrollspy">
                        <div class="card-content">
                            <h4 class="card-title">Product sales</h4>
                              {{csrf_field()}}
                              <div class="row" >
                                 <div class="input-field col m6 s12">
                                      <select name="substore" class="form-control browser-default"> 
                                        <option value="">Select Store</option>
                                        @foreach($substores as $substore )
                                        <option value="{{ $substore->id }}">{{ucwords($substore->name)}}</option>
                                        @endforeach
                                    </select>
                                  </div>
                                  <div class="input-field col m6 s12">
                                    <select name="payment" class="form-control browser-default"> 
                                        <option value="">Payment type</option>
                                        <option value="CASH"> CASH</option>
                                        <option value="POS"> POS</option>
                                    </select>
                                  </div>
                               </div>
                              <div class="row">

                                <div class="input-field col m6 s12">
                                  <label class="bmd-label-floating">Requesting staff</label>
                                  <input name="staff_name" disabled="disabled" value="{{Auth::user()->name}}" type="text" class="form-control" >
                                </div>

                                <div class="input-field col m6 s12">
                                  <label class="bmd-label-floating">Submission date</label>
                                  <input name="date" disabled="disabled" value="<?php echo(date('d-m-Y H:i:s'))?>" type="text" class="form-control" >
                                </div>
                         
                              </div>
                        </div>
                      </div>
                    </div>
                    
                    <!-- Form Advance -->
                    <!-- Form Advance -->
                    <div class="col s12 m12 l12">
                        <div id="Form-advance" class="card card card-default scrollspy">
                            <div id="products-card" class="card-content">
                                <h4 class="card-title">Products</h4>

                                    <div id="main-form" class="row">
                                        <div class="input-field col m6 s12">
                                        <select name='products[]' class="form-control  browser-default"> 
                                            <option value="">Select Product</option>
                                                @foreach($products as $product )
                                                    <option value="{{ $product['id'] }}">{{ucwords($product->name())}}</option>
                                                @endforeach
                                        </select>
                                            
                                        </div>
                                        <div class="input-field col m6 s12">
                                            <input type="number" min="0" value="{{old('quantity.0')}}"  name="quantity[]" class="form-control" class="validate">
                                            <label for="last_name">Quantity</label>
                                        </div>
                                        
                                    </div>

                                    <div id="add-form">
                                    
                                    <!-- <div id="main-form" class="row">
                                        <div class="input-field col m6 s12">
                                        <select name='products[]' class="form-control  browser-default"> 
                                            <option value="">Select Product</option>
                                                @foreach($products as $product )
                                                    <option value="{{ $product['id'] }}">{{ucwords($product->name())}}</option>
                                                @endforeach
                                        </select>
                                            
                                        </div>
                                        <div class="input-field col m6 s12">
                                            <input type="number" min="0" value=""  name="quantity[]" class="form-control" class="validate">
                                            <label for="last_name">Quantity</label>
                                        </div>
                                        
                                    </div> -->
                                    
                                    
                                    </div>
                                    
                                        <div class="row">
                                        <div class="input-field col s4">
                                                
                                                <span id="add-product" class="btn  blue darken-1 right" >+product
                                                    
                                                </span>
                                            </div>
                                            <div class="input-field col s8">
                                                <button class="btn cyan waves-effect waves-light green darken-1 right" type="submit" name="action">Submit
                                                    <i class="material-icons right">send</i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                
                            </div>
                        </div>
                    </div>

                        <!-- special prices -->
                    <div class="col s12 m12 l12 hide hidden">
                        <div id="Form-advance" class="card card card-default scrollspy">
                            <div class="card-content">
                                <h4 class="card-title">Special Discount Products</h4>
                                    
                                    <div class="row">
                                        <div class="input-field col m4 s12">
                                        <select name="special_item_products[]" class="form-control browser-default"> 
                                            <option value="">Select Product</option>
                                                @foreach($products as $product )
                                                    <option value="{{ $product['id'] }}">{{ucwords($product->name())}}</option>
                                                @endforeach
                                        </select>
                                            
                                        </div>
                                        <div class="input-field col m4 s12">
                                            <input type="number" min="0" value="{{old('special_item_product_quantity.0')}}"  name="special_item_product_quantity[]" class="form-control" class="validate">
                                            <label for="last_name">Quantity</label>
                                        </div>
                                        <div class="input-field col m4 s12">
                                            <input type="number"  value="{{old('special_item_product_price.0')}}"  name="special_item_product_price[]" class="form-control" class="validate">
                                            <label for="orice">Price/Unit</label>
                                        </div>
                                    </div>
                                    
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <button class="btn cyan waves-effect waves-light green darken-1 right" type="submit" name="action">Submit
                                                    <i class="material-icons right">send</i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                
                            </div>
                        </div>
                  </div>
                </div>
            </form>
@endsection

      @section('footer')
        @parent()
      @endsection

      @section('footer_scripts')
      @parent()
      <script>
          $('#add-product').on("click", function(){
           
            $('#main-form').clone().appendTo('#add-form');
            console.log("got eeem");
          })

      </script>
      @endsection
    