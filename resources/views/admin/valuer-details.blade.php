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
                        <li><a href="#">Manage Surveyors</a></li>
                    </ul>
                </div>
            </div>
            <div class="row animated fadeInUp">
                <div class="manage-schools manage-user">
                    <div class="col-sm-12">
                        <h4 class="section-subtitle"><b>Surveyor Profile</b></h4>
                        <div class="panel">
                            <div class="panel-content">
                                <div class="table-responsive">
                                    <div class="dataTables_wrapper">
                                        <div class="row">
                                            
                                            <h4 class="investor-heading">Surveyor Details</h4>
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
                                              <div class="col-md-4">
                                             <h5>Licence Number</h5>
                                             <h6>{{ $user_details->licence_number }}</h6>
                                             </div>
                                             <div class="col-md-4">
                                             <h5>State Name</h5>
                                             <h6>{{ getStateById($user_details->state) }}</h6>
                                             </div>

                                             <div class="clearfix"></div>

                                            </div>
                                          
                                       </div>
                                    </div>
                                    <h4 class="investor-heading">Job details</h4>
                                    <table class="table table-striped table-hover table-bordered text-center" id="investor-table">
                                        <thead>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Data</th>
                                                <th>Job ID</th>
                                                <th>Property Address</th>
                                                <th>Property type </th>
                                                <th>Status </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       
                                        @foreach($all_requests as $request_details)    
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{convertIntoDateFormate($request_details->created_at)}}</td>
                                            <td>T{{$request_details->id}}</td>
                                            <td>{{$request_details->property_address}}</td>
                                            <td>{{$request_details->property_type_name}}</td>
                                            <td>{{PropertyProgressNameBYId($request_details->request_status)}}</td>
                                           
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
    $('#manage_valuer_li').addClass('active-item');
    $('#manage_request_li').removeClass('active-item');
    $('#manage_transaction_li').removeClass('active-item');
    $('#manage_content_li').removeClass('active-item');
</script>   
@endsection
