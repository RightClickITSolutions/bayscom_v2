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
<form method="post" action="{{url('/admin/expense/update-expensetype')}}">
{{csrf_field()}}
<div class="col s12">
                <div class="container">
                    <div class="section section-data-tables">
                        <div class="card">
                            <div class="card-content">
                                <p class="caption mb-0"> Mofad Expense Types</p>
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
                                                      Expense Type Name
                                                    </th>
                                                    <th>
                                                      
                                                    </th>
                                                                                                                          
                                                    
                                                  </thead>
                                                  <tbody>
                                                    @foreach($expense_types_list as $expense_type)
                                                    <tr>
                                                        <td>
                                                        {{$expense_type->id}}
                                                        </td>
                                                        <td>
                                                        {{$expense_type->name}}
                                                        </td>
                                                        
                                                       

                                                        <td>
                                                            <a class=" btn green darken-1" href="{{url('admin/expense/edit-expensetype/'.$expense_type->id)}}">Edit Expense type</a>
                                                        </td>

                                                        <td>
                                                        </td>
                                                        
                                                        <td>
                                                            <a class=" btn red darken-1" href="{{url('admin/expense/delete-expensetype/'.$expense_type->id)}}">Delete Expense type</a>
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
    