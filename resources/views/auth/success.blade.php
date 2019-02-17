
@extends('layouts.app')

@section('content')

<section>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="sp-column ">
                    <div class="sp-page-title" style="background-image: url({{ asset('/images/breadcrumb1.jpg') }}) ;">
                        <div class="container"><h2>Home</h2>
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
<section class="error-section section-min-h">
    	<div class="auto-container">
            <div class="error-big-text"></div>
            @if($message == 'success')
                   
        <div class="auto-container">
            <div class="thankyou thanx"><img alt="thankyou" src="{{ asset('images/thank-you.png') }}" />

             <p style="color:#3c763d" > {{trans('messages.success_registor')}}</p>
               
            </div>
          
        </div>
   
                </h2>
            @endif

                    @if($message == 'update_email_success')
                   
        <div class="auto-container">
            <div class="thankyou thanx"><img alt="thankyou" src="{{ asset('images/thank-you.png') }}" />

             <p style="color:#3c763d" > {{trans('messages.update_email_success')}}</p>
               
            </div>
          
        </div>
   

                </h2>
            @endif


            @if($message == '1005')
                    <br><br> <h3 style="color:#a94442">{{trans('error_code.1005')}} </h2>
           @endif

            @if($message == '1004')
                    <br><br> <h3 style="color:#a94442">{{trans('error_code.1004')}} </h2>
           @endif
            @if($message == '1003')
                    <br><br> <h3 style="color:#a94442"> {{trans('error_code.1003')}} 
             @endif
             @if($message == '1029')
                    <br><br> <h3 style="color:#a94442"> {{trans('error_code.1029')}} 
             @endif

            @if($message == 'account_verifyed')
                    <br><br> <h3 style="color:#0fad00"> {{trans('messages.account_verifyed')}} </h2>
            @endif
            <div class="error-options">
            </br></br>
            	<a href="{{ url('/login') }}" class="theme-btn btn-style-one">Go Home</a>
            </div>
        </div>
    </section>

@endsection


