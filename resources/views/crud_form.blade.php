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
                                        <h4 class="card-title">{{$form_title}}</h4>
                                        <form action="{{url($form_action)}}" method="post">
                                            {{csrf_field()}}
                                            
                                            
                                            <div id="main-form" class="row">
                                                @foreach($form_fields as $field)
                                                    @include('includes.input_field', $field)
                                                @endforeach

                                            </div>

                                            
                                            
                                            
                                            
                                            
                                                <div class="row">
                                                
                                                    <div class="input-field col s8">
                                                        <button class="btn cyan waves-effect waves-light green darken-1 right" type="submit" name="action">Create
                                                            <i class="material-icons right">send</i>
                                                        </button>
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
    
   

