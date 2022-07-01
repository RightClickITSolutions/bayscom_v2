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

@section('content')
<form method="post" action="{{url('/admin/products/update-pricescheme')}}">
{{csrf_field()}}
<div class="col s12">
                <div class="container">
                    <div class="section section-data-tables">
                        <div class="card">
                            <div class="card-content">
                                <p class="caption mb-0"> Products Price scheme </p>
                            </div>
                        </div>
                        <!-- DataTables example -->
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div id="button-trigger" class="card card card-default scrollspy">
                                    <div class="card-content">
                                        <h4 class="card-title"></h4>
                                        <div class="row">
                                        
                                            <div class="col s12">
                                                <table id="data-table-simple" class="display">
                                                  <thead class="">
                                                    <th>
                                                      System ID
                                                    </th>
                                                    <th>
                                                      Product
                                                    </th>
                                                    <th>
                                                      Product Code
                                                    </th>
                                                    @foreach($customer_types as $customer_type )
                                                    <th>
                                                        {{$customer_type->name }}: Price
                                                    </th>
                                                    @endforeach
                                                                                                                                                    
                                                    
                                                  </thead>
                                                  <tbody>
                                                    @foreach($products_list as $product)
                                                    <tr>
                                                        <td>
                                                        {{$product->id}}
                                                        </td>
                                                        <td>
                                                        {{$product->name()}}
                                                        </td>
                                                        <td>
                                                            <input name="product_code[{{$product->id}}]"
                                                            value="{{ $product->product_code}}"
                                                            type="text"
                                                            requred="required"
                                                            >
                                                            </input>
                                                        </td>
                                                        @foreach($customer_types as $customer_type )
                                                        <td>
                                                            <input name="update_products[{{$product->id}}][{{ $customer_type->id}}]"
                                                            value="{{number_format($product->productPrice($customer_type->id),2,'.','')}}"
                                                            type="number"
                                                            step="0.01"
                                                            min="0"
                                                            >
                                                            </input>
                                                        </td>
                                                        @endforeach
                                                    </tr>
                                                    @endforeach
                                                  </tbody>
                                                </table>

                                            </div>
                                        </div>

                                        <div class="row">
                                
                                            <div class="input-field col s12">
                                                <button class="btn cyan waves-effect waves-light green darken-1 right" type="submit" name="action">Update
                                                    
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        
                      </div>
                <div class="content-overlay"></div>
            </div>
</from>
@endsection

@section('footer')
@parent()
@endsection

@section('footer_scripts')
@parent()
@endsection
    