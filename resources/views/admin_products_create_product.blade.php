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
      
      <div class="col s12">
                <div class="container">
                    <div class="seaction">
                      
                            @include('includes.post_status')
                           
                            

                            <!-- Form Advance -->
                            <div class="col s12 m12 l12">
                                <div id="Form-advance" class="card card card-default scrollspy">
                                    <div id="products-card" class="card-content">
                                        <h4 class="card-title">Create Product</h4>
                                        <form action="{{url('/admin/products/create-product')}}" method="post">
                                            {{csrf_field()}}
                                            
                                            
                                            <div id="main-form" class="row">
                                                <div class="input-field col m4 s12">
                                                    <input type="text"  value="{{old('product_name')}}"  name="product_name" class="form-control" class="validate">
                                                    <label for="product_name">Product Name</label>
                                                </div>
                                                <div class="input-field col m2 s12">
                                                    <input type="text" min="0" value="{{old('product_description')}}"  name="product_description" class="form-control" class="validate">
                                                    <label for="product_description">Product Decription</label>
                                                </div>
                                                <div class="input-field col m2 s12">
                                                    <input type="text" min="0" value="{{old('product_code')}}"  name="product_code" class="form-control" class="validate">
                                                    <label for="product_code">Product Code</label>
                                                </div>
                                                <div class="input-field col m4 s12">
                                                    <input type="number" min="0" step="0.01" value="{{old('cost_price')}}"  name="cost_price" class="form-control" class="validate">
                                                    <label for="cost_price">Cost Price</label>
                                                </div>
                                                
                                            </div>
                                            <br>
                                            <br>
                                            <h4 class="card-title">Price scheme</h4>

                                            @foreach($customer_types as $customer_type)
                                            <div id="main-form" class="row">
                                                <div class="input-field col m6 s12">
                                                    <input disabled='disabled' type="text"  value="{{old('$customer_type->name')}}"  name="customer_type[{{$customer_type->id}}]" class="form-control" class="validate">
                                                    <label for="customer_type[{{$customer_type->id}}]">{{$customer_type->name}}</label>
                                                </div>
                                                <div class="input-field col m6 s12">
                                                    <input type="number" min="0" step="0.01"  value="{{old('customer_type[$customer_type->id][price]')}}"  name="customer_type[{{$customer_type->id}}][price]" class="form-control" class="validate">
                                                    <label for="customer_type[{{$customer_type->id}}][price]">Price</label>
                                                </div>
                                                
                                            </div>
                                            @endforeach
                                            
                                            </div>
                                            
                                                <div class="row">
                                                <div class="input-field col s4">
                                                        
                                                        <!-- <span id="add-product" class="btn  blue darken-1 right" >+product
                                                            
                                                        </span> -->
                                                    </div>
                                                    <div class="input-field col s8">
                                                        <button class="btn cyan waves-effect waves-light green darken-1 right" type="submit" name="action">Create
                                                            <i class="material-icons right">send</i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                   
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
    
   

