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
@include('includes.post_status')
<form method="post" action="{{url('/admin/products/update-pricescheme')}}">
{{csrf_field()}}
<div class="col s12">
                <div class="container">
                    <div class="section section-data-tables">
                        <div class="card">
                            <div class="card-content">
                                <p class="caption mb-0"> Products </p>
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
                                                      ID
                                                    </th>
                                                    <th>
                                                      Product
                                                    </th>
                                                    
                                                    <th>
                                                        Cost Price
                                                    </th>
                                                                                                                                      
                                                    
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
                                                       {{number_format($product->cost_price,2)}}
                                                        </td>

                                                        <td>
                                                            <a class=" btn green darken-1" href="{{url('admin/products/edit-product/'.$product->id)}}">Edit product</a>
                                                        </td>

                                                        <td>
                                                        </td>
                                                        
                                                        <td>
                                                            <a class=" btn red darken-1" href="{{url('admin/products/delete-product/'.$product->id)}}">Delete Product</a>
                                                        </td>
                                                        

                                                        
                                                        
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
    