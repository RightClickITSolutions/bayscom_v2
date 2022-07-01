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
                                <div class="card">
                                    <div class="card-content invoice-print-area">
                                        
                                        <!-- product details table-->
                                        <div class="invoice-product-details">
                                            <table class="striped responsive-table">
                                                <thead>
                                                    <tr>
                                                        <th>product ID</th>
                                                        <th>Description</th>
                                                        <th>Ordered Qty</th>
                                                        <th>Received Qty</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($pro->order_snapshot() as $order_item)
                                                    <tr>
                                                        <td>{{$order_item->product_id}}</td>
                                                        <td>{{$order_item->product_name}}</td>
                                                        <td>{{$order_item->product_quantity}}</td>
                                                        <td>{{$pro->received_product_quantity($order_item->product_id)}}</td>
                                                    </tr>
                                                    @endforeach
                                                   
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- invoice subtotal -->
                                        <div class="divider mt-3 mb-3"></div>
                                       
                                    </div>
                                </div>
                            </div>
                            <!-- Form with validation -->
                            @if($pro->approval_status!='APPROVED_COLLECTED')
                            <div class="col s12 m12 l12">
                                <div id="form-with-validation" class="card card card-default scrollspy">
                                    <div class="card-content">
                                        <h4 class="card-title"> Receiving Purchased Items</h4>
                                        <form action="{{url('/pro/store-keeper/'.$pro->id)}}" method="POST" >
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
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Form Advance -->
                            <div class="col s12 m12 l12">
                                <div id="Form-advance" class="card card card-default scrollspy">
                                    @if($pro->approval_status!='APPROVED_COLLECTED')
                                    <div id="products-card" class="card-content">
                                        <h4 class="card-title">Product</h4>

                                            <div id="main-form" class="row">
                                                <div class="input-field col m6 s12">
                                                <select name='product' class="form-control  browser-default"> 
                                                  <option value="">Select Product</option>
                                                      @foreach($pro->order_snapshot() as  $order_item)
                                                          <option value="{{ $order_item->product_id }}">{{ucwords($order_item->product_name)}}</option>
                                                      @endforeach
                                                </select>
                                                  
                                                </div>
                                                <div class="input-field col m6 s12">
                                                    <input type="number" min="0" value="{{old('quantity')}}"  name="quantity" class="form-control" class="validate">
                                                    <label for="last_name">Quantity</label>
                                                </div>
                                                
                                            </div>

                                            <div id="add-form">
                                            
                                           
                                            
                                            
                                            </div>
                                            
                                                <div class="row">
                                                <div class="input-field col s4">
                                                        
                                                        <!-- <span id="add-product" class="btn  blue darken-1 right" >+product
                                                            
                                                        </span> -->
                                                    </div>
                                                    <div class="input-field col s8">
                                                        <button class="btn cyan waves-effect waves-light green darken-1 right" type="submit" name="action">Submit
                                                            <i class="material-icons right">send</i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                    </div>
                                    @else
                                    <div id="products-card" class="card-content align-content-center ">
                                        <h4 class="card-title green-text text-darken-2 centered  ">This Order Has Been Completed</h4>
                                    </div>
                                    @endif
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
    
   

