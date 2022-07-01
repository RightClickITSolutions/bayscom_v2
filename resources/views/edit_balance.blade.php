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
                  <h6 class="header-customer-form">Customer Edit Balance</h6>
                @foreach ($customer_edit_balance as $item)
                  <form action="{{url('/customer/edit/balance/inst-edit/'.$item->id)}}" method="POST">
                    {{csrf_field()}}
                        <div class="row">
                            <div class="col m12">
                                <div class="form-control">
                                     <label for="">Customer Balance</label>
                                    <input type="number" name="edit_balance" id="" value="{{ $item->balance }}">
                                    <input type="hidden" name="edit_id" id="" value="{{ $item->id }}">
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
   