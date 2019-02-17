@extends('layouts.investor_app')

@section('content')

<section>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="sp-column ">
                    <div class="sp-page-title" style="background-image: url({{ asset('images/breadcrumb1.jpg')}});">
                        <div class="container"><h2>Profile</h2>
                            <ol class="breadcrumb">
                                <li>You are here: &nbsp;</li>
                                <li><a href="index" class="pathway">Profile</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



  <section class="my-request create-request prop-cal">
        <div class="auto-container">
		 
            <div class="row">
			
                <div class="col-sm-12">
                    <div class="main-body">
					<div class="alert-success"  id="success-msg" style="text-align: center;background-color: #ffffff;border-color:#ffffff;display:none;padding:0px !important;margin-bottom0px !important;">
           </div>
		   <div class="alert-danger parsley parsley-required"  id="error_message" style="text-align: center;background-color: #ffffff;border-color:#ffffff;display:none;padding:0px !important;margin-bottom0px;!important;">
           </div>
                        <div class="body-inner">
                            <div class="card bg-white">
							
							<form  method="POST" action="{{ route('update.profile') }}" id="lform" autocomplete="off">
                        {{ csrf_field() }}
                                <div class="card-content">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                                <label>Name</label>
                                                 <input placeholder="Name" class="form-contro" autocomplete="off" name="name"  id="name" value="{{ \Auth::user()->name}}" required  type="text"  style="text-transform: capitalize;" />
                                  @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                                            </div>
                                        </div>
                                         <div class="col-md-4 col-sm-12 col-xs-12">
                                             <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} {{ Session::has('error_mess') ? ' alert alert-danger parsley' : '' }}">
											 <label>Email</label>
                                <input placeholder="Email" autocomplete="off" id="email" class="form-contro" type="email" name="email" value="{{ \Auth::user()->email}}" required />
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
                                        </div>
                                        <div class="col-md-4 col-sm-12 col-xs-12">
                                            <div class="row">
                                                <div class="col-md-4" style="padding-right: 0;">
                                                    <div class="form-group country_co-de">
                                                        <label>Country code</label>

                                                        <input type="text" country_code" name="country_code" class="form-contro" placeholder="Country Code" required="" value="{{\Auth::user()->country_code}}" maxlength="6"/>
                                                         
                                                    </div>        
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group{{ $errors->has('mobile_no') ? ' has-error' : '' }}">
                                                        <label>Phone</label>
                                                       <input placeholder="Mobile or Landline Number" class="form-contro" autocomplete="off" name="mobile_no" value ="{{ \Auth::user()->mobile_no }}" id="mobile_no" required="" type="tel" data-parsley-minlength-message="This value is too short. It should have 10 characters" data-parsley-minlength="10"  data-parsley-pattern="^[0-9]{1,10}$" />
                                         @if ($errors->has('mobile_no'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('mobile_no') }}</strong>
                    
                                @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                    @if(\Auth::user()->role_category == 'valuer')
                     <div class="row">
                          <div class="col-md-6 col-sm-12 col-xs-12">  
                                   <div class="form-group{{ $errors->has('licence_number') ? ' has-error' : '' }}">
                                                <label>Lic No</label>
                                                 <input placeholder="License Number" class="form-contro" autocomplete="off" name="licence_number"  id="licence_number" value="{{ \Auth::user()->licence_number}}" required  type="text"  style="text-transform: capitalize;" />
                                  @if ($errors->has('licence_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('licence_number') }}</strong>
                                    </span>
                                @endif
                                            </div>
                         </div>
                          <div class="col-md-6 col-sm-12 col-xs-12"> 
                              <div class="form-group"> 
                                <label>State</label>
                                    <select name="state" id="state" class="form-contro">
                                       <?php $all_states = getAllStates(); ?>
                                       @foreach($all_states as $state)
                                           <option value="{{ $state->id}}" @if(old('state') == $state->id) selected @elseif($state->id == \Auth::user()->state) selected @endif>{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                  </div>
                              
                         </div>
                    </div>    
                  @endif

                                    <div class="tow-btn text-center">
                                        <button type="submit" id="updateProfile" class="theme-btn btn-style-one">Save</button>
                                    </div>
                                </div>
								</form>
                            </div>
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


$(document).ready( function() {

    $(document.body).click(function() {
         $('#error_message').hide();
        $('#success-msg').hide();       
   });

	
	  $("#home_li").removeClass("current");
    $("#calculator_li").removeClass("current");
    $("#report_li").removeClass("current");
    $("#profile_id").addClass("current");

  $('#lform').on('submit', function(e){
	  e.preventDefault(); //=== To Avoid Page Refresh and Fire the Event "Click"===
  if ( $(this).parsley().isValid() ) {
  var form = $('#lform');

        $.ajax( {
          type: "POST",
          url: form.attr( 'action' ),
          data: form.serialize(),
          success: function( response ) {
				if(response.status == true){
				  $('#success-msg').html(response.message);
				  $('#success-msg').show();
				}else{
					$('#error_message').html(response.error_message);
					$('#error_message').show();
				}
							
				    
				
			  }
           
        });
  }
     }); 
	 
});
</script>
@endsection