@extends('layouts.investor_app')
@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css" /> 
@endsection
@section('content')

<section>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="sp-column ">
                    <div class="sp-page-title" style="background-image: url({{ asset('/images/breadcrumb1.jpg') }}) ;">
                        <div class="container"><h2>My Reports</h2>
                            <ol class="breadcrumb">
                                <li>You are here: &nbsp;</li>
                                <li><a href="#" class="pathway">Reports</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
       
    <section class="my-request my-report">
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
        @if(count($all_sent_requests) > 0)            
            <ul class="card-property">
                @foreach($all_sent_requests as $all_sent_request) 
                  <li style="background-image: url({{ asset('images/image'.rand(1,3).'.jpg') }});" class="height-equal">
                
                    <div class="over-lay"></div>
                    <ol>
                        <li><div class="icon"><i class="fa fa-calendar" aria-hidden="true"></i></div> <div class="content">{{ convertIntoDateFormate($all_sent_request['created_at']) }}</div></li>
                        <li><div class="icon"><i class="fa fa-home" aria-hidden="true"></i></div> <div class="content ellipsis">{{ $all_sent_request['property_address'] }}</div></li>
                        <li><div class="icon"><i class="fa fa-university" aria-hidden="true"></i></div> <div class="content ellipsis">{{ $all_sent_request['property_type_name']}}</div></li>
                    </ol>
                      <div class="tow-icon-btn">
                            <a href="{{ url('/property-detail').'/'. $all_sent_request['id']}}" title="View detail" ><i class="fa fa-eye"></i></a>
                           
                        </div> 

                    <div class="row bs-wizard" style="border-bottom:0;">
                        <div class="col-xs-3 bs-wizard-step complete">
                            <div class="text-center bs-wizard-stepnum">&nbsp;</div>
                            <div class="progress"><div class="progress-bar"></div></div>
                            <a href="#" class="bs-wizard-dot"></a>
                            <div class="bs-wizard-info text-center">Request <br> Received</div>
                        </div>
                        
                        <div class="col-xs-3 bs-wizard-step complete"><!-- complete -->
                            <div class="text-center bs-wizard-stepnum">&nbsp;</div>
                            <div class="progress"><div class="progress-bar"></div></div>
                            <a href="#" class="bs-wizard-dot"></a>
                            <div class="bs-wizard-info text-center">Assigned</div>
                        </div>
                    @if($all_sent_request['account_type'] == 4)
                        <div class="col-xs-3 bs-wizard-step"><!-- complete -->
                            <div class="text-center bs-wizard-stepnum">&nbsp;</div>
                            <div class="progress grey"><div class="progress-bar"></div></div>
                            <a href="#" class="bs-wizard-dot grey"></a>
                            <div class="bs-wizard-info text-center">Visit <br> Scheduled</div>
                        </div>
                        
                        <div class="col-xs-3 bs-wizard-step"><!-- active -->
                            <div class="text-center bs-wizard-stepnum">&nbsp;</div>
                            <div class="progress grey"><div class="progress-bar"></div></div>
                            <a href="#" class="bs-wizard-dot grey"></a>
                            <div class="bs-wizard-info text-center"> Visit <br>Completed</div>
                        </div>
                    @else

                        <div class="col-xs-3 bs-wizard-step complete"><!-- complete -->
                            <div class="text-center bs-wizard-stepnum">&nbsp;</div>
                            <div class="progress"><div class="progress-bar"></div></div>
                            <a href="#" class="bs-wizard-dot"></a>
                            <div class="bs-wizard-info text-center">Visit <br> Scheduled</div>
                        </div>
                        
                        <div class="col-xs-3 bs-wizard-step complete"><!-- active -->
                            <div class="text-center bs-wizard-stepnum">&nbsp;</div>
                            <div class="progress"><div class="progress-bar"></div></div>
                            <a href="#" class="bs-wizard-dot"></a>
                            <div class="bs-wizard-info text-center"> Visit <br>Completed</div>
                        </div>

                    @endif
                        
                        <div class="col-xs-3 bs-wizard-step complete"><!-- active -->
                            <div class="text-center bs-wizard-stepnum">&nbsp;</div>
                            <div class="progress"><div class="progress-bar"></div></div>
                            <a href="#" class="bs-wizard-dot"></a>
                            <div class="bs-wizard-info text-center">Report <br>Generated</div>
                        </div>
                    </div>
                    <div class="rating" id="rating{{$all_sent_request['id']}}" style="display:@if($all_sent_request['rate'] > 0 ) block; @else none; @endif">
                        @if($all_sent_request['rate'] > 0 )
                         
                            <p><i class="fa fa-star" aria-hidden="true"></i> <span>{{$all_sent_request['rate']}}.0</span>
                            @if($all_sent_request['review_description']!=null)
                             <!--span class="ellipsis">{{$all_sent_request['review_description']}}</span-->
                            @endif
                        </p>
                        
                        @endif
                    </div>
                    <div class="tow-btn">

                          @if($all_sent_request['rate'] == null )
                        <a href="#reating-star" id="review_btn{{ $all_sent_request['id'] }}" data-toggle="modal" class="theme-btn btn-style-one review_rate_popup" data-id="{{ $all_sent_request['id'] }}" style="margin-bottom:6px;"><i class="fa fa-star" aria-hidden="true"></i> Rate &amp; Review </a>
                        @endif
                        @if($all_sent_request['report_name'] != null )
                            <a href="{{asset('/storage/uploaded_reports').'/'. $all_sent_request['report_name']}}" class="theme-btn btn-style-one" download="{{$all_sent_request['report_name']}}"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download Report </a>
                        @endif    

                      
                    </div>
                </li>
                 @endforeach
            
            </ul>
        @else
            <div class="alert alert-info fade in">
              {{ trans('messages.no_report') }}
            </div>
        @endif   
        </div>
    </section>

<div id="reating-star" class="modal fade" role="dialog">
    <div class="modal-dialog reating-star">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Rate &amp; Review</h4>
            </div>
             <form id="lform" name="review-form" method="POST" >
                {{ csrf_field() }}
            <div class="modal-body">

                <div class="star">
                   <div id="rateYo"></div>
                   <span id="select_star-error" class="alert-danger parsley parsley-required danger-custom-hide">{{ trans('messages.select_rate_star') }}</span>
                   <div id="hidden_item_div" style="text-align: center;">
                      <input type="hidden" required id="rate" name="rate" value="" data-parsley-required-message="{{ trans('messages.select_rate_star') }}" />
                       </br>
                      <input type="hidden" id="sent_request_id" name="sent_request_id" value="" /> 
                  </div>
                </div>

                <textarea class="form-contro" maxlength="120" id="review_description" name="review_description" data-parsley-maxlength="120" placeholder="Write Your Review Here..."></textarea>
            </div>
            <div class="modal-footer">
              <button type="submit" id="review_submit" class="btn btn-success" >Submit</button>
            </div>

        </form>  

    <div id="succes-review" class="alert-success" style="text-align: center;background-color: #ffffff;border-color:#ffffff;display:block;padding:30px;"></div>
    <div id="error-review" class="alert-danger parsley parsley-required danger-custom-hide" style="padding: 30px !important;"></div>

            <div class="modal-footer" id="ok_div" style="display: none;">
               
                <button type="button" id="ok_buuton" class="btn btn-success" data-dismiss="modal">OK</button>
            </div>

        </div>
    </div>
</div>

@endsection

<!-- include page js script - - - -->

@section('java-script')
<script src="{{asset('js/jquery.rateyo.min.js')}}"></script>
<script type="text/javascript"  src="{{asset('js/report.js')}}"></script>

@endsection