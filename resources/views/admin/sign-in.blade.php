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
                     <form class="" method="POST" action="{{ route('admin.attemptlogin') }}" data-parsley-validate="" id="lform" autocomplete="off" >
                        {{ csrf_field() }}
                        <div class="form-group mt-md {{ $errors->has('email') ? ' has-error' : '' }}" id="#email-group">
                            <span class="input-with-icon">
							<input placeholder="Email" autocomplete="off" id="email" class="form-control" type="email"  name="email" value="{{ old('email') }}"   
                                 data-parsley-required-message = "Email is required" data-parsley-class-handler= "#email-group" required = "required"/><i class="fa fa-envelope"></i>
                                 @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                
                               
                            </span>
                        </div>
                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                            <span class="input-with-icon">
                                <i class="fa fa-key"></i>
							<input placeholder="Password" id="password" class="form-control"  data-parsley-required-message = "Password is required" type="password" autocomplete="off" name="password" required />
                                 @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif                                
                            </span>
                        </div>
                        <!--div class="form-group">
                            <div class="checkbox-custom checkbox-primary">
                                <input type="checkbox"  value="option1" checked>
                                <label class="check" for="remember-me">Remember me</label>
                            </div>
                        </div-->
                        <div class="form-group">
						<button class="btn btn-primary btn-block" type="submit" >Sign In</button>
                           
                        </div>
                        <div class="form-group text-center">
                            <a href="{{route('admin.forgotPassword')}}">Forgot password?</a>
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
