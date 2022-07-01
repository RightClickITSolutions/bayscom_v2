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
      
    <!-- Form with validation -->
    <div class="col s12 m12 l12">
      @include('includes.post_status')
        <div id="form-with-validation" class="card card card-default scrollspy">
            <div class="card-content">
                <h4 class="card-title">Add Lubebay Expense</h4>
                <form action="{{url('/lubebay/expense/add-expense')}}" method="POST" >
                  {{csrf_field()}}
                
              <div class="row">
                <div class="input-field col m4 s12 ">
                    
                        <label class="bmd-label-floating">Requesting Staff</label>
                        <input name="staff_name" disabled="disabled" value="{{Auth::user()->name}}" type="text" class="form-control" >
                    
                </div>

                <div class="input-field col m4 s12">
                    
                    <label class="bmd-label-floating">Date</label>
                    <input name="date" disabled="disabled" value="<?php echo(date('d-m-Y H:i:s'));?>" type="text" class="form-control" >
                    
                </div>

                <div class="input-field col md 4">
                  
                    <select name="lubebay" class="browser-default"> 
                      <option value="">Select Lubebay</option>
                          @foreach($lubebay_list as $lubebay )
                              <option value="{{ $lubebay->id }}">{{ucwords($lubebay->name)}}</option>
                          @endforeach
                    </select>
                  
                </div>

              </div>
            </div>
          </div>
          <div id="form-with-validation" class="card card card-default scrollspy">
            <div class="card-content">
              <div class="row">
              
                <div class="input-field col md 4">
                  
                    <label class="bmd-label-floating">Expense name</label>
                    <input type="text" min="0" value="{{old('expense_name')}}"  name="expense_name" class="form-control">
                  
                </div>

                <div class="input-field col md 4">
                  
                    <select name="expense_type" class="browser-default"> 
                      <option value="">Select Expense Type</option>
                          @foreach($expense_types as $expense_type )
                              <option value="{{ $expense_type->id }}">{{ucwords($expense_type->name)}}</option>
                          @endforeach
                    </select>
                  
                </div>

                <div class="input-field col md 4">
                  
                    <label class="bmd-label-floating">Expense Amount</label>
                    <input type="number" min="0" value="{{old('expense_amount')}}"  name="expense_amount" class="form-control">
                  
                </div>
              </div>
              <div class="row">
                                
                  <div class="input-field col s8">
                      <button class="btn cyan waves-effect waves-light green darken-1 right" type="submit" name="action">Add Expense
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
     
   