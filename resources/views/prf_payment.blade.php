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
                            <!-- Form with validation -->
                            <div class="col s12 m12 l12">
                                <div id="form-with-validation" class="card card card-default scrollspy">
                                    <div class="card-content">
                                        <h4 class="card-title">Enter PRF Lodgement</h4>
                                        <form action="{{url('prf/payment/'.$prf->id)}}" method="POST" >
                                          {{csrf_field()}}
                                            <div class="row">
                                                <div class="input-field col m6 s6">
                                                  <label class="bmd-label-floating">Receiving Staff</label>
                                                  <input name="staff_name" disabled="disabled" value="{{Auth::user()->name}}" type="text" class="form-control" >
                                                </div>
                                                <div class="input-field col m6 s6">
                                                   
                                                   
                                                  <label class="bmd-label-floating">Date</label>
                                                  <input name="date" disabled="disabled" value="<?php echo(date('d-m-Y H:i:s'))?>" type="text" class="form-control" >
                            
                                                </div>
                                                
                                            </div>

                                            <div class="row">
                                                <div class="input-field col m12">
                                                  <label class="bmd-label-floating">Payment Amount</label>
                                                  <input type="number" min="0" value="{{old('payment_amount')}}"  name="payment_amount" class="form-control">
                                                </div>
                                                <div class="input-field col m12">
                                                  <label class="bmd-label-floating">Teller no: Transaction ID</label>
                                                  <input type="text"  value="{{old('teller_no')}}"  name="teller_no" class="form-control">
                                                </div>
                                                <div class="input-field col m12 ">
                                                    <button class="btn cyan waves-effect waves-light green darken-1 right" type="submit" name="action">Submit
                                                        <i class="material-icons right">payment</i>
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
      <script>
          $('#add-product').on("click", function(){
           
            $('#main-form').clone().appendTo('#add-form');
            console.log("got eeem");
          })

      </script>
      @endsection
    
   