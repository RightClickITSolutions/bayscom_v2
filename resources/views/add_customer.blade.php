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
       <div class="col s12 m12 l12">
          <div id="form-with-validation" class="card card card-default scrollspy">
            <div class="card-content">
              <h4 class="card-title">Add Customer</h4>
              <form action="{{url('/add-customer')}}" method="POST" >
              {{csrf_field()}}
                <div class="row">
                  <div class="input-filed col m8 s12">
                    <label class="bmd-label-floating">Customer name</label>
                    <input name="name" value="{{old('name')}}" type="text" class="form-control" >
                    
                  </div>
                </div>
                <div class="row">
                  <div class=" input-field col m4 s12">
                    <select name="customer_type" class="form-control browser-default"> 
                      <option value="">Customer Type</option>
                        <option value="1"> Direct cutomer</option>
                        <option value="2">Station</option>
                        <option value="3">Lube bay</option>
                      </select>
                      
                  </div>
                  <div class=" input-field col m4 s12">
                    <select name="payment" class="form-control browser-default"> 
                      <option value="">Payment type</option>
                      <option value="cash">Cash customer</option>
                      <option value="credit">Credit customer</option>
                      
                    </select>
                    
                  </div>
                  <div class=" input-field col m4 s12">
                    
                      <label class="bmd-label-floating">Old Reference ID</label>
                      <input type="text"  value="{{old('old_ref_id')}}"  name="old_ref_id" class="form-control">
                    
                  </div>
                      
                </div>
                    
                <div class="row">
                  <div class=" input-field col m4 s12">
                    
                    <label class="bmd-label-floating">Email address</label>
                    <input name="email"   value="{{old('email')}}" type="email" class="form-control">
                    
                  </div>
                  <div class=" input-field col m4 s12">
                    
                  <label class="bmd-label-floating">Phone</label>
                    <input name="phone"  value="{{old('phone')}}"  >
                    
                  </div>
                  
                  <div class=" input-field col m4 s12">
                    
                    <label class="bmd-label-floating">Alternate phone</label>
                    <input name="alternate_phone" value="{{old('alternate_phone')}}" >
                    
                  </div>
                </div>
                <div class="row">
                  <div class=" input-field col m6 s12">
                    
                        
                    <select name="state" class="form-control browser-default"> 
                      <option value="">Select state</option>
                      <option value="1">Kano</option>
                      <option value="2">Abuja</option>
                      
                    </select>
                    
                  </div>
                  <div class="input-field col m6 s12">
                    
                      <label class="bmd-label-floating">Address</label>
                      <input  name="address" value="{{old('address')}}" type="text" class="form-control">
                    
                  </div>                      
                </div>
                <div class="row">
                
                  <div class="input-field col m4 s12">
                    
                    <label class="bmd-label-floating">Current Balance</label>
                    <input name="current_balance"  value="{{old('current_balance')}}" type="number" class="form-control">
                    
                  </div>
                  <div class="input-field col m8 s12">
                      <button class="btn cyan waves-effect waves-light green darken-1 right" type="submit" name="action">Submit
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
   