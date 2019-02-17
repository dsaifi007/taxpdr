@extends('layouts.investor_app')
@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css" /> 
@endsection
@section('content')

 <section>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="sp-column ">
                    <div class="sp-page-title" style="background-image: url({{asset('images/breadcrumb1.jpg')}});">
                        <div class="container"><h2>Property Details</h2>
                            <ol class="breadcrumb">
                                <li>You are here: &nbsp;</li>
                                <li><a href="#" class="pathway">Property Details</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="my-request property-detials">
        <div class="auto-container">
            <div class="row">
                <div class="row bs-wizard" style="border-bottom:0;">
                      
                        <div class="col-xs-3 bs-wizard-step  @if($property_details['request_status'] >= 1) complete @else active @endif">
                            <div class="text-center bs-wizard-stepnum">&nbsp;</div>
                            <div class="progress"><div class="progress-bar"></div></div>
                            <a href="#" class="bs-wizard-dot"></a>
                            <div class="bs-wizard-info text-center">Request <br /> Received</div>
                        </div>
                        
                         
                        <div class="col-xs-3 bs-wizard-step @if($property_details['request_status'] > 2) complete @elseif($property_details['request_status'] == 2) complete @else disabled @endif"> <!-- complete -->
                            <div class="text-center bs-wizard-stepnum">&nbsp;</div>
                            <div class="progress"><div class="progress-bar"></div></div>
                            <a href="#" class="bs-wizard-dot"></a>
                            <div class="bs-wizard-info text-center">Assigned</div>
                        </div>
                        
                    @if($property_details['account_type'] == 4)
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
                         <div class="col-xs-3 bs-wizard-step @if($property_details['request_status'] > 3) complete @elseif($property_details['request_status'] == 3) complete @else disabled @endif"><!-- complete -->
                            <div class="text-center bs-wizard-stepnum">&nbsp;</div>
                            <div class="progress"><div class="progress-bar"></div></div>
                            <a href="#" class="bs-wizard-dot"></a>
                            <div class="bs-wizard-info text-center">Visit <br /> Scheduled</div>
                        </div>
                       
                        
                        <div class="col-xs-3 bs-wizard-step @if($property_details['request_status'] >4) complete @elseif($property_details['request_status'] == 4) complete @else disabled @endif"><!-- active -->
                            <div class="text-center bs-wizard-stepnum">&nbsp;</div>
                            <div class="progress"><div class="progress-bar"></div></div>
                            <a href="#" class="bs-wizard-dot"></a>
                            <div class="bs-wizard-info text-center"> Visit <br />Completed</div>
                        </div>
                    @endif    
                        
                        <div class="col-xs-3 bs-wizard-step @if($property_details['request_status'] > 5) active @elseif($property_details['request_status'] == 5) complete @else disabled @endif"><!-- active -->
                            <div class="text-center bs-wizard-stepnum">&nbsp;</div>
                            <div class="progress"><div class="progress-bar"></div></div>
                            <a href="#" class="bs-wizard-dot"></a>
                            <div class="bs-wizard-info text-center">Report <br />Generated</div>
                        </div>
                    </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="box-text clearfix">
                        <div class="row">
                            <div class="form-group col-md-4 col-sm-12">
                                <h2>Property Address</h2>
                                <p>{{$property_details['property_address']}}</p>
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <h2>Suburb</h2>
                                <p>{{$property_details['suburb']}}</p>
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <h2>State</h2>
                                <p>{{getStateById($property_details['state'])}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4 col-sm-12">
                                <h2>Year of Construction</h2>
                                <p>{{$property_details['construction_year']}}</p>
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <h2>Year of Purchase</h2>
                                <p>{{$property_details['purchase_year']}}</p>    
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <h2>Property Purchase Price </h2>
                                <p>${{$property_details['purchase_price']}}(AUD)</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4 col-sm-12">
                                <h2>Floor Area</h2>
                                <p>@if($property_details['floor_area'] != null)
                                   {{$property_details['floor_area']}}
                                 @else
                                 N/A
                                 @endif   
                               </p>
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <h2>Floor Area Unit</h2>
                                <p>
                                    @if($property_details['floor_area_unite'] == 'sqmt')
                                        Sq. Metres
                                    @else
                                    Squares
                                    @endif
                                       
                                </p>
                            </div>

                        <div class="form-group col-md-4 col-sm-12">
                            <h2>Property Type</h2>
                            <p>{{$property_details['property_type_name']}}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4 col-sm-12">
                            <h2>Was the property purchased new?</h2>
                            <p>{{ ucfirst($property_details['property_new_status'])}}</p>
                        </div>

                    </div>
                    </div>
                </div>
            </div>
            <div class="row">
               @if($property_details['rate']) 
                    <div class="col-md-6 col-sm-12">
                        <div class="box-text">
                            <h2><i class="fa fa-briefcase"></i> Review &amp; Rating</h2>
                            <div class="star">
                                <div id="rateYo"></div>
                             </div>
                            <p style="font-size: 14px;">{{ $property_details['review_description'] }}</p>
                        </div>
                    </div>
                @endif
                @if($property_details['report_name']) 
                    <div class="col-md-6 col-sm-12">
                        <div class="box-text">
                            <h2><i class="fa fa-file-pdf-o"></i> Download Report</h2>
                            <a href="{{asset('/storage/uploaded_reports').'/'. $property_details['report_name']}}" class="theme-btn btn-style-one" download="{{$property_details['report_name']}}"><i class="fa fa-download"></i> Download</a>
                        </div>
                    </div>
               @endif 
            </div>
        </div>
    </section>
@endsection

<!-- include page js script - - - -->

@section('java-script')
<script src="{{asset('js/jquery.rateyo.min.js')}}"></script>
<script type="text/javascript">

    $(function () {
  $("#rateYo").rateYo({
    rating: {{$property_details['rate']}},
    readOnly: true,
    starWidth: "22px"
  });
  });
 

   
</script>

@endsection