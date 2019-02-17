  
@extends('layouts.valuer_app')
@section('style')
<link  href="{{ asset('css/stripeloader.css') }}" rel="stylesheet" type="text/css">
@endsection
@section('content')
  <section>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="sp-column ">
                    <div class="sp-page-title" style="background-image: url({{ asset('images/breadcrumb1.jpg') }} );">
                        <div class="container"><h2>My Jobs</h2>
                            <ol class="breadcrumb">
                                <li>You are here: &nbsp;</li>
                                <li><a href="#" class="pathway">Home</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="my-request my-report my-jobs my-jobs-accpet section-min-h">
        <div class="auto-container">
             @if(Session::has('error_msg'))
                            <p class="{{ Session::has('error_msg') ? 'alert-danger parsley parsley-required danger-custom' : '' }}">
                                 <span class="">
                                        {{ Session::get('error_msg') }}
                                    </span></p>
                    @endif
                    
                    @if(Session::has('success'))
                        <div class="{{ Session::has('success') ? 'alert-success success-alert-custom' : '' }}">
                            <span class="">
                               {{ Session::get('success') }}
                            </span>
                        </div>
                    @endif
            <div class="panel with-nav-tabs panel-primary">
                <div class="panel-heading">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="{{ route('valuer-dashboard') }}" >Accepted Jobs</a></li>
                        <li><a href="{{route('valuer.new.request')}}" >New Jobs</a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="accepted-jobs">
                         @if(count($all_accepted_requests) > 0)
                            <ul class="card-property">
                               @foreach($all_accepted_requests as $accepted_requests) 
                                    <li style="background-image: url({{ asset('images/image'.rand(1,3).'.jpg') }});" class="height-equal">
                                        <div class="over-lay" ></div>
                                        <ol>
                                            <li><div class="icon"><i class="fa fa-calendar" aria-hidden="true"></i></div> <div class="content">{{ convertIntoDateFormate( $accepted_requests['created_at']) }}</div></li>
                                            <li><div class="icon"><i class="fa fa-home" aria-hidden="true"></i></div> <div class="content ellipsis">{{ $accepted_requests['property_address'] }}</div></li>
                                            <li><div class="icon"><i class="fa fa-university" aria-hidden="true"></i></div> <div class="content ellipsis">{{ $accepted_requests['property_type_name']}}</div></li>
                                        </ol>
                                         <div class="tow-icon-btn">
                            <a href="{{ url('/property-detail').'/'. $accepted_requests['id']}}" title="View detail" ><i class="fa fa-eye"></i></a>
                           
                        </div> 
                                        <div class="row bs-wizard" style="border-bottom:0;">
                      
                                            <div class="col-xs-3 bs-wizard-step  @if($accepted_requests['request_status'] >= 1) complete @else active @endif">
                                                <div class="text-center bs-wizard-stepnum">&nbsp;</div>
                                                <div class="progress"><div class="progress-bar"></div></div>
                                                <a href="#" class="bs-wizard-dot"></a>
                                                <div class="bs-wizard-info text-center">Request <br /> Received</div>
                                            </div>
                                            
                                             
                                            <div class="col-xs-3 bs-wizard-step @if($accepted_requests['request_status'] > 2) complete @elseif($accepted_requests['request_status'] >= 2) complete @else disabled @endif"> <!-- complete -->
                                                <div class="text-center bs-wizard-stepnum">&nbsp;</div>
                                                <div class="progress"><div class="progress-bar"></div></div>
                                                <a href="#" class="bs-wizard-dot"></a>
                                                <div class="bs-wizard-info text-center">Assigned</div>
                                            </div>
                                            
                                            @if($accepted_requests['account_type'] == 4)
                                             <div class="col-xs-3 bs-wizard-step">
                                                <div class="text-center bs-wizard-stepnum">&nbsp;</div>
                                                <div class="progress grey"><div class="progress-bar"></div></div>
                                                <a href="#" class="bs-wizard-dot grey"></a>
                                                <div class="bs-wizard-info text-center">Visit <br /> Scheduled</div>
                                            </div>
                                           
                                            
                                            <div class="col-xs-3 bs-wizard-step"><!-- active -->
                                                <div class="text-center bs-wizard-stepnum">&nbsp;</div>
                                                <div class="progress grey"><div class="progress-bar"></div></div>
                                                <a href="#" class="bs-wizard-dot grey"></a>
                                                <div class="bs-wizard-info text-center"> Visit <br />Completed</div>
                                            </div>
                                            @else                                           
                                                   <div class="col-xs-3 bs-wizard-step @if($accepted_requests['request_status'] > 3) complete @elseif($accepted_requests['request_status'] >= 3) complete @else disabled @endif"><!-- active -->
                                                    <div class="text-center bs-wizard-stepnum">&nbsp;</div>
                                                    <div class="progress"><div class="progress-bar"></div></div>
                                                    <a href="#" class="bs-wizard-dot"></a>
                                                   <div class="bs-wizard-info text-center">Visit <br /> Scheduled</div>
                                                </div>
                                            
                                                <div class="col-xs-3 bs-wizard-step @if($accepted_requests['request_status'] >4) complete @elseif($accepted_requests['request_status'] >= 4) complete @else disabled @endif"><!-- active -->
                                                    <div class="text-center bs-wizard-stepnum">&nbsp;</div>
                                                    <div class="progress"><div class="progress-bar"></div></div>
                                                    <a href="#" class="bs-wizard-dot"></a>
                                                    <div class="bs-wizard-info text-center"> Visit <br />Completed</div>
                                                </div>
                                            @endif
                                            
                                            
                                            <div class="col-xs-3 bs-wizard-step @if($accepted_requests['request_status'] > 5) complete @elseif($accepted_requests['request_status'] == 5) complete @else disabled @endif"><!-- active -->
                                                <div class="text-center bs-wizard-stepnum">&nbsp;</div>
                                                <div class="progress"><div class="progress-bar"></div></div>
                                                <a href="#" class="bs-wizard-dot"></a>
                                                <div class="bs-wizard-info text-center">Report <br />Generated</div>
                                            </div>
                                        </div>
                                        <div class="tow-btn">
                                            @if($accepted_requests['account_type'] == 4)
                                                     <a href="#upload-report" data-id="{{ $accepted_requests['id'] }}" disabled data-toggle="modal" class="theme-btn btn-style-one open_upload_report" data-backdrop="static" data-keyboard="false">Upload Report</a>
                                            }@else

                                               @if($accepted_requests['request_status'] <= 3 || ($accepted_requests['report_name'] != null) )
                                                
                                                    <a href="#update-job-status" data-toggle="modal" class="theme-btn btn-style-one showstatusupdate" data-id="{{ $accepted_requests['id'] }}">Update Status</a>
                                                @else
                                               <a href="#" class="theme-btn btn-style-one showstatusupdate disabled2">Update Status</a>

                                             @endif   
                                               @if($accepted_requests['request_status'] == 4 && ($accepted_requests['report_name'] == null))
                                                     <a href="#upload-report" data-id="{{ $accepted_requests['id'] }}" disabled data-toggle="modal" class="theme-btn btn-style-one open_upload_report" data-backdrop="static" data-keyboard="false">Upload Report</a>
                                                @else
                                                <a href="#"  disabled class="theme-btn btn-style-one open_upload_report disabled2">Upload Report</a>
                                                @endif
                                            </div>
                                        @endif    
                                    </li>
                                @endforeach    
                                
                            </ul>
                        @else
                            <div class="alert alert-info fade in">

                             {{ trans('messages.no_accepted_job') }}
                         </div>  
                        @endif
                        </div>
                       
                </div>
            </div>
        </div>
    </section>

   <!-- update start popup div ---->
   <div id="update-job-status" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm up-job-status">
    
        <div class="modal-content">
            <div id="show_status" ></div>
        </div>
    
    </div>
