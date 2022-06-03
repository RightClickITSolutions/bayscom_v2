@extends('layouts.mofad')
@section('head') 
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
      @include('includes.post_status')    
      @if (session()->has('status'))
          <script type="application/javascript">
              Swal.fire({
                  icon: 'success',
                  // title: 'Oops...',
                  text: 'Lodgement Reverse successfully.',
                  // footer: '<a href="">Why do I have this issue?</a>'
              })
          </script>
      @endif 
      <div class="col s12">
                <div class="container">
                    <div class="section section-data-tables">
                        <div class="card">
                            <div class="card-content">
                                <p class="caption mb-0">Station/Lubebay Sales</p>
                            </div>
                        </div>
                        <!-- DataTables example -->
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div id="button-trigger" class="card card card-default scrollspy">
                                    <div class="card-content">
                                        <h4 class="card-title">Station/Lube Bay sales</h4>
                                        <div class="row">
                                            
                                            <div class="col s12">
                                                <table id="data-table-simple" class="display">
                                                  <thead >
                                                  <th>
                                                  SST ID
                                                  </th>
                                                
                                                 
                                                  <th>
                                                  Total amount
                                                  </th>
                                                  <th>
                                                    Substore 
                                                  </th>
                                                  <th>
                                                    Substore admin
                                                  </th>
                                                  <th>
                                                    date posted
                                                  </th>
                                                  
                                                  <th>
                                                    Confirmation
                                                  </th>
                                                  <th>
                                                    Action
                                                  </th>
                                                </thead>
                                                <tbody>
                                                    @foreach($sst_list as $sst)
                                                  <tr>
                                                    <td>
                                                      <a href="{{url('sst/view-details/'.$sst->id)}}">{{$sst->id}}</a>
                                                    </td>
                                                    
                                                   
                                                    <td>
                                                    {{$sst->amount}}
                                                    </td>
                                                    <td>
                                                    {{$sst->substore['name']}}
                                                    </td>
                                                    <td>
                                                    {{$sst->createdBy->name}}
                                                    </td>
                                                    <td>
                                                    {{$sst->updated_at}}
                                                    </td>
                                                    <td>
                                                    @if(!$sst->reversed())
                                                        @if($sst->approval->l1!=0)
                                                          {{$sst->approvedBy('l1')}}
                                                        
                                                        @else
                                                          @include('includes.approve_form',['action'=>'/approve-sst','process_id'=>$sst->id,'process_type'=>'SST','level'=>'l1','button_label'=>'Confirm'])
                                                          <br>
                                                          @include('includes.decline_form',['action'=>'/approve-sst','process_id'=>$sst->id,'process_type'=>'SST','level'=>'l1','button_label'=>'Cancel'])
                                                          
                                                        
                                                        @endif
                                                    @else
                                                     Sale entry Reversal <br> by 
                                                     {{$sst->reversalApprovedBy('l1')}}
                                                    @endif
                                                          
                                                    </td>
                                                    <td>
                                                      <a href="{{url('/substore/reverse-sales/'.$sst->id)}}">Reverse Sales</a>
                                                    </td>
                                                  </tr>
                                                  @endforeach
                                                </tbody>
                                              </table>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                <div class="content-overlay"></div>
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
      
   