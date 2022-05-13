@extends('layouts.mofad')

@section('head')
    @parent()
    <link rel="stylesheet" type="text/css" href="{{asset('/app-assets/css/pages/app-invoice.css')}}">
@endsection()

@section('side_nav')
@parent()
@endsection

@section('top_nav')
    @parent()
@endsection

@section('content')
 <div class="col s12">
                <div class="container">

               
                    <!-- app invoice View Page -->
                    <section class="invoice-view-wrapper section">
                        <div class="row">
                            <!-- invoice view page -->
                            <div class="col xl9 m8 s12">
                            <div class="card">
                                    <div class="card-content invoice-print-area">
                                        <h4 class="card-title">Order: {{$prf->id }} </h4>
                                        <!-- product details table-->
                                        <div class="invoice-product-details">
                                            <table class="striped responsive-table">
                                                <thead>
                                                    <tr>
                                                        <th>Customer Name</th>
                                                        <th>Customer General Account Balance</th>
                                                        <th>Last payment received</th>
                                                        <th>Lodged By</th>
                                                        <th>Date</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{$prf->customer->name}}</td>
                                                        <td>₦{{number_format($prf->customer->balance,2)}}</td>
                                                       
                                                        <td> ₦{{$customer->lastPayment()->amount}} </td>
                                                        <td> {{$customer->lastPayment()->lodgedBy->name}} </td>
                                                        <td>  {{$customer->lastPayment()->created_at}}</td>
                                                    </tr>
                                                    <!-- @foreach($prf->payments as $payment)
                                                    @if($payment->transaction_type=='CREDIT')
                                                    <tr>
                                                        <td>  -  </td>
                                                        <td>₦{{number_format($payment->amount,2)}}</td>
                                                        <td>₦{{number_format(($prf->order_total=$payment->amount),2)}}</td>
                                                        <td>{{$payment->created_at}}</td>
                                                        
                                                    </tr>
                                                    @endif
                                                    @endforeach -->
                                                   
                                                </tbody>
                                                
                                            </table>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-content invoice-print-area">
                                        <h4 class="card-title">Order: {{$prf->d }} Details</h4>
                                        <!-- product details table-->
                                        <div class="invoice-product-details">
                                            <table class="striped responsive-table">
                                                <thead>
                                                    <tr>
                                                        <th>product ID</th>
                                                        <th>Description</th>
                                                        <th>Price</th>
                                                        <th>Qty</th>
                                                        <th class="right-align">Price</th>
                                                    </tr>
                                                    
                                                </thead>
                                                <tbody>
                                                    @foreach($prf->order_snapshot() as $order_item)
                                                    <tr>
                                                        <td>{{$order_item->product_id}}</td>
                                                        <td>{{$order_item->product_name}}</td>
                                                        <td>{{number_format($order_item->product_price,2)}}</td>
                                                        <td>{{$order_item->product_quantity}}</td>
                                                        <td class="indigo-text right-align">₦{{number_format($order_item->product_quantity*$order_item->product_price,2)}}</td>
                                                    </tr>
                                                    @endforeach
                                                   
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- invoice subtotal -->
                                        <div class="divider mt-3 mb-3"></div>
                                        <div class="invoice-subtotal">
                                            <div class="row">
                                                <div class="col m5 s12">
                                                    
                                                    <ul>
                                                    <li class="display-flex justify-content-between">
                                                       <h6 class="invoice-subtotal-value">
                                                       @if($prf->approval->{$prf->final_approval}!=0)
                                                               Approved By:  {{ $prf->approvedBy($prf->final_approval) }}
                                                            
                                                            @else
                                                                AWAITING APPROVAL
                                                            @endif
                                                        </h6>
                                                    </li>
                                                    <ul>

                                                </div>
                                                <div class="col xl4 m7 s12 offset-xl3">
                                                    <ul>
                                                        <!-- <li class="display-flex justify-content-between">
                                                            <span class="invoice-subtotal-title">Subtotal</span>
                                                            <h6 class="invoice-subtotal-value">{{number_format($prf->order_total,2)}}</h6>
                                                        </li>
                                                        
                                                        <li class="display-flex justify-content-between">
                                                            <span class="invoice-subtotal-title">Tax</span>
                                                            <h6 class="invoice-subtotal-value">5%</h6>
                                                        </li> -->
                                                        <li class="divider mt-2 mb-2"></li>
                                                        <li class="display-flex justify-content-between">
                                                            <span class="invoice-subtotal-title">Total</span>
                                                            <h6 class="invoice-subtotal-value">₦{{number_format($prf->order_total,2)}}</h6>
                                                        </li>
                                                        <!-- <li class="display-flex justify-content-between">
                                                            <span class="invoice-subtotal-title">Paid to date</span>
                                                            <h6 class="invoice-subtotal-value">- $ 00.00</h6>
                                                        </li>
                                                        <li class="display-flex justify-content-between">
                                                            <span class="invoice-subtotal-title">Balance (USD)</span>
                                                            <h6 class="invoice-subtotal-value">$ 10,953</h6>
                                                        </li> -->
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- invoice action  -->
                            <div class="col xl3 m4 s12">
                                <div class="card invoice-action-wrapper">
                                    <div class="card-content">
                                        <!-- <div class="invoice-action-btn">
                                            <a href="#" class="btn indigo waves-effect waves-light display-flex align-items-center justify-content-center">
                                                <i class="material-icons mr-4">check</i>
                                                <span class="text-nowrap">Send Invoice</span>
                                            </a>
                                        </div> -->
                                                                                
                                        <div class="invoice-action-btn">
                                            <a href="#" onclick="window.history.back()" class="btn-block btn btn-light-indigo waves-effect waves-light">
                                                <span>Back</span>
                                            </a>
                                        </div>
                                        <!-- <div class="invoice-action-btn">
                                            <a href="#" class="btn waves-effect waves-light display-flex align-items-center justify-content-center">
                                                <i class="material-icons mr-3">attach_money</i>
                                                <span class="text-nowrap">Add Payment</span>
                                            </a>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="content-overlay"></div>
            </div>
@endsection

@section('footer')
@parent()
@endsection

@section('footer_scripts')
@parent()
  <!-- BEGIN PAGE LEVEL JS-->
    <script src="{{asset('/app-assets/js/scripts/app-invoice.js')}}"></script>
    <!-- END PAGE LEVEL JS-->
@endsection
    