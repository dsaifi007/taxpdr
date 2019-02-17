@extends('layouts.app')

@section('content')

 <section class="sign-in">
        <div class="auto-container">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12 sign-in-left">
                    <h3>Enter Your Credentials to Get <br />Access of Your Account</h3>

                </div>
                <div class="col-md-6 col-sm-12 col-xs-12 sign-in-right">
                    <div class="signin">
                        <h3>Sign In</h3>
                        <p>Select your profile and sign in with you registered email address at TaxPDR.</p>
                    @if(Session::has('error_mess'))
                            <p class="{{ Session::has('error_mess') ? ' has-error' : '' }}">
                                 <span class="help-block">
                                        <strong>{{ Session::get('error_mess') }}</strong>
                                    </span></p>
                    @endif
                    
                    @if(Session::has('message'))
                        <div class="{{ Session::has('message') ? ' alert alert-success' : '' }}">
                            <span class="help-block">
                                <strong>{{ Session::get('message') }}</strong>
                            </span>
                        </div>
                    @endif
                    

                        <form class="form-horizontal" method="POST" action="{{ route('attemptlogin') }}" data-parsley-validate="" id="lform" autocomplete="off" >
                        {{ csrf_field() }}

                            <div class="form-group">
                                <div class="row">
                                    <label class="col-sm-2 text-right" style="padding-right: 0; padding-top: 12px;">I'm a</label>
                                    <div class="col-sm-10">
                                        <select name = "account_type" id="account_type" >

                                             <?php $alltypes = allAccountTypes();
                                            
                                            ?>
                                           @foreach($alltypes as $type)

                                             <option value="{{ $type->id }}" @if(old('account_type') == $type->id) selected @endif>{{ $type->account_type }}</option>

                                           @endforeach
                                            
                                        </select>
                                         @if ($errors->has('account_type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('account_type') }}</strong>
                                    </span>
                                @endif
                                    </div>
                                </div>
                            </div>
                             <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}" id="#email-group">
                                <input placeholder="Email" autocomplete="off" id="email" type="email"  name="email" value="{{ old('email') }}"   
                                 data-parsley-required-message = "Email is required" data-parsley-class-handler= "#email-group" required = "required"/>
                                 @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input placeholder="Password" id="password"  data-parsley-required-message = "Password is required" type="password" autocomplete="off" name="password" required />
                                 @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button class="theme-btn btn-style-one" type="submit" >Sign In</button>
                        </form>
                        <div class="lost-top">
                            <p><a href="{{ route('password.request') }}">Recover your password<i></i></a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    

@endsection

<!-- include page js script - - - -->

@section('java-script')

<script type="text/javascript">

$("#signup_li").removeClass("current");
$("#home_li").removeClass("current");
$("#signin_li").addClass("current");
$("#how-it-works_a").attr("href", "{{url('/#how-it-works')}}");
$("#features-section_a").attr("href", "{{url('/#features-section')}}");
$("#screenshots-section_a").attr("href", "{{url('/#screenshots-section')}}");
$("#home_a").attr("href", "{{url('/')}}");

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


</script>
@endsection