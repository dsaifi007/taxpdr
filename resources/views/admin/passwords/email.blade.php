@extends('layouts.admin_app')
@section('content')
    <!-- page BODY -->
    <div class="page-body  animated slideInDown">
        <div class="logo">
            <img alt="logo" src="{{ asset('images/logo.png')}}" />
        </div>
        <div class="box">
            <div class="panel mb-none">
                <div class="panel-content bg-scale-0">
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
                    <form method="POST" action="{{ route('admin.sendforgotlink') }}" data-parsley-validate="" id="lform">
                        {{ csrf_field() }}
                        <h4>Forgot your password?</h4>
                        <div class="form-group mt-md{{ $errors->has('email') ? ' has-error' : '' }}" id="#email-group">
                            <span class="input-with-icon">
							<input placeholder="Email" id="email" class="form-control" type="email"  name="email" value="{{ old('email') }}" value="{{ old('email') }}"   
                                 data-parsley-required-message = "Email is required" data-parsley-class-handler= "#email-group" required = "required"/>
								 <input type="hidden" name = "account_type" id="account_type" value="1"/>
                                <i class="fa fa-envelope"></i>
								 @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </span>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block ">Send</button>
                        </div>
                        <div class="form-group text-center">
                            You remembered?, <a href="{{route('admin.adminlogin')}}">Sign in!</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
<!-- include page js script - - - -->

@section('java-script')

@endsection