</div> <!-- end update status popup div-->

 <!--  start upload pdf report popup div-->
<div id="upload-report" class="modal fade" role="dialog">
    <div class="modal-dialog up-job-status upload-report">
    
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Upload Report</h4>
            </div>
             <div id="pop_min_height" style="min-height:278px;" >
             <form id="uploaddiamond" class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                  <div id="file_name_div" style="display:none;"><span id="file_name"></span><span id="hide_name">x</span></div>
               <div class="up-load">
                    <input type="file" style="display: none;" name="result_file" id="result_file" class="inputfile inputfile-4" data-multiple-caption="{count} files selected" multiple />
                    <label for="result_file"><figure><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/></svg></figure> <span>Choose a file&hellip;</span></label>
                     <span id="errormessage" class="alert-danger parsley parsley-required danger-custom-hide" style="text-align:center">Please select valid file.</span>
                </div>
               
                <input type="hidden" name="job_id" id="job_id" value="" />
            </div>
            <div class="modal-footer">
                <button type="submit" class="theme-btn btn-style-one" >Submit</button>
                
            </div>
        </form>
       

        <div class="Paycontinue" id="loader_div" style="display:none;">               
<div class="circle-loader" >
  <div class="checkmark draw"></div>
</div>
<h3 id="payment-succ-mess" style="display:none;">Report has been successfully uploaded.</h3>


<div id="payment-error-mess"  style="margin-top:15px;padding-right:0px;display:none;">    
 <h3 style="color: #ef3030;">Sorry! we are unable to upload report please try again.</h3>
 </div>
 <span id="uploading" style="color: #ef3030;display:none;"><h3 >Uploading...</h3></span>
</div>

        <!-- loader code statrt  -->
        <div class='uil-ring-css' id="loader_div" style='transform:scale(0.6);display: none;'><div></div></div>

         <!-- loader code end -->

            <div class="modal-footer" id="ok_div" style="display: none;">
               
                <button type="button" id="ok_buuton" class="theme-btn btn-style-one" data-dismiss="modal">OK</button>
            </div>

            <div class="modal-footer" id="cancel_div" style="display: none;">
               
                <button type="button" id="ok_cancel" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>      
       
        </div>
      
        </div>

    </div>
</div>  <!-- end upload pdf popup-->

    
    @endsection

<!-- include page js script - - - -->

@section('java-script')
<script src="{{ asset('js/new-request.js') }}"></script>
<script>
    $(document.body).click(function() {
         $('.alert-danger').hide();
        $('.alert-success').hide();   
            
      });


    </script>
@endsection