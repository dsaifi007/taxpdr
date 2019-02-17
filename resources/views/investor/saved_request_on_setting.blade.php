@extends('layouts.investor_app')

@section('content')

<section>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="sp-column ">
                    <div class="sp-page-title" style="background-image: url({{ asset('images/breadcrumb1.jpg')}} );">
                        <div class="container"><h2>Saved Properties</h2>
                            <ol class="breadcrumb">
                                <li>You are here: &nbsp;</li>
                                <li><a href="#" class="pathway">Setting</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
	
	
	<section class="my-request check-out profile-s section-min-h">
	<div class="alert alert-success server_success_" style="text-align: center;background-color: #ffffff;border-color:#ffffff;display: @if(Session::has('success')) block @else none @endif ;">
                            {{ Session::get('success') }}
                        </div>
        <div class="auto-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel with-nav-tabs panel-primary">
                        <div class="panel-heading">
                            <ul class="nav nav-tabs">
                                <li ><a href="{{route('profile-setting')}}" >Change Password</a></li>
                                <li ><a href="{{ route('saved.cards')}}" >Saved Cards</a></li>
                                <li class="active"><a href="{{ route('investor.show.saved.request')}}" >Saved Properties</a></li>
                            </ul>
                        </div>
                        <div class="panel-body">
                            <div class="tab-content">
                               
                                <div class="auto-container">
    <div class="row">
        <span id="show_no_data_msg" style="color:#0fad00"></span>
            <p class="has-error"><span id="error_select_property" class=" has-error help-block"></span></p>
            
             <form id="sendrequestform" name="lform" method="POST" action="{{ route('investor.savedaddress.save.request') }}">
        <ul class="card-property" id="svaed-request">
		<li class="add-new height-equal">
                                                <a href="#edit-proper-ty" data-toggle="modal" class="edit-property" data-edit-id="0">
                                                    <div class="add-icon"><i class="fa fa-plus-circle" aria-hidden="true"></i></div>
                                                    <h4>Add New Property</h4>
                                                </a>
                                            </li>
            @if(count($allsaved_addresses) > 0)
               @foreach($allsaved_addresses as $saved_address)
               
                                                    {{ csrf_field() }}
                 <span id="error_li{{$saved_address['id'] }}"></span>
                    <li class="nopad height-equal" style="background-image: url({{ asset('images/image'.rand(1,3).'.jpg') }});" id="remove_li{{ $saved_address['id']}}" >
                        <div class="over-lay"></div>    
                            <ol>
                                <li><div class="icon"><i class="fa fa-calendar" aria-hidden="true"></i></div> <div class="content">{{ convertIntoDateFormate( $saved_address['created_at']) }}</div></li>
                                <li><div class="icon"><i class="fa fa-home" aria-hidden="true"></i></div> <div class="content">{{ $saved_address['property_address'] }} </div></li>
                                <li><div class="icon"><i class="fa fa-university" aria-hidden="true"></i></div> <div class="content">{{ $saved_address['property_type_name']}}</div></li>
                                 <li><div class="icon"><i class="fa fa-usd" aria-hidden="true"></i></div> <div class="content">{{ $saved_address['purchase_price']}} <strong>(AUD)</strong></div></li>
                            </ol>
                       
                        <div class="tow-icon-btn">
                            <a href="#edit-proper-ty" data-toggle="modal" class="edit-property" data-edit-id="{{ $saved_address['id']}}"><i class="fa fa-edit"></i></a>
                            <a href="#delete-proper-ty" class="open_confirm" data-edit-id="{{ $saved_address['id']}}" data-toggle="modal"><i class="fa fa-trash"></i></a>
                        </div> 
                    </li>
                @endforeach

                   
            @else
                <!--span style="color:#0fad00">{{trans('messages.no_saved_requests')}}</span-->
            
            @endif   
             
        </ul>
        </form>
            
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
<script type="text/javascript" src="{{ asset('js/calculator.js') }}"></script>
<script>
  $(document.body).click(function() {
        // $('.alert-danger').hide();
        $('.server_success_').hide();   
            
      });
    $(document).ready(function() {
  
function commonvalidation(){
$('.numberallow').keypress(function(event) {
    var $this = $(this);
   if (event.which != 8 && event.which != 0 && (event.which < 48 || event.which > 57)) {
        //display error message
       // $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
});

$('.numberallow').bind("paste", function(e) {
var text = e.originalEvent.clipboardData.getData('Text');
if ($.isNumeric(text)) {
    if ((text.substring(text.indexOf('.')).length > 3) && (text.indexOf('.') > -1)) {
        e.preventDefault();
        $(this).val(text.substring(0, text.indexOf('.') + 3));
   }
}
else {
        e.preventDefault();
     }
});
  
  } 


	$("#home_li").removeClass("current");
    $("#calculator_li").removeClass("current");
    $("#report_li").removeClass("current");
    $("#profile_id").addClass("current");
  
$(document).on('click','.edit-property', function(){
         $('.alert ').hide();
        var id = $(this).attr("data-edit-id");
        $.ajax({
           url: "{{route('investor.edit.saved.request')}}",        
           async: true,
           type:'GET',
           dataType: 'json',
           data: {id : id},
           success: function(response){
               if(response.status == 'true'){
                 
                   $('#show_edit_property').html(response.html);
                    commonvalidation();
                     $('#editform').parsley().on('field:validated', function() {
        var ok = $('.parsley-error').length === 0;
        $('.bs-callout-info').toggleClass('hidden', !ok);
        $('.bs-callout-warning').toggleClass('hidden', ok);
      })
      .on('form:submit', function() {
        return true; // Don't submit form for this demo
      });

               }else{
                     console.log('error');
               }
            }
        });
    
});



$(document).delegate('.delete_address','click', function(){
        
       $('.alert-success').hide();
       var id = $(this).attr("data-id");
        $.ajax({
           url: "{{route('investor.delete.saved.request')}}",        
           async: true,
           type:'GET',
           dataType: 'json',
           data: {id : id},
           success: function(response){
               if(response.status == true){
                   $('#remove_li'+id).hide();
                   if(response.count == 0){
                        //$('#show_no_data_msg').html(response.message);
                        $('#send_saved_request').hide();
                         $('#error_select_property').hide();

                        
                   }
                   //setTimeout(function(){ $('.close').trigger("click"); }, 1000);
               }else{
                     $('#error_li'+id).html(response.message);
                     $('#error_li'+id).css("color", "#a94442");
                     $('#error_li'+id).css("font-size", "13px");
               
               }
            }
        });
});


$(document).delegate('#send_saved_request','click', function(){
    
       var numberOfChecked = $('li input:checkbox:checked').length;
       if(numberOfChecked == 0){
           $('#error_select_property').html("{{trans('messages.select_address')}}");

           
       }else{
        
            $('#sendrequestform').submit();

       }
      
});

$(document).delegate('#refresh-saved-request','click', function(){
        $.ajax({
           url: "{{route('investor.refresh.saved.request')}}",        
           async: true,
           type:'GET',
           dataType: 'json',
           success: function(response){
               if(response.status == true){
                   $('#svaed-request').html(response.html);
                   

               }else{
                     
               }
            }
        });
      
    
    }); 



    });
    
</script>
<script type="text/javascript">

    
$('.open_confirm').on('click', function(){
     $('.alert ').hide();
       var id = $(this).attr("data-edit-id");
        $('#delete_saved_address').html('<a href="javascript:void(0)" data-id = "'+id+'" class="theme-btn btn-style-one delete_address" data-dismiss="modal">Delete</a>');
});




</script>
   
@endsection
