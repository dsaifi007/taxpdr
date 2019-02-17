  
@extends('layouts.valuer_app')
@section('content')


<section>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="sp-column ">
                    <div class="sp-page-title" style="background-image: url({{ asset('images/breadcrumb1.jpg')}});">
                        <div class="container"><h2>Job History</h2>
                            <ol class="breadcrumb">
                                <li>You are here: &nbsp;</li>
                                <li><a href="#" class="pathway">Job History</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="my-request my-report job-history">
        <div class="auto-container">
         @if(count($all_accepted_requests) > 0)
            <ul class="card-property">
               @foreach($all_accepted_requests as $accepted_requests) 
                 <li style="background-image: url({{ asset('images/image'.rand(1,3).'.jpg') }});" class="height-equal">
                    <div class="over-lay"></div>
                        <ol>
                            <li><div class="icon"><i class="fa fa-calendar" aria-hidden="true"></i></div> <div class="content">{{ convertIntoDateFormate( $accepted_requests['created_at']) }}</div></li>
                            <li><div class="icon"><i class="fa fa-home" aria-hidden="true"></i></div> <div class="content ellipsis">{{ $accepted_requests['property_address'] }}</div></li>
                            <li><div class="icon"><i class="fa fa-university" aria-hidden="true"></i></div> <div class="content ellipsis">{{ $accepted_requests['property_type_name']}}</div></li>
                        </ol>
                         <div class="tow-icon-btn">
                            <a href="{{ url('/property-detail').'/'. $accepted_requests['id']}}" title="View detail" ><i class="fa fa-eye"></i></a>
                           
                        </div> 
                    <div class="row bs-wizard" style="border-bottom:0;">
                        <div class="col-xs-3 bs-wizard-step complete">
                            <div class="text-center bs-wizard-stepnum">&nbsp;</div>
                            <div class="progress"><div class="progress-bar"></div></div>
                            <a href="#" class="bs-wizard-dot"></a>
                            <div class="bs-wizard-info text-center">Request <br /> Received</div>
                        </div>
                        
                        <div class="col-xs-3 bs-wizard-step complete"><!-- complete -->
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


                        
                        <div class="col-xs-3 bs-wizard-step complete"><!-- active -->
                            <div class="text-center bs-wizard-stepnum">&nbsp;</div>
                            <div class="progress"><div class="progress-bar"></div></div>
                            <a href="#" class="bs-wizard-dot"></a>
                            <div class="bs-wizard-info text-center">Report <br />Generated</div>
                        </div>
                    </div>
                    @if($accepted_requests['rate'] > 0 )
                     <div class="rating">
                        <p><i class="fa fa-star" aria-hidden="true"></i> <span>{{$accepted_requests['rate']}}.0</span>
                        
                    </p>
                    </div>
                    @endif
                </li>
                @endforeach
            </ul>
        @else
            <div class="alert alert-info fade in">

                {{ trans('messages.no_job_history') }}
           </div>  
        @endif 
        </div>
    </section>

  @endsection

<!-- include page js script - - - -->

@section('java-script')
<script>
    $(document.body).click(function() {
         $('.alert-danger').hide();
        $('.alert-success').hide();   
            
      });
        $("#valuer_home_li").removeClass("current");
        $("#profile_id").removeClass("current");
        $("#valuer_job_history_li").addClass("current");
        
    </script>
@endsection