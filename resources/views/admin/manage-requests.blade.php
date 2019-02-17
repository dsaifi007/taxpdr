@extends('layouts.admin_app')
@section('content')
    <!-- page BODY -->
   

   
    <div class="page-body">
       @include('includes.admin_side_bar');
        <div class="content">
            <div class="content-header">
                <div class="leftside-content-header">
                    <ul class="breadcrumbs">
                        <li><i class="fa fa-home" aria-hidden="true"></i><a href="#">Home</a></li>
                        <li><a href="#">Manage Requests</a></li>
                    </ul>
                </div>
            </div>
            <div class="row animated fadeInUp">
                <div class="manage-schools manage-user">
                    <div class="col-sm-12">
                        <h4 class="section-subtitle"><b>Manage Requested Assigned</b></h4>
                        <div class="panel">
                            <div class="panel-content">
                                <div class="table-responsive">
                                    <div class="dataTables_wrapper">
                                        <div class="row">
                                            
                                           <ul class="manage-requests_link">
                                           <li class="active"><a href="{{route('admin.manage.requests')}}">Request Assigned</a></li>
                                           <li><a href="{{route('admin.pending.requests')}}">Pending Request</a></li>
                                           <li><a href="{{route('admin.completed.requests')}}">Completed Request</a></li>
                                           </ul>
                                          
                                        </div>
                                    </div>

                                    <table class="table table-striped table-hover table-bordered text-center" id="investor-table">
                                        <thead>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Date</th>
                                                <th>Job ID</th>
                                                <th>Investor Name</th>
                                                <th>Investor Email</th>
                                                <th>Assigned to</th>
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       
                                        @foreach($all_requests as $single_requests)    
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{date('d-M-Y',strtotime($single_requests->created_at)) }}</td>
                                            <td>T{{$single_requests->id}}</td>
                                            <td>{{$single_requests->investor_name}}</td>
                                            <td>{{$single_requests->investor_email}}</td>
                                            <td>{{$single_requests->valuer_name}}</td>
                                            <td>{{$single_requests->valuer_email}}</td>
                                            <td>{{PropertyProgressNameBYId($single_requests->request_status)}}</td>
                                           <td ><select name="valuer_id" id="valuer_id{{ $single_requests->id }}" style="width: 120px"; class="assigned" ><option value="0">
                                             Re-Assign </option>
                                             <?php $valuers = getValuerByStateId($single_requests->state); ?>
                                             @foreach($valuers as $valuer)
                                             <option data-request-id="{{ $single_requests->id }}" value="{{$valuer->id}}">
                                            {{$valuer->name}}({{$valuer->account_type_name}})</option>
                                             @endforeach
                                            </select></td>                                          
                                        
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
        <a href="#" class="scroll-to-top"><i class="fa fa-angle-double-up"></i></a>
    </div>
@endsection
@section('java-script')
<script src="{{ asset('js/admin-investor.js') }}"></script>
<script type="text/javascript">
    $('#manage_investor_li').removeClass('active-item');
    $('#manage_valuer_li').removeClass('active-item');
    $('#manage_request_li').addClass('active-item');
    $('#manage_transaction_li').removeClass('active-item');
    $('#manage_content_li').removeClass('active-item');

    $('.assigned').on('change', function(){
          var request_id =  $('option:selected', this).attr("data-request-id");
          console.log(request_id);
          var valuer_id = $(this).val();
          window.location.href = APP_URL+"/Admin/assign-to-valuer/"+request_id+"/"+valuer_id;
       
     });

    $(document.body).click(function() {
         $('.alert-success').hide();     
   });
      
</script>   
@endsection
