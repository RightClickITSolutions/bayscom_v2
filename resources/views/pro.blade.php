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
      <form action="{{url('create-pro')}}" method="POST" id="form">
      <div class="col s12">
                <div class="container">
                    <div class="seaction">
                    @include('includes.post_status')
                      
                            <!-- Form with validation -->
                            <div class="col s12 m12 l12">
                                <div id="form-with-validation" class="card card card-default scrollspy">
                                    <div class="card-content">
                                        <h4 class="card-title">Pro Request Details</h4>
                                        
                                          {{csrf_field()}}
                                            <div class="row">
                                                <div class="input-field col m4 s6">
                                                <select name="warehouse" class="form-control browser-default"> 
                                                    <option value="">Select Warehouse</option>
                                                    @foreach($warehouses as $warehouse )
                                                    <option value="{{ $warehouse['id'] }}">{{ucwords($warehouse->name)}}</option>
                                                    @endforeach
                                                

                                                </select>
                                                </div>
                                                <div class="input-field col m4 s6">
                                                   
                                                    <label class="bmd-label-floating">Requesting staff</label>
                                    <input name="staff_name" disabled="disabled" value="{{Auth::user()->name}}" type="text"  >
                                                   
                                                </div>
                                                <div class="input-field col m4 s12">
                                                    <div class="input-field col s12">
                                                    <input name="date" disabled="disabled" value="<?php echo(date('d-m-Y H:i:s'))?>" type="text"  >
                                                    </div>
                                                </div>
                                            </div>
                                        
                                    </div>
                                </div>
                            </div>



                            <!-- Form Advance -->
                            <div class="col s12 m12 l12">
                                <div id="Form-advance" class="card card card-default scrollspy">
                                    <div id="products-card" class="card-content">
                                        <h4 class="card-title">Products</h4>
                                        
                                            <div id="main-form" class="row">
                                                <div class="input-field col m6 s12">
                                                <select name="products[]" class="form-control  browser-default"> 
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
                                            <div id="add-form"></div>
                                            
                                                <div class="row">
                                                <div class="input-field col s4">
                                                        <span id="add-product" class="btn  blue darken-1 right" >+product
                                                           
                                                        </span>
                                                    </div>
                                                    <div class="input-field col s8">
                                                        <button class="btn cyan waves-effect waves-light green darken-1 right" type="submit" name="action">Request
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
           
            cloned_form  = $('#main-form').clone();
            $('#add-form').append(cloned_form);
            console.log("got eeem");
          })

            // $('#form').on('submit', function(e) {
            //     //prevent the default submithandling
            //     e.preventDefault();
            //     //send the data of 'this' (the matched form) to yourURL
            //     $.post("{{url('create-pro')}}", $(this).serialize());
                
            //     console.log("subtit clicked aposted");
            // });

      </script>
      @endsection
    