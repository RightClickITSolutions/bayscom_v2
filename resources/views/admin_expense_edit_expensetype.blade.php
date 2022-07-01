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
                                        <h4 class="card-title">Edit Expense Type : {{$expense_type->name}}</h4>
                                        <form action="{{url('/admin/expense/edit-expensetype/'.$expense_type->id)}}" method="post">
                                            {{csrf_field()}}
                                            
                                            
                                            <div id="main-form" class="row">
                                                <div class="input-field col m4 s12">
                                                    <input type="text"  value="{{$expense_type->name}}"  name="expense_type_name" class="form-control" class="validate">
                                                    <label for="expense_type_name">Expense Type  Name</label>
                                                </div>
                                               
                                                
                                            </div>
                                            
                                           
                                            
                                            </div>
                                            
                                                <div class="row">
                                                <div class="input-field col s4">
                                                        
                                                        <!-- <span id="add-product" class="btn  blue darken-1 right" >+product
                                                            
                                                        </span> -->
                                                    </div>
                                                    <div class="input-field col s8">
                                                        <button class="btn cyan waves-effect waves-light green darken-1 right" type="submit" name="action">Update
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
    
   

