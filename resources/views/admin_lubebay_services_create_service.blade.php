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
                                        <h4 class="card-title">Create Lubebay Service</h4>
                                        <form action="{{url('/admin/lubebay-services/create-service')}}" method="post">
                                            {{csrf_field()}}
                                            
                                            
                                            <div id="main-form" class="row">
                                                <div class="input-field col m4 s12">
                                                    <input type="text"  value="{{old('service_name')}}"  name="service_name" class="form-control" class="validate">
                                                    <label for="service_name">Service Name</label>
                                                </div>
                                                <div class="input-field col m4 s12">
                                                    <input type="text" min="0" value="{{old('service_description')}}"  name="service_description" class="form-control" class="validate">
                                                    <label for="service_description">Service Decription</label>
                                                </div>
                                                <div class="input-field col m4 s12">
                                                    <input type="number" min="0" value="{{old('price')}}"  name="price" class="form-control" class="validate">
                                                    <label for="price"> Price</label>
                                                </div>
                                                
                                            </div>
                                            
                                            
                                            
                                                <div class="row">
                                                <div class="input-field col s4">
                                                        
                                                        <!-- <span id="add-service" class="btn  blue darken-1 right" >+service
                                                            
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
                        </div>
                        </div>
                        
    
      
      @endsection

      @section('footer')
        @parent()
      @endsection
      
      @section('footer_scripts')
      @parent()
      
      @endsection
    
   

