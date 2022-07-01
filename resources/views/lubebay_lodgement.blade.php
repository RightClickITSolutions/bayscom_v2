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
       <form action="{{url('/lubebay/lodgement/'.$lubebay->id)}}" method="POST" >
                           
            <div class="col s12">
                <div class="container">
                    <div class="seaction">
                      
                            @include('includes.post_status')
                            <!-- Form with validation -->
                            <div class="col s12 m6 l6">
                                <div id="form-with-validation" class="card card card-default scrollspy">
                                    <div class="card-content">
                                        <h4 class="card-title">{{$lubebay->name}}  Lubebay Services Lodgement Date: {{now()}}</h4>
                                        
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
                                                  <input type="text"  value="{{old('bank_reference')}}"  name="bank_reference" class="form-control">
                                                </div>
                                                
                                                
                                            </div>

                                            <!-- Remove Underlodgement fro lubebay Lodgements -->
                                            <!-- <hr> -->
                                            <h4 class="card-title  hide hidden">UnderLodgements</h4>
                                            <div class="row hide hidden">
                                            
                                              <div class="input-field col md 4">
                                                
                                                  <label class="bmd-label-floating">Expense description</label>
                                                  <input type="text" min="0" value="{{old('expense.0')}}"  name="expense[]" class="form-control">
                                                
                                              </div>

                                              <div class="input-field col md 4">
                                                
                                                  <select name="expense_type[]" class="browser-default"> 
                                                    <option value="">Select Expense Type</option>
                                                        @foreach($expense_types as $expense_type )
                                                            <option value="{{ $expense_type->id }}">{{ucwords($expense_type->name)}}</option>
                                                        @endforeach
                                                  </select>
                                                
                                              </div>

                                              <div class="input-field col md 4">
                                                
                                                  <label class="bmd-label-floating">Expense Amount</label>
                                                  <input type="number" min="0" value="{{old('expense_amount.0')}}"  name="expense_amount[]" class="form-control">
                                                
                                              </div>
                                            </div>
                                            <!-- <hr> -->


                                            <div class="row">
                                        

                                                <div class="input-field col m12 ">
                                                    <button class="btn cyan waves-effect waves-light green darken-1 right" type="submit" name="action">Submit
                                                        <i class="material-icons right">payment</i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                      
                                    </div>
                                </div>

                              

                            </div>
                            
                            <div class="col s12 m6 l6">
                                <div id="form-with-validation" class="card card card-default scrollspy">
                                    <div class="card-content">
                                    <table id="multi-select" class="display">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <label>
                                                                    <input type="checkbox" class="select-all" />
                                                                    <span></span>
                                                                </label>
                                                            </th>
                                                            
                                                            <th>Total Underlodgemnt</th>
                                                            <th>₦ {{number_format($lubebay->total_sales() - $lubebay->total_lodgements(),2)}}</th>

                                                            
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      @foreach($lubebay->unlodged_lsts() as $lst)
                                                        <tr>
                                                            <th>
                                                                <label>
                                                                    <input name="related_lsts[]" value="{{$lst->id}}" type="checkbox" />
                                                                    <span></span>
                                                                </label>
                                                            </th>
                                                            <td >{{$lst->created_at}}</td>
                                                            <td>₦ {{number_format($lst->total_amount,2)}}</td>
                                                        </tr>
                                                      @endforeach
                                                      
                                                      </tbody>
                                                      
                                                    </table>
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
    
   