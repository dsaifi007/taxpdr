@extends('layouts.app')

@section('content')

<section class="sign-in sign-up">
        <div class="auto-container">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12 sign-in-left">
                    <h3>Please fill the below details to<br /> create an account</h3>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12 sign-in-right">
                    <div class="signin">
                        <h3>Sign Up</h3>
                        <p>Register at TaxPDR by filling the below-asked details.</p>
                       
                         <form class="form-horizontal" method="POST" action="{{ route('register') }}" id="lform" autocomplete="off">
                        {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <input placeholder="Name" autocomplete="off" name="name"  id="name" value="{{ old('name') }}" required  type="text"  style="text-transform: capitalize;" />
                                  @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} {{ Session::has('error_mess') ? ' alert alert-danger parsley' : '' }}">
                                <input placeholder="Email" autocomplete="off" id="email" type="email" name="email" value="{{ old('email') }}" required />
                                 @if ($errors->has('email'))
                                    <span  class="help-block" >
                                        <span id="emailerror" >{{ $errors->first('email') }}</span>
                                    </span>
                                @endif
                                 @if(Session::has('error_mess'))
                               
                                    <span  class="help-block" style="color:#a94442;">
                                        <span id="emailerror1">{{ Session::get('error_mess') }}</span>
                                    </span>
                               
                           @endif

                            </div>
                            


                            <div class="form-group" class="form-group{{ $errors->has('mobile_no') ? ' has-error' : '' }}">
                                <div class="row">
                                    <div class="col-sm-4" style="padding-right: 0;">
                                        <input name="country_code" id="country_code" value="+61" placeholder="Country Code" required=""/>

                                    </div>
                                    <div class="col-sm-8">
                                        <input placeholder="Mobile or Landline Number" autocomplete="off" name="mobile_no" value ="{{ old('mobile_no') }}" id="mobile_no" required="" type="tel" data-parsley-minlength-message="This value is too short. It should have 10 characters" data-parsley-minlength="10"  data-parsley-pattern="^[0-9]{1,10}$" />
                                         @if ($errors->has('mobile_no'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mobile_no') }}</strong>
                    
                                @endif
                                    </div>
                                </div>
                            </div>
                           <div class="form-group{{ $errors->has('account_type') ? ' has-error' : '' }}">
                                <div class="row">
                                    <label class="col-sm-3" style="padding-right: 0; padding-top: 12px">I'm a</label>
                                    <div class="col-sm-9">
                                        <select name = "account_type" id="account_type"  >
                                            <?php $alltypes = allAccountTypes();
                                            
                                            ?>
                                           @foreach($alltypes as $type)

                                             <option data-category-name = "{{$type->category_name}}" value="{{ $type->id }}" @if(old('account_type') == $type->id) selected @endif>{{ $type->account_type }}</option>

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
                            <div class="form-group{{ $errors->has('licence_number') ? ' has-error' : '' }}">
                                <input placeholder="License Number" id="licence_number" name="licence_number" value="{{ old('licence_number') }}"  required @if( $errors->has('licence_number') || ( old('licence_number') ) ) type="text"  @else type="hidden" @endif  />
                                 @if ($errors->has('licence_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('licence_number') }}</strong>
                                    </span>
                                @endif
                            </div>


                            <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                                <div class="row" id="state_div" style="display:none;">
                                    <label class="col-sm-3" style="padding-right: 0; padding-top: 12px">State</label>
                                    <div class="col-sm-9">
                                        <select name = "state" id="state" >
                                            <?php $all_states = getAllStates(); ?>
                                     @foreach($all_states as $state)
                                         <option value="{{ $state->id}}" @if(old('state') == $state->id) selected @endif>{{ $state->name }}</option>
                                      @endforeach

                                        </select>

                                         @if ($errors->has('state'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('state') }}</strong>
                                    </span>
                                @endif
                                    </div>
                                </div>
                            </div>
                              
                             <!--div class="form-group{{ $errors->has('serve_area') ? ' has-error' : '' }}">
                                <input placeholder="Area where you can serve" id="serve_area" name="serve_area" value="{{ old('serve_area') }}" data-parsley-type="alphanum" required @if( $errors->has('serve_area') || ( old('serve_area') ) ) type="text"  @else type="hidden" @endif  />
                                 @if ($errors->has('serve_area'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('serve_area') }}</strong>
                                    </span>
                                @endif
                            </div-->


                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <input placeholder="Password" autocomplete="off" id="password" type="password" class="" name="password" required  data-parsley-minlength-message="It should have minmum 6 characters" data-parsley-minlength="6" />
                                 @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button class="theme-btn btn-style-one" type="submit">Sign Up</button>
                        </form>
                        <div class="lost-top">
                            <p><a href="{{ url('/login') }}">Already have an account, Sign In <i></i></a></p>
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
$("#home_li").removeClass("current");
$("#signin_li").removeClass("current");
$("#signup_li").addClass("current");
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