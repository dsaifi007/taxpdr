@extends('layouts.admin_app')
@section('content')
    <!-- page BODY -->
   
    <div class="page-body">
       @include('includes.admin_side_bar');
        <div class="content">
            <div class="content-header">
                <div class="leftside-content-header">
                    <ul class="breadcrumbs">
                        <li><i class="fa fa-home" aria-hidden="true"></i><a href="#">Home</a></li>
                        <li><a href="#">Manage Setting</a></li>
                    </ul>
                </div>
            </div>
            <div class="row animated fadeInUp">
                <div class="setting">
                    <div class="col-lg-offset-4 col-lg-4 col-md-6 col-md-offset-3 col-sm-12 col-sm-offset-0">
                        <div class="panel b-primary bt-sm mt-xl">
                            <div class="alert-success"  id="success-msg" style="text-align: center;background-color: #ffffff;border-color:#ffffff;display:none;padding:0px !important;margin-bottom0px !important;">
           </div>
           <div class="alert-danger parsley parsley-required"  id="error_message" style="text-align: center;background-color: #ffffff;border-color:#ffffff;display:none;padding:0px !important;margin-bottom0px;!important;">
           </div>
                            <div class="panel-content">
                               <form  method="POST" action="{{ route('update.password') }}" id="lform" autocomplete="off">
                        {{ csrf_field() }}
                                <h4 class="text-center">Change Password</h4>
                                <div class="form-group">
                                    <label for="password">Current Password</label>
                                    <input  class="form-control" type="password" name="old_password" id="old_password" required >
                                </div>
                                <div class="form-group">
                                    <label for="password">New Password</label>
                                    <input class="form-control" type="password" name="new_password" id="new_password" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Confirm Password</label>
                                    <input type="password" name="confirm_password" id="confirm_password" required class="form-control">
                                </div>
                                <div class="text-center">
                                    <input class="btn btn-wide btn-success" type="submit" id="updatepassword" value="SAVE" />
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <a href="#" class="scroll-to-top"><i class="fa fa-angle-double-up"></i></a>
    </div>
@endsection
@section('java-script')

<script type="text/javascript">
    $('#manage_investor_li').addClass('active-item');
    $('#manage_valuer_li').removeClass('active-item');
    $('#manage_request_li').removeClass('active-item');
    $('#manage_transaction_li').removeClass('active-item');
    $('#manage_content_li').removeClass('active-item');
</script> 

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
