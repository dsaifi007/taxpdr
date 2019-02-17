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
                        <li><a href="#">Manage Surveyors / Accountant</a></li>
                    </ul>
                </div>
            </div>
            <div class="row animated fadeInUp">
                <div class="manage-schools manage-user">
                    <div class="col-sm-12">
                        <h4 class="section-subtitle"><b>Manage Surveyors / Accountant</b></h4>
                        <div class="panel">
                            <div class="panel-content">
                                <div class="table-responsive">
                                    <div class="dataTables_wrapper">
                                        <div class="row">
                                            
                                            <!--div class="col-md-4 col-sm-6 col-xs-12">
                                                <div class="text-center">
                                                    <button class="btn btn-wide btn-success"><i class="fa fa-database" aria-hidden="true"></i> Extract Data</button>
                                                </div>
                                            </div-->
                                          
                                        </div>
                                    </div>

                                    <table class="table table-striped table-hover table-bordered text-center" id="investor-table">
                                        <thead>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Licence Number </th>
                                                 <th>Registered as </th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                       
                                        @foreach($all_valuers as $all_valuer)    
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{$all_valuer->name}}</td>
                                            <td>{{$all_valuer->email}}</td>
                                            <td>{{$all_valuer->country_code.$all_valuer->mobile_no}}</td>
                                            <td>{{$all_valuer->licence_number}}</td>
                                             <td>{{$all_valuer->account_type_name}}</td>
                                            <td>
                                                <div class="btn-group btn-group-xs">
                                                    <a href="{{url('/Admin/valuer-profile').'/'.$all_valuer->id}}" class="green-btn"><i class="fa fa-eye"></i></a>
                                                    <label class="switch" >
                                                        <input class="switch-input blocked" id="user_block{{$all_valuer->id }}" type="checkbox" current-status="@if($all_valuer->status == 1) 1 @else 0 @endif" name="user_status[]" value="{{ $all_valuer->status }}" @if($all_valuer->status == 1) checked="checked" @else @endif onclick="return blockUnblock({{$all_valuer->id }});">
                                                        <span class="switch-label" data-on="Block" data-off="Unblock"></span> 
                                                        <span class="switch-handle"></span> 
                                                    </label>
                                                </div>
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
    $('#manage_investor_li').removeClass('active-item');
    $('#manage_valuer_li').addClass('active-item');
    $('#manage_request_li').removeClass('active-item');
    $('#manage_transaction_li').removeClass('active-item');
    $('#manage_content_li').removeClass('active-item');
</script>   
@endsection
