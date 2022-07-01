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

<div class="col s12">
                <div class="container">
                    <div class="section section-data-tables">
                        <div class="card">
                            <div class="card-content">
                                <p class="caption mb-0">List Of all customers</p>
                            </div>
                        </div>
                        <!-- DataTables example -->
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div id="button-trigger" class="card card card-default scrollspy">
                                    <div class="card-content">
                                        <h4 class="card-title">Accounts</h4>
                                        <div class="row">
                                            
                                            <div class="col s12">
                                                <table id="data-table-simple" class="display">
                                            <thead>
                                                    <th>
                                                      ID
                                                    </th>
                                                  
                                                    <th>
                                                      Accont Name 
                                                    </th>
                                                    <th>
                                                      Account Type
                                                    </th>
                                                    <th>
                                                       Balance
                                                    </th>
                                                    
                                                    <th>
                                                    view Account
                                                    </th>
                                                    
                                                  </thead>
                                                  <tbody>
                                                      @foreach($accounts_list as $account)
                                                    <tr>
                                                      <td>
                                                        {{$account->id}}
                                                      </td>
                                                      
                                                      <td>
                                                      {{ucwords($account->account_name)}}
                                                      </td>
                                                      <td>
                                                      {{$account->account_type}}
                                                      </td>
                                                      
                                                      <td>
                                                      {{$account->balance}}
                                                      </td>
                                                     
                                                      <td>
                                                      <a href="{{url('/accounts/view-account/'.$account->id)}}">View Account</a>
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
        
@endsection

@section('footer')
@parent()
@endsection

@section('footer_scripts')
@parent()
@endsection
    