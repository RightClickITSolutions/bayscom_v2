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
      @include('includes.post_status')
       <!-- Form with validation -->
       <div class="col s12 m12 l12">
          <div class="row">
              <div class="col s6 card edit_customer_form">
                  <h6 class="header-customer-form">Retail Outlet Edit Form</h6>
             @foreach ($retail_list as $item)
                <form action="{{url('admin/substore/edit/inst-edit/'.$item->id)}}" method="POST">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col m12">
                            <div class="form-control">
                                <label for="">Retail Outlet Name</label>
                                <input type="text" name="edit_name" id="" value="{{ $item->name }}">
                                <input type="hidden" name="edit_id" id="" value="{{ $item->id }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col m12">
                            <div class="form-control">
                                <label for="">State Name</label>
                                @if ($item->state == 1)
                                    <input type="text" name="edit_state" id="" value="Abuja">
                                @endif
                                @if ($item->state == 2)
                                    <input type="text" name="edit_state" id="" value="Kano">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col m6">
                            <div class="form-control">
                                <button type="submit" class="btn btn-edit"><h6>Save  <i class="fa fa-bookmark"></i></h6></button>
                            </div>
                        </div>
                    </div>
                </form>
              @endforeach
              </div>
          </div>
      </div>
      @endsection

      @section('footer')
        @parent()
      @endsection
   