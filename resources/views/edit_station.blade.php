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
                  <h6 class="header-customer-form">Station Edit Form</h6>
                @foreach ($station_edit_data as $item)
                  <form action="{{url('/customer/edit/inst-edit/'.$item->id)}}" method="POST">
                    {{csrf_field()}}
                        <div class="row">
                            <div class="col m6">
                                <div class="form-control">
                                     <label for="">Fullname</label>
                                    <input type="text" name="edit_name" id="" value="{{ $item->name }}">
                                </div>
                            </div>
                            <div class="col m6">
                                <div class="form-control">
                                     <label for="">Email</label>
                                    <input type="text" name="edit_email" id="" value="{{ $item->email }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col m6">
                                <div class="form-control">
                                     <label for="">Phone Number</label>
                                    <input type="text" name="edit_phone" id="" value="{{ $item->phone }}">
                                </div>
                            </div>
                            <div class="col m6">
                                <div class="form-control">
                                    <label for="">State</label>
                                    @if ($item->state == 1)
                                        <input type="text" name="state" value="Kano">
                                        <input type="hidden" name="edit_state" value="">
                                    @endif
                                    @if ($item->state == 2)
                                        <input type="text" name="state" value="Abuja">
                                        <input type="hidden" name="edit_state" value="">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col m12">
                                <div class="form-control">
                                     <label for="">Address</label>
                                    <input type="text" name="edit_address" id="" value="{{ $item->address }}">
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
   