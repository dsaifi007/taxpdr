@extends('layouts.investor_app')

@section('content')

<section>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="sp-column ">
                    <div class="sp-page-title" style="background-image: url({{ asset('images/breadcrumb1.jpg')}} );">
                        <div class="container"><h2>Change Password</h2>
                            <ol class="breadcrumb">
                                <li>You are here:&nbsp;</li>
                                <li><a href="#" class="pathway">Setting</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
	
	<section class="my-request check-out profile-s">
        <div class="auto-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="">
                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="change-pass">
                                    <div class="change-pass">
                                        @include('auth.change_password')
                                    </div>
                                </div>
                                
                               
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
			  console.log(error_message);
				if(response.status == true){
					$('#old_password').val('');
					$('#new_password').val('');
					$('#confirm_password').val('');
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