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
                        <h4 class="section-subtitle"><b>Manage Completed Requests</b></h4>
                        <div class="panel">
                            <div class="panel-content">
                                <div class="table-responsive">
                                    <div class="dataTables_wrapper">
                                        <div class="row">
                                            
                                           <ul class="manage-requests_link">
                                           <li ><a href="{{route('admin.manage.requests')}}">Request Assigned</a></li>
                                           <li><a href="{{route('admin.pending.requests')}}">Pending Request</a></li>
                                           <li class="active"><a href="{{route('admin.completed.requests')}}">Completed Request</a></li>
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
                                                <th>Surveyor Name</th>
                                                <th>Surveyor Email</th>
                                                <th>file</th>
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
                                            <td>@if($single_requests->report_name !=null)
                                                 <a href="{{asset('/storage/uploaded_reports').'/'. $single_requests['report_name']}}" class="theme-btn btn-style-one" download="{{$single_requests['report_name']}}"><i class="fa fa-file-pdf-o" style="font-size:24px"></i></a>
                                            @endif</td>                                          
                                        
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
</script>   
@endsection
