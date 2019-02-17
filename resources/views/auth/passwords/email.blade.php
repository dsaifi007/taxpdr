@extends('layouts.app')

@section('content')

<section class="sign-in recover-password section-min-h">
        <div class="auto-container">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12 sign-in-left">
                    <h3>We just need your registered email address to send you password reset link</h3>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12 sign-in-right">
                    <div class="signin">
                        <h3>Recover Password</h3>
                        <p>To recover your TaxPDR password mention the following details.</p>
                        @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                   
                     @if (session()->has('succ-messages'))
                        <div class="alert alert-success">
                            {{ session()->get('succ-messages') }}
                        </div>
                    @endif

                    @if (session()->has('error_msg'))
                    <div class="has-error">
                                    <span class="help-block">
                                        <strong>{{ session()->get('error_msg') }}</strong>
                                    </span></div>
                     @endif
                        <form method="POST" action="{{ route('sendforgotlink') }}" data-parsley-validate="" id="lform">
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
                                <input placeholder="Email" id="email" type="email"  name="email" value="{{ old('email') }}" value="{{ old('email') }}"   
                                 data-parsley-required-message = "Email is required" data-parsley-class-handler= "#email-group" required = "required"/>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button class="theme-btn btn-style-one" type="submit">Submit</button>
                        </form>
                        <div class="lost-top">
                            <p><a href="{{ route('login') }}">Cancel and go back to Login page<i></i></a></p>
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