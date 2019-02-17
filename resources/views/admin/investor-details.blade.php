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
                        <li><a href="#">Manage Investors</a></li>
                    </ul>
                </div>
            </div>
            <div class="row animated fadeInUp">
                <div class="manage-schools manage-user">
                    <div class="col-sm-12">
                        <h4 class="section-subtitle"><b>Investor Profile</b></h4>
                        <div class="panel">
                            <div class="panel-content">
                                <div class="table-responsive">
                                    <div class="dataTables_wrapper">
                                        <div class="row">
                                            
                                            <h4 class="investor-heading">Investor Details</h4>
                                            <div class="detail-investor">
                                             <div class="col-md-4">
                                             <h5>Name</h5>
                                             <h6>{{ $user_details->name }}</h6>
                                             </div>
                                             <div class="col-md-4">
                                             <h5>Email</h5>
                                             <h6>{{ $user_details->email }}</h6>
                                             </div>
                                             <div class="col-md-4">
                                             <h5>Contact Number</h5>
                                             <h6>{{ $user_details->country_code.'-'.$user_details->mobile_no }}</h6>
                                             </div>
                                             
                                             <div class="clearfix"></div>

                                            </div>
                                          
                                       </div>
                                    </div>
                                     <h4 class="investor-heading">Booking History</h4>
                                    <table class="table table-striped table-hover table-bordered text-center" id="investor-table">
                                        <thead>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Data</th>
                                                <th>Job ID</th>
                                                <th>Property Address</th>
                                                <th>Property type </th>
                                                <th>Amount Paid </th>
                                                <th>Status </th>
                                                <th>File</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       
                                        @foreach($all_requests as $request_details)    
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{convertIntoDateFormate($request_details->created_at)}}</td>
                                            <td>#{{$request_details->id}}</td>
                                            <td>{{$request_details->property_address}}</td>
                                            <td>{{$request_details->property_type_name}}</td>
                                            <td>${{getChargeHelper($request_details->construction_year,$request_details->property_new_status)}}AUD</td>
                                            <td>{{PropertyProgressNameBYId($request_details->request_status)}}</td>

                                            <td>@if($request_details->report_name !=null)
                                            	 <a href="{{asset('/storage/uploaded_reports').'/'. $request_details['report_name']}}" class="theme-btn btn-style-one" download="{{$request_details['report_name']}}"><i class="fa fa-file-pdf-o" style="font-size:24px"></i></a>
                                            @endif
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
        <a href="#" class="scroll-to-top"><i class="fa fa-angle-double-up"></i></a>
    </div>
@endsection
@section('java-script')
<script src="{{ asset('js/admin-investor.js') }}"></script>
<script type="text/javascript">
    $('#manage_investor_li').addClass('active-item');
    $('#manage_valuer_li').removeClass('active-item');
    $('#manage_request_li').removeClass('active-item');
    $('#manage_transaction_li').removeClass('active-item');
    $('#manage_content_li').removeClass('active-item');
</script>   
@endsection
