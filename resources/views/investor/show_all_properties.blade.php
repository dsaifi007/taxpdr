@extends('layouts.investor_app')
@section('content')

<section>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="sp-column ">
                    <div class="sp-page-title" style="background-image: url({{ asset('/images/breadcrumb1.jpg') }}) ;">
                        <div class="container"><h2>My Request</h2>
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
    <section class="my-request section-min-h">
        <div class="auto-container">
		<div class="alert alert-success vali" style="text-align: center;background-color: #ffffff;border-color:#ffffff;">
                            {{ Session::get('message') }}
                        </div>
            <ul class="card-property">
                <li class="add-new height-equal">
                    <a href="{{route('investor.createrequestform')}}">
                        <div class="add-icon"><i class="fa fa-plus-circle" aria-hidden="true"></i></div>
                        <h4>Create New Request</h4>
                    </a>
                </li>
                @foreach($all_sent_requests as $all_sent_request) 
						
                <li style="background-image: url({{ asset('images/image'.rand(1,3).'.jpg') }});" id="sent_property{{$all_sent_request['id']}}" class="height-equal" >
                    <div class="over-lay"></div>
                    <ol>
                        <li><div class="icon"><i class="fa fa-calendar" aria-hidden="true"></i></div> <div class="content">{{ convertIntoDateFormate( $all_sent_request['created_at']) }}</div></li>
                        <li><div class="icon"><i class="fa fa-home" aria-hidden="true"></i></div> <div class="content ellipsis">{{ $all_sent_request['property_address'] }}</div></li>
                        <li><div class="icon"><i class="fa fa-university" aria-hidden="true"></i></div> <div class="content ellipsis">{{ $all_sent_request['property_type_name']}}</div></li>

                         <li><div class="icon"><i class="fa fa-usd" aria-hidden="true"></i></div> <div class="content ellipsis">{{ $all_sent_request['purchase_price']}} <strong>(AUD)</strong></div></li>
                    </ol>
                    @if($all_sent_request['report_name']!= null)
                      <div class="tow-icon-btn">
                            <a href="{{asset('/storage/uploaded_reports').'/'. $all_sent_request['report_name']}}" data-request-id="{{ $all_sent_request['id'] }}" class="report_view_status" title="View report" target="_blank"><i class="fa fa-eye"></i></a>
                           
                        </div> 
                    @endif    

                    <div class="row bs-wizard" style="border-bottom:0;">
					  
                        <div class="col-xs-3 bs-wizard-step  @if($all_sent_request['request_status'] >= 1) complete @else active @endif">
                            <div class="text-center bs-wizard-stepnum">&nbsp;</div>
                            <div class="progress"><div class="progress-bar"></div></div>
                            <a href="#" class="bs-wizard-dot"></a>
                            <div class="bs-wizard-info text-center">Request <br /> Received</div>
                        </div>
                        
						 
                        <div class="col-xs-3 bs-wizard-step @if($all_sent_request['request_status'] > 2) complete @elseif($all_sent_request['request_status'] == 2) complete @else disabled @endif"> <!-- complete -->
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
                            <div class="bs-wizard-info text-center">Visit <br /> Scheduled</div>
                            </div>
                       
                        
                            <div class="col-xs-3 bs-wizard-step"><!-- active -->
                                <div class="text-center bs-wizard-stepnum">&nbsp;</div>
                                <div class="progress grey"><div class="progress-bar"></div></div>
                                <a href="#" class="bs-wizard-dot grey"></a>
                                <div class="bs-wizard-info text-center"> Visit <br />Completed</div>
                            </div>
                        @else
                             <div class="col-xs-3 bs-wizard-step @if($all_sent_request['request_status'] > 3) complete @elseif($all_sent_request['request_status'] == 3) complete @else disabled @endif"><!-- complete -->
                            <div class="text-center bs-wizard-stepnum">&nbsp;</div>
                            <div class="progress"><div class="progress-bar"></div></div>
                            <a href="#" class="bs-wizard-dot"></a>
                            <div class="bs-wizard-info text-center">Visit <br /> Scheduled</div>
                            </div>
                       
                        
                            <div class="col-xs-3 bs-wizard-step @if($all_sent_request['request_status'] >4) complete @elseif($all_sent_request['request_status'] == 4) complete @else disabled @endif"><!-- active -->
                                <div class="text-center bs-wizard-stepnum">&nbsp;</div>
                                <div class="progress"><div class="progress-bar"></div></div>
                                <a href="#" class="bs-wizard-dot"></a>
                                <div class="bs-wizard-info text-center"> Visit <br />Completed</div>
                            </div>

                        @endif
                        
                        
						
                        <div class="col-xs-3 bs-wizard-step @if($all_sent_request['request_status'] > 5) active @elseif($all_sent_request['request_status'] == 5) complete @else disabled @endif"><!-- active -->
                            <div class="text-center bs-wizard-stepnum">&nbsp;</div>
                            <div class="progress"><div class="progress-bar"></div></div>
                            <a href="#" class="bs-wizard-dot"></a>
                            <div class="bs-wizard-info text-center">Report <br />Generated</div>
                        </div>
                    </div>
					
                </li>
				@endforeach
              
                
            </ul>
        </div>
    </section>

@endsection

<!-- include page js script - - - -->

@section('java-script')
<script type="text/javascript" src="{{asset('js/investor-dashboard.js')}}"></script>

@endsection