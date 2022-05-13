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
      <form action="{{url('/lubebay/days-transactions/submit')}}" method="POST" >
                <!-- Form with validation -->
                <div class="col s12 m12 l12">
                    <div id="form-with-validation" class="card card card-default scrollspy">
                        <div class="card-content">
                            <h4 class="card-title">Lubebay Service sales</h4>
                            
                              {{csrf_field()}}
                              <div class="row" >
                                 <div class="input-field col m6 s12">
                                      <select name="lubebay" class="form-control browser-default"> 
                                        <option value="">Select Store</option>
                                        @foreach($lubebays as $lubebay )
                                        <option value="{{ $lubebay->id }}">{{ucwords($lubebay->name)}}</option>
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
                                <h4 class="card-title">Services</h4>

                                    <div id="main-form" class="row">
                                        <div class="input-field col m6 s12">
                                        <select name='services[]' class="form-control  browser-default"> 
                                            <option value="">Select service</option>
                                                @foreach($services as $service )
                                                    <option value="{{ $service['id'] }}">{{ucwords($service->service_name)}}</option>
                                                @endforeach
                                        </select>
                                            
                                        </div>
                                        <div class="input-field col m6 s12">
                                            <input type="number" min="0" value="{{old('quantity')}}"  name="quantity[]" class="form-control" class="validate">
                                            <label for="last_name">Quantity</label>
                                        </div>
                                        
                                    </div>

                                    <div id="add-form">
                                    
                                    <div id="main-form" class="row">
                                        <div class="input-field col m6 s12">
                                        <select name='services[]' class="form-control  browser-default"> 
                                            <option value="">Select Service</option>
                                                @foreach($services as $service )
                                                    <option value="{{ $service['id'] }}">{{ucwords($service->service_name)}}</option>
                                                @endforeach
                                        </select>
                                            
                                        </div>
                                        <div class="input-field col m6 s12">
                                            <input type="number" min="0" value="{{old('quantity')}}"  name="quantity[]" class="form-control" class="validate">
                                            <label for="last_name">Quantity</label>
                                        </div>
                                        
                                    </div>
                                    
                                    
                                    </div>
                                    
                                        <div class="row">
                                        <div class="input-field col s4">
                                                
                                                <span id="add-product" class="btn  blue darken-1 right" >+Service
                                                    
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

                    <div class="col s12 m12 l12 hide hidden">
                        <div id="Form-advance" class="card card card-default scrollspy">
                            <div class="card-content">
                                <h4 class="card-title">Specilal Discount  Serviess</h4>
                                    
                                    <div class="row">
                                        <div class="input-field col m4 s12">
                                        <select name="special_item_services[]" class="form-control browser-default"> 
                                            <option value="">Select Service</option>
                                                @foreach($services as $service )
                                                    <option value="{{ $service['id'] }}">{{ucwords($service->service_name)}}</option>
                                                @endforeach
                                        </select>
                                            
                                        </div>
                                        <div class="input-field col m4 s12">
                                            <input type="number" min="0" value="{{old('special_item_service_quantity')}}"  name="special_item_service_quantity[]" class="form-control" class="validate">
                                            <label for="last_name">Quantity</label>
                                        </div>
                                        <div class="input-field col m4 s12">
                                            <input type="number"  value="{{old('special_item_service_price')}}"  name="special_item_service_price[]" class="form-control" class="validate">
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
    