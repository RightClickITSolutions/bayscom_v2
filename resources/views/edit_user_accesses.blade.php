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
<div class="col s12">
                            <div id="switches" class="card card-tabs">
                                <div class="card-content">
                                    <div class="card-title">
                                        <div class="row">
                                            <div class="col s12 m6 l10">
                                                <h4 class="card-title"> Edit user: {{$user->name }}'s Accesses</h4>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div id="view-switches">
                                        <p> switch on or off roles you want to assign to this user</p>
                                        <form action="{{url('/admin/users/assign-user-roles/'.$user->id)}}" method="POST" class="mt-1">
                                            {{csrf_field()}}
                                            <table>
                                            @foreach($roles_list as $role)
                                            
                                                <tr>
                                                    <td colspan="4">
                                                {{$role->name}}
                                                    </td>
                                                    <td>
                                                        @if($user->hasRole($role->id))
                                                            <div class="switch mb-1">
                                                                <label>
                                                                    Off
                                                                    <input name="roles[]" value='{{$role->id}}' checked type="checkbox">
                                                                    <span class="lever "></span>
                                                                    On
                                                                </label>
                                                            </div>
                                                        @else
                                                            <div class="switch mb-1">
                                                                <label>
                                                                    Off
                                                                    <input name="roles[]" value='{{$role->id}}' type="checkbox">
                                                                    <span class="lever"></span>
                                                                    On
                                                                </label>
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            
                                            @endforeach
                                            <tr>
                                                <td colspan="5">
                                                    <button class="btn cyan waves-effect waves-light green darken-1 " type="submit" name="action">Update
                                                                                                    <i class="material-icons right">send</i>
                                                                                                </button>
                                                </td>
                                            </tr>
                                            </table>
                                            
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

        

<!-- Checkboxes -->
<div class="row">
                        <div class="col s12">
                            <div id="checkboxes" class="card card-tabs">
                                <div class="card-content">
                                    <div class="card-title">
                                        <div class="row">
                                            <div class="col s12 m6 l10">
                                                <h4 class="card-title">Facilitiy Accesses</h4>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div id="view-checkboxes">
                                        <p> Give access to only specific sation ,Lubebays, or warehouses </p>
                                        <form action="{{url('/admin/users/assign-accessible-facility/'.$user->id)}}" method="POST"  class="mt-1">
                                        {{csrf_field()}}    
                                        <p class="title">Warehouses</p>
                                        <row>
                                            @foreach($warehouses_list as $warehouse)

                                            
                                                @if($user->canAccessWarehouse($warehouse->id))
                                                <div class=" m4 l4 s4">
                                                    <p class="mb-1">
                                                        <label>
                                                        
                                                            <input name="warehouses[]" value="{{$warehouse->id}}" type="checkbox" checked="checked"/>
                                                            <span >{{$warehouse->name}}</span>
                                                        </label> 
                                                    |
                                                    </p>
                                                </div>
                                                    
                                                @else
                                                <div class=" m4 l4 s4">
                                                    <p class="mb-1">
                                                    <label>
                                                        
                                                        <input  name="warehouses[]" value="{{$warehouse->id}}"  type="checkbox"  />
                                                    <span>{{$warehouse->name}}</span>
                                                    </label> 
                                                    |
                                                    </p>
                                                </div>
                                                @endif
                                            
                                            @endforeach
                                        </row>
                                            <p><strong>Substores</strong></p>
                                            @foreach($substores_list as $substore)

                                            <p class="mb-1">
                                                @if($user->canAccessSubstore($substore->id))
                                                    <label>
                                                        
                                                        <input name="substores[]" value="{{$substore->id}}" type="checkbox" checked="checked"/>
                                                        <span >{{$substore->name}}</span>
                                                    </label> 
                                                    |
                                                @else
                                                
                                                    <label>
                                                        
                                                        <input  name="substores[]" value="{{$substore->id}}"  type="checkbox"  />
                                                    <span>{{$substore->name}}</span>
                                                    </label> 
                                                    |
                                                @endif
                                            </p>
                                            @endforeach

                                            <p><strong>Lubebays</strong></p>
                                            @foreach($lubebays_list as $lubebay)

                                            <p class="mb-1">
                                                @if($user->canAccessLubebay($lubebay->id))
                                                    <label>
                                                        
                                                        <input name="lubebays[]" value="{{$lubebay->id}}" type="checkbox" checked="checked"/>
                                                        <span >{{$lubebay->name}}</span>
                                                    </label> 
                                                    |
                                                @else
                                                
                                                    <label>
                                                        
                                                        <input  name="lubebays[]" value="{{$lubebay->id}}"  type="checkbox"  />
                                                    <span>{{$lubebay->name}}</span>
                                                    </label> 
                                                    |
                                                @endif
                                            </p>
                                            @endforeach

                                            <p>
                                            <button class="btn cyan waves-effect waves-light green darken-1 " type="submit" name="action">Update
                                                    
                                            <p>
                                            
                                        </form>
                                    </div>
                                    
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
    