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
            text: 'Station deleted!!',
            // footer: '<a href="">Why do I have this issue?</a>'
        })
    </script>
@endif
<div class="row">
    <div class="col s12 m12 l12 card">
         <h4 class="card-title">Stations List</h4>
         <table class="display" id="data-table-simple">
            <thead>
                <th>Name</th>
                <th>Type</th>
                <th>State</th>
                {{-- <th>Location</th> --}}
                <th>Actions</th>
            </thead>
            <tbody>
                @foreach ($stations_list as $items)
                    <tr>
                        <td>{{ $items->name }}</td>
                        <td>Station</td>
                        @if ($items->state == 2)
                            <td>Abuja</td>
                        @elseif ($items->state == 1)
                            <td>Kano</td>
                        @endif
                        <td>
                            <a href="{{url('stations/edit/'.$items->id)}}" class="btn btn-edit-station"><i class="fa fa-edit"></i></a>
                            <a href="{{url('stations/delete/'.$items->id)}}" class="btn btn-delete-station"><i class="fa fa-times"></i></a>
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
      
     
   
     
   