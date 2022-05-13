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
@if (session()->has('status'))
    <script type="application/javascript">
        Swal.fire({
            icon: 'success',
            // title: 'Oops...',
            text: 'Lubebay deleted!!',
            // footer: '<a href="">Why do I have this issue?</a>'
        })
    </script>
@endif
<div class="row">
    <div class="col s12 m12 l12 card">
         <h4 class="card-title">LubeBay List</h4>
         <table class="display table-bordered table" id="data-table-simple">
            <thead>
                <th>Name</th>
                {{-- <th>State</th> --}}
                {{-- <th>Location</th> --}}
                <th>Actions</th>
            </thead>
            <tbody>
            @foreach ($lubebay_list as $items)
                <tr>
                    <td>{{ $items->name }}</td>
                    <td>
                        <a href="{{url('lubebay/edit/'.$items->id)}}" class="btn btn-edit-station"><i class="fa fa-edit"></i></a>
                        <a href="{{url('lubebay/delete/'.$items->id)}}" class="btn btn-delete-station"><i class="fa fa-times"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
         </table>
    <div>
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
      
     
   
     
   