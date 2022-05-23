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
              <div class="col s6 delete-confirmation">
                @foreach ($warehouse_data as $item)
                    <h4>Are you sure you want to delete the warehouse <span>{{ $item->name }}</span> below???</h4>
                    <form action="{{url('admin/warehouse/delete/inst-delete/'.$item->id)}}" method="POST">
                      {{csrf_field()}}
                        <input type="hidden" value="{{ $item->id }}" name="wid">
                        <button class="btn btn-danger btn-yes" type="submit">Yes</button>
                        <button class="btn btn-warning btn-no">No</button>
                    </form>
                @endforeach
            </div>
          </div>
      </div>
      @endsection

      @section('footer')
        @parent()
      @endsection
   