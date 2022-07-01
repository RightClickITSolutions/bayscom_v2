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
<!-- Form with validation -->
@include('includes.post_status')
<div class="col s12 m12 l12">
          <div id="form-with-validation" class="card card card-default scrollspy">
            <div class="card-content">
              <h4 class="card-title">Edit User : {{$user->name}}</h4>  <a class=" btn green pull-right  waves-effect waves-light green darken-1 right" href="{{url('/admin/users/edit-user-accesses/'.$user->id)}}">Edit Access</a>
              <form action="{{url('/admin/users/edit-user/'.$user->id)}}" method="POST" >
              {{csrf_field()}}
                <div class="row">
                  <div class="input-filed col m12 s12">
                    <label class="bmd-label-floating">Name</label>
                    <input name="name" value="{{$user->name}}" type="text" class="form-control" >
                    
                  </div>
                </div>
                <div class="row">
                  <div class="input-filed col m12 s12">
                    <label class="bmd-label-floating">email</label>
                    <input name="email" value="{{$user->email}}" type="email" class="form-control" >
                    
                  </div>
                  <div class="input-filed col m12 s12">
                    <label class="bmd-label-floating">password</label>
                    <input name="password" placeholder="(Leave empty to remain unchanged)" value="" type="password" class="form-control" >
                    
                  </div>
                  
                      
                </div>
                    
                
                <div class="row">
                
                  
                  <div class="input-field col m8 s12">
                      <button class="btn cyan waves-effect waves-light green darken-1 right" type="submit" name="action">Update
                          <i class="material-icons right">send</i>
                      </button>
                  </div>
                </div>
              </form>
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
    