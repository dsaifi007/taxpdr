
@extends('layouts.admin_app')
@section('content')
    <!-- page BODY -->
   
    <div class="page-body animated slideInDown">
       
        <!--LOGO-->
        <div class="logo">
            <img alt="logo" src="{{asset('images/logo.png')}}" />
        </div>
        <div class="box">
            <!--SIGN IN FORM-->
            <div class="panel mb-none">
                <div class="panel-content bg-scale-0">
                 

                 <h3>Reset Password</h3>
                       
                         @if(Session::has('error_mesg'))
                            <p class="{{ Session::has('error_mesg') ? ' has-error' : '' }}">
                                 <span class="help-block">
                                        <strong>{{ Session::get('error_mesg') }}</strong>
                                    </span></p>
                    @endif
                    <form method="POST" action="{{ route('restnewpassword') }}" data-parsley-validate="" id="lform">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">
                        
                         <div class="form-group mt-md {{ $errors->has('password') ? ' has-error' : '' }}" id="#email-group">
                            <span class="input-with-icon">
                              <input placeholder="Password" class="form-control" id="password" type="password" name="password" required data-parsley-required-message = "Password is required" data-parsley-minlength-message="It should have minmum 6 characters" data-parsley-minlength="6" />
                               @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </span>
                        </div>
                          <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <span class="input-with-icon">
                            <input placeholder="Repeat Password" id="password-confirm" type="password" class="form-control" name="password_confirmation" required data-parsley-required-message = "Repeat pssword is required" data-parsley-equalto="#password"/>
                                 <span class="errorspanconfirmnewpassinput"></span>
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </span>
                        </div>
                         <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">Update Password</button>
                        </div>
                        </form>
                </div>
            </div>
        </div>
    </div>

@endsection
<!-- include page js script - - - -->

@section('java-script')

<script type="text/javascript">
$(function () {
  $('#lform').parsley().on('field:validated', function() {
    var ok = $('.parsley-error').length === 0;
    $('.bs-callout-info').toggleClass('hidden', !ok);
    $('.bs-callout-warning').toggleClass('hidden', ok);
  })
  .on('form:submit', function() {
    return true; // Don't submit form for this demo
  });
});

$("#home_li").removeClass("current");
$("#signin_li").removeClass("current");
$("#signup_li").addClass("current");
$("#how-it-works_a").attr("href", "{{url('/#how-it-works')}}");
$("#features-section_a").attr("href", "{{url('/#features-section')}}");
$("#screenshots-section_a").attr("href", "{{url('/#screenshots-section')}}");
$("#home_a").attr("href", "{{url('/')}}");
</script>

@endsection
