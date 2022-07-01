@extends('layouts.mofad')
@section('head') 
   <!-- BEGIN: VENDOR CSS-->
   <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/flag-icon/css/flag-icon.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/data-tables/css/select.dataTables.min.css')}}">
    <!-- END: VENDOR CSS-->
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
                <div class="section section-data-tables">
                    <div class="card">
                        <div class="card-content">
                            <p class="caption mb-0">Reverse Lodgement</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-overlay">

            </div>
            <!-- Form with validation -->
            <div class="col s12 m12 l12">
                <div class="row">
                    <div class="col s6 delete-confirmation" style="padding-bottom: 20px;">
                        @foreach ($lodgement_to_reverse as $item)
                            <h4>Are you sure you want to Reserve the Lodgement: <span>{{ $item->id }}</span> ???</h4>
                            <form action="{{url('customer/lodgement/reversal/inst-reversal/'.$item->id)}}" method="POST">
                            {{csrf_field()}}
                                <input type="hidden" value="{{ $item->id }}" name="lid">
                                <button class="btn btn-danger btn-yes" type="submit">Yes</button>
                                <button class="btn btn-warning btn-no">No</button>
                            </form>
                                {{-- <ul>
                                    <li><strong>Name:</strong> <span>{{ $item->name }}</span></li>
                                    <li><strong>Email:</strong> <span>{{ $item->email }}</span></li>
                                    <li><strong>Phone:</strong> <span>{{ $item->phone }}</span></li>
                                    <li><strong>Address:</strong> <span>{{ $item->address }}</span></li>
                                </ul> --}}
                        @endforeach
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
    
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="{{asset('app-assets/vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/data-tables/js/dataTables.select.min.js')}}"></script>
    <!-- END PAGE VENDOR JS-->

   
    <!-- BEGIN PAGE LEVEL JS-->
    <script src="{{asset('app-assets/js/scripts/data-tables.js')}}"></script>
    
      @endsection
      
     