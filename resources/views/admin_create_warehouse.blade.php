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
                            <div class="col  s12">
                                
                            </div>
                            <!-- Form with validation -->
                            <div class="col s12 m12 l12">
                                <div id="form-with-validation" class="card card card-default scrollspy">
                                    <div class="card-content">
                                        <h4 class="card-title"> Create Warehouse</h4>
                                        <a href="/view/warehouses" class="btn">
                                            View all Warehouses
                                        </a>
                                        <form action="{{url('/admin/create/warehouse')}}" method="POST" >
                                          {{csrf_field()}}
                                            
                                            <div class="row">
                                                <div class="input-field col m6 s6">
                                                
                                                    <label class="bmd-label-floating">Name Of Warehouse</label>
                                                    <input name="warehouse_name"  type="text" class="form-control" >
                                                
                                                </div>

                                                <div class="input-field col m6 s6">
                                                <select name="state" class="form-control  browser-default"> 
                                                  <option value="">Select State</option>
                                                      @foreach($states as $state)
                                                          <option value="{{ $state['id'] }}">{{ucwords($state['name'])}}</option>
                                                      @endforeach
                                                </select>
                                                
                                                </div>
                                                
                                                
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
                                        </form>                                                   
                                    </div>
                                </div>
                            </div>


                            <!-- Form Advance -->
                            

                        </div>
    
      
      @endsection

      @section("footer")
        @parent()
      @endsection
      
      @section("footer_scripts")
      @parent()
      
      @endsection
    
   

