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
                        @include('includes.post_status')
                            <!-- invoice view page -->
                            <div class="col xl9 m8 s12">
                                <div class="card">
                                    <div class="card-content invoice-print-area">
                                        <!-- header section -->
                                        <div class="row invoice-date-number">
                                            <div class="col xl4 s12">
                                                <span class="invoice-number mr-1">Invoice#</span>
                                                <span>{{$prf->warehouse_id.$prf->id}}</span>
                                            </div>
                                            <div class="col xl8 s12">
                                                <div class="invoice-date display-flex align-items-center flex-wrap">
                                                    <div class="mr-3">
                                                        <small>Date Issue:</small>
                                                        <span>{{$prf->created_at}}</span>
                                                    </div>
                                                    <div>
                                                        <small>Date Due:</small>
                                                        <span>@if($prf->payemt ="CREDIT"){{$prf->payment_date}}@else{{$prf->created_at}}@endif</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- logo and title -->
                                        <div class="row mt-3 invoice-logo-title">
                                            <div class="col m6 s12 display-flex invoice-logo mt-1 push-m6">
                                                <img src="{{asset('/assets/img/mofad-logo.png')}}" alt="logo" height="46" width="164">
                                            </div>
                                            <div class="col m6 s12 pull-m6">
                                                <h4 class="indigo-text">Invoice</h4>
                                                <span>Sale invoice</span>
                                            </div>
                                        </div>
                                        <div class="divider mb-3 mt-3"></div>
                                        <!-- invoice address and contact -->
                                        <div class="row invoice-info">
                                            <div class="col m6 s12">
                                                <h6 class="invoice-from">Bill From</h6>
                                                <div class="invoice-address">
                                                    <span>MOFAD Energy Services</span>
                                                </div>
                                                <div class="invoice-address">
                                                    <span>36 T.O.S Benson Crescent, Abuja</span>
                                                </div>
                                                <div class="invoice-address">
                                                    <span>info@mofadenergysolutions.com</span>
                                                </div>
                                                <div class="invoice-address">
                                                    <span>+2348038313791</span>
                                                </div>
                                            </div>
                                            <div class="col m6 s12">
                                                <div class="divider show-on-small hide-on-med-and-up mb-3"></div>
                                                <h6 class="invoice-to">Bill To</h6>
                                                <div class="invoice-address">
                                                    <span>{{$prf->customer->name}}</span>
                                                </div>
                                                <div class="invoice-address">
                                                    <span>{{$prf->customer->address}}</span>
                                                </div>
                                                <div class="invoice-address">
                                                    <span>{{$prf->customer->email}}</span>
                                                </div>
                                                <div class="invoice-address">
                                                    <span>{{$prf->customer->phone}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="divider mb-3 mt-3"></div>
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
                                                     <!-- for the initial operation of the system the product codes were ont included in order snapshots -->
                                                       
                                                        <td>{{$order_item->product_code ?? $order_item->product_id}}</td>
                                                        <td>{{$order_item->product_name}}</td>
                                                        <td>{{$order_item->product_price}}</td>
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
                                                    <p>Thanks for your business.</p>
                                                    <br><br><br>
                                                    <ul>
                                                    <li class="display-flex justify-content-between">
                                                       <h6 class="invoice-subtotal-value">
                                                       @if($prf->approval->{$prf->final_approval}!=0)
                                                               {{ $prf->approvedBy($prf->final_approval) }}<br><br>Sign: _______________________________ 
                                                            
                                                            @else
                                                                AWAITING APPROVAL
                                                            @endif
                                                        </h6>
                                                    </li>
                                                    <ul>

                                                </div>
                                                <div class="col xl4 m7 s12 offset-xl3">
                                                    <ul>
                                                        <li class="display-flex justify-content-between">
                                                            <span class="invoice-subtotal-title">Subtotal</span>
                                                            <h6 class="invoice-subtotal-value">{{number_format($prf->order_total,2)}}</h6>
                                                        </li>
                                                        <!-- remove tax -->
                                                        <!-- <li class="display-flex justify-content-between">
                                                            <span class="invoice-subtotal-title">Tax</span>
                                                            <h6 class="invoice-subtotal-value">5%</h6>
                                                        </li> -->
                                                        <li class="divider mt-2 mb-2"></li>
                                                        <li class="display-flex justify-content-between">
                                                            <span class="invoice-subtotal-title">Invoice Total</span>
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
                                        @if($prf->approval->{$prf->final_approval}!=0)
                                        <div class="invoice-action-btn">
                                            <a href="#" class="btn-block btn btn-light-indigo waves-effect waves-light invoice-print">
                                                <span>Print Invoice</span>
                                            </a>
                                        </div>
                                        @endif
                                        <div class="invoice-action-btn">
                                            <a href="{{url('/prf/waybill/'.$prf->id)}}" class="btn-block btn btn-light-indigo waves-effect waves-light ">
                                                
                                                <span class="text-nowrap">Waybill</span>
                                            </a>
                                        </div>
                                        <div class="invoice-action-btn">
                                            <a href="{{url('/view-prf')}}" class="btn-block btn btn-light-indigo red text-darken-1 waves-effect waves-light">
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
    