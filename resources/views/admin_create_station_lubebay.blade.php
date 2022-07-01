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
                                        <h4 class="card-title"> Create Retail Outlet</h4>
                                        <a href="/admin/view/retail-outlet" class="btn btn-success">
                                            View All Retail Outlets
                                        </a>
                                        <form action="{{url('/admin/create/station-lubebay')}}" method="POST" >
                                          {{csrf_field()}}
                                            <div>
                                            <p class="mb-1"><strong>Create:</strong>
                                             &nbsp;&nbsp;&nbsp;
                                             Station
                                                <label>
                                                    <input name="station" value="true" type="checkbox" />
                                                    <span ></span>
                                                </label>
                                            Lubebay 
                                                <label>
                                                    <input name="lubebay" value="true" type="checkbox" />
                                                    <span ></span>
                                                </label> 
                                                
                                            </p>
                                            </div>
                                            <div class="row">
                                                <div class="input-field col m6 s6">
                                                
                                                    <label class="bmd-label-floating">Name Of LStation/Lubebay</label>
                                                    <input name="name"  type="text" class="form-control" >
                                                
                                                </div>
                                                <div class="input-field col m6 s6">
                                                
                                                    <label class="bmd-label-floating">Address</label>
                                                    <input name="address"  type="text" class="form-control" >
                                                
                                                </div>
                                                
                                                
                                            </div>
                                            <div class="row">
                                                <div class="input-field col m6 s6">
                                                
                                                    <label class="bmd-label-floating">Contact number</label>
                                                    <input name="Phone"  type="text" class="form-control" >
                                                
                                                </div>
                                                <div class="input-field col m6 s6">
                                                
                                                    <label class="bmd-label-floating">Email</label>
                                                    <input name="email"  type="text" class="form-control" >
                                                
                                                </div>
                                                
                                                
                                            </div>
                                            <div class="row">
                                                <div class="input-field col m6 s6">
                                                
                                                <select name="location" class="form-control  browser-default"> 
                                                  <option value="">Select Location</option>
                                                      @foreach($locations as $location)
                                                          <option value="{{ $location['id'] }}">{{ucwords($location['name'])}}</option>
                                                      @endforeach
                                                </select>
                                                
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
    
   

