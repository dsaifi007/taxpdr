@extends('layouts.investor_app')
@section('content')
<section>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="sp-column ">
                    <div class="sp-page-title" style="background-image: url({{ asset('/images/breadcrumb1.jpg') }}) ;">
                        <div class="container"><h2>Create New Request</h2>
                            <ol class="breadcrumb">
                                <li>You are here: &nbsp;</li>
                                <li><a href="#" class="pathway">Home</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<section class="my-request check-out">
	<div class="auto-container">
		<div class="alert alert-success" style="text-align: center;background-color: #ffffff;border-color:#ffffff;padding: 0;margin:0">
			{{ Session::get('success') }}
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel with-nav-tabs panel-primary">
					<div class="panel-heading">
						<ul class="nav nav-tabs">
							@if(Session::has('success'))
							<li class=""><a href="#tab2primary" data-toggle="tab" aria-expanded="false">Add New Property</a></li>
							<li class="active" id="refresh-saved-request12"><a href="#tab1primary" data-toggle="tab" aria-expanded="true">Saved Properties</a></li>
							@else
							<li class="active"><a href="#tab2primary" data-toggle="tab" aria-expanded="true">Add New Property</a></li>
							<li class="" id="refresh-saved-request12"><a href="#tab1primary" data-toggle="tab" aria-expanded="false">Saved Properties</a></li>
							@endif
						</ul>
					</div>
					<div class="panel-body">
						<div class="tab-content">
							<div class="tab-pane  @if(Session::has('success')) active in @else fade @endif" id="tab1primary">
							  @include('investor.saved_address')
						  </div>
						  <div class="tab-pane @if(Session::has('success')) fade @else active in @endif " id="tab2primary">
							<div class="create-request">
								<div class="row">
									<div class="col-sm-12">
										<div class="card-content">
											<form id="lform" name="lform" method="POST" action="{{ route('investor.saverequest') }}" onsubmit="return checkValidDate()">
												{{ csrf_field() }}
												<div class="form-group">
													<h4 id="your_property" class="h-head">Your Property</h4>
														<!-- div class="input-group custom-search-form">
															<input type="serach" class="form-contro" placeholder="Search for on address" />
															<span class="input-group-btn">
																<button class="btn btn-default" type="button">
																	<span class="glyphicon glyphicon-search"></span>
																</button>
															</span>
														</div-->
													</div>
													<!--div class="divider">
														Or Enter Manually
													</div-->
													<div class="input_fields_wrap">
														<!-- start input_fields_wrap div - - - -->
														<div class="form-group add_more_box removeable" >
															<label>Property Address</label>
															<input type="text" name="property_address[]" id="property_address" class="form-contro" required data-required-message="{!! trans('messages.reqired_field') !!}"/>
														</div>
														<div class="row">
															<div class="col-md-6 col-sm-12">
																<div class="form-group">
																	<label>Suburb</label>
																	<input type="text" name="suburb[]" id="suburb" class="form-contro" required data-required-message="{!! trans('messages.reqired_field') !!}" />
																</div>
															</div>
															<div class="col-md-6 col-sm-12">
																<div class="form-group">
																	<label>Select State</label>
																	<select class="form-contro" name="state[]" required data-required-message="{!! trans('messages.reqired_field') !!}">

																		<?php $all_states = getAllStates(); ?>

																		<option value="" >Select State</option>
																		@foreach($all_states as $state)
																		<option value="{{ $state->id}}" >{{ $state->name }}</option>
																		@endforeach
																	</select>
																</div>
															</div>
														</div>
														
														<div class="row">
															<div class="col-md-6 col-sm-12">
																<div class="form-group">
																   <label>Year of Construction</label>

																   <select class="form-contro construction_year" name="construction_year[]" id="construction_year1" onchange="return compairyears(1);" required data-required-message="{!! trans('messages.reqired_field') !!}">
																	 
                                                                      <option value="">Select Construction Year</option>
																	 <?php 
																	 $current_year = date('Y');
																	 for ($year=2000; $year <=  $current_year; $year++){ ?>
																	 <option value="<?=$year;?>"> @if($year==2000) Pre @endif <?=$year;?></option>
																	 <?php } ?>
																 </select>
                                                                <span id="construction_error1" class="alert alert-danger parsley parsley-required construction_error" ></span>
																 
															 </div>
														 </div>
														 <div class="col-md-6 col-sm-12">
														   <div class="form-group">
															  <label>Year of Purchase </label>
															  <select class="form-contro purchase_year" id="purchase_year1" name="purchase_year[]" onchange="return compairyears(1);" required data-required-message="{!! trans('messages.reqired_field') !!}">
																	 
                                                                      <option value="">Select Purchase Year</option>
																<?php
																
																for ($year=2000; $year <= $current_year; $year++){ ?>
																<option value="<?=$year;?>"> @if($year==2000) Pre @endif <?=$year;?></option>
																<?php } ?>
															</select>

															
														</div>
													</div>
												</div>
												
												
												<div class="row">
													<div class="col-md-6 col-sm-12">
														<div class="form-group">
														   <div class="form-group">
															  <label>Property Purchase Price(AUD)</label>
															  <div class="icon-doller">
																 <input type="number" pattern="[0-9]*"  name="purchase_price[]" class="form-contro numberallow" required data-required-message="{!! trans('messages.reqired_field') !!}" data-parsley-type="digits" data-pattern-message="{!! trans('messages.valid_price') !!}" data-parsley-trigger="keyup" min="100000" data-parsley-min="100000" data-parsley-min-message="{!! trans('messages.min_property_price') !!}">
																 
															 </div>
														 </div>
													 </div>
												 </div>
												 <div class="col-md-6 col-sm-12">
												   <div class="row">
													   <div class="col-md-7">
														  <div class="form-group">
															 <label>Floor Area</label>
															 <input type="text" placeholder="Optional" name="floor_area[]" maxlength="10" data-parsley-type="number" data-type-message="{!! trans('messages.valid_area') !!}" class="form-contro numberallow">
														 </div>
													 </div>
													 <div class="col-md-5" style="padding-left: 0;">
													  <div class="form-group">
														 <label>Floor Area Unit</label>
														 <select class="form-contro" name="floor_area_unite[]" >
															
															<option value="sqmt">Sq. Metres</option>
															<option value="squares">Squares</option>
														</select>

													</div>        
												</div>
											</div>
										</div>
									</div>
									
									
									
									<div class="row">
									  <div class="col-md-6 col-sm-12">
										<div class="form-group rel-position">
										  <label style="display: block;">Property Type</label>
										   <?php $property_types = getAllPropertytypes(); 
                                             $i=1;
										   ?>
										   <label class="radio-inline" style="margin-bottom: 7px;">
										   
										   @foreach($property_types as $property_type)
										      
											   <input type="radio" value="{{ $property_type->id }}" name="property_type0" id="property_type0{{ $property_type->id }}" @if($i == 1) required data-required-message="{!! trans('messages.reqired_field') !!}"  @endif />
											   <span style="padding-right: 23px;"> {{ ucfirst($property_type->name) }}</span> &nbsp;
										 
										   <?php $i++;?>
										   @endforeach
										   
										    </label>
										
									   </div>
								   </div>
								   
								   <div class="col-md-6 col-sm-12">
									   <div class="row"> 
										  <div class="col-md-12">
											
											 <div class="form-group">
												 <label style="display: block;">Was the property purchased new?</label>
												<label class="radio-inline" style="margin-bottom: -9px;"><input name="property_new_status0" value="yes" type="radio"  required data-required-message="{!! trans('messages.reqired_field') !!}"> <span style="padding-right: 23px;">Yes</span>
												<input name="property_new_status0" value="no" type="radio" /> <span style="padding-right: 23px;">No</span></label>
											</div>        
										</div>
									</div>
								</div>
								
							</div>
							
							
							<div class="form-group">
								<input type="checkbox" class="filled-in form-check-input" checked="checked" name="saved_address0" id="checkbox0" value="1"> &nbsp;Save request for future
								
							</div>



						</div> <!-- end input_fields_wrap  - - - - -->
						<div class="tow-btn">
							<a href="#" class="theme-btn btn-style-one add_field_button">Add Another Property</a>
							<button class="theme-btn btn-style-one" type="submit" >Send Request</button>
						</div>
					</form>
					<input type="text" id="refresh" value="" />
				</div>
			</div>
		</div>
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
   //submit update form 
function compairyears(id){
	
       var construction_year = $("#construction_year"+id).val();
       var purchase_year = $("#purchase_year"+id).val();
       $('#construction_error'+id).html('');
	   $('#construction_error'+id).removeClass('new_error');
        if(construction_year > purchase_year && purchase_year !=''){
			$('#construction_error'+id).addClass('new_error');
            $('#construction_error'+id).html("Construction year can not greater than purchase year.");
           return false;
       }
}

  //submit update form 


function checkValidDate(){
	var new_error = $('.new_error').length;
	if(new_error > 0){
		return false;
	}
}
	$(document).ready(function() {

	
 function commonvalidation(){
$('.numberallow').keypress(function(e) {
	var $this = $(this);
	  if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }

	 
});
}



		setTimeout(function(){ $('.alert-success').hide(); }, 3000);

		var max_fields      = 10; //maximum input boxes allowed
		var wrapper         = $(".input_fields_wrap"); //Fields wrapper
		var add_button      = $(".add_field_button"); //Add button ID
		var x = 1; //initlal text box count
		$(add_button).click(function(e){ //on add input button click
			e.preventDefault();
			var numItems = $('.add_more_box').length;
			$('#your_property').html('Property1');
			
			var newnumIem = numItems+1;
			if(x < max_fields){ //max input box allowed
				x++; //text box increment
				$(wrapper).append('<div class="removeable"><div class="form-group add_more_box"><h4 class="h-head">Property'+newnumIem+'</h4><a href="javascript:void(0);" class="remove_field pull-right" title="Remove field"><i class="fa fa-window-close" aria-hidden="true"></i></a></div><div class="form-group"><label>Property Address</label><input type="text" class="form-contro" name="property_address[]" required data-required-message="{!! trans('messages.reqired_field') !!}" /></div><div class="row"><div class="col-md-6 col-sm-12"><div class="form-group"><label>Suburb</label><input type="text" name="suburb[]" class="form-contro" required data-required-message="{!! trans('messages.reqired_field') !!}"/></div></div><div class="col-md-6 col-sm-12"><div class="form-group"><label>Select State</label><select class="form-contro" name="state[]"required data-required-message="{!! trans('messages.reqired_field') !!}"><option value="" >Select State</option><?php $all_states = getAllStates(); ?> @foreach($all_states as $state) <option value="{{ $state->id}}" >{{ $state->name }}</option> @endforeach </select></div></div></div><div class="row"><div class="col-md-6 col-sm-12"><div class="form-group"><label>Year of Construction</label><select class="form-contro construction_year" id="construction_year'+newnumIem+'"  onchange="return compairyears('+newnumIem+');" name="construction_year[]"  required data-required-message="{!! trans('messages.reqired_field') !!}"><option value="">Select Construction Year</option><?php $current_year = date('Y');for ($year=2000; $year <=  $current_year; $year++){ ?><option value="<?=$year;?>"> @if($year==2000) Pre @endif <?=$year;?></option><?php } ?></select><span class="alert alert-danger parsley parsley-required construction_error" id="construction_error'+newnumIem+'" ></span></div></div><div class="col-md-6 col-sm-12"><div class="form-group"><label>Year of Purchase </label><select class="form-contro purchase_year"  onchange="return compairyears('+newnumIem+');" id="purchase_year'+newnumIem+'" name="purchase_year[]"  required data-required-message="{!! trans('messages.reqired_field') !!}"><option value="">Select Purchase Year</option><?php for ($year=2000; $year <= $current_year; $year++){ ?> <option value="<?=$year;?>"> @if($year==2000) Pre @endif <?=$year;?></option> <?php } ?></select></div></div></div><div class="row"><div class="col-md-6 col-sm-12"><div class="form-group"><div class="form-group"><label>Property Purchase Price(AUD)</label> <div class="icon-doller"> <input type="number" id="purchaseprice'+newnumIem+'" name="purchase_price[]" min="100000" data-parsley-min="100000" class="form-contro numberallow" required data-required-message="{!! trans('messages.reqired_field') !!}" maxlength="10" data-parsley-type="number" data-parsley-min-message="{!! trans('messages.min_property_price') !!}"> </div></div></div></div><div class="col-md-6 col-sm-12"><div class="row"><div class="col-md-7"><div class="form-group"><label>Floor Area</label><input type="text" placeholder="Optional" name="floor_area[]"  class="form-contro numberallow" maxlength="10" data-parsley-type="number"></div></div><div class="col-md-5" style="padding-left: 0;"><div class="form-group"><label>Floor Area Unit</label> <select class="form-contro" name="floor_area_unite[]" ><option value="sqmt">Sq. Metres</option><option value="squares">Squares</option> </select></div></div></div> </div> </div> <div class="row"> <div class="col-md-6 col-sm-12"><div class="form-group rel-position"><label style="display: block;">Property Type</label><label class="radio-inline" style="margin-bottom: 7px;"> <?php $property_types = getAllPropertytypes(); $i=1; ?> @foreach($property_types as $property_type)<input type="radio" class="property_type" required data-required-message="{!! trans('messages.reqired_field') !!}" value="{{ $property_type->id }}" name="property_type'+numItems+'" /><span style="padding-right: 23px;">{{ ucfirst($property_type->name) }}</span><?php $i++;?> @endforeach</label> </div> </div> <div class="col-md-6 col-sm-12"> <div class="row"> <div class="col-md-12"> <label style="display: block;" >Was the property purchased new?</label><div class="form-group" style="padding-top: 15px;"><label class="radio-inline" style="margin-bottom: -9px;"><input name="property_new_status'+numItems+'" value="yes" type="radio" class="property_new_status" required data-required-message="{!! trans('messages.reqired_field') !!}" ><span style="padding-right: 23px;">Yes</span><span style="padding-right: 23px;"><input name="property_new_status'+numItems+'" class="property_new_status" value="no" type="radio" />No</span></label></div></div></div></div></div> <div class="form-group"><input type="checkbox" class="filled-in form-check-input saved_address" name="saved_address'+numItems+'" checked="checked" value="1" id="checkbox0"> &nbsp;Save request for future</div> </div></div>'); //add input box
			}
			commonvalidation();
			
		});

		$(wrapper).on("click",".remove_field", function(e){ //user click on remove text
			e.preventDefault(); $(this).parent().parent('.removeable').remove(); x--;
			$('#lform').find('.removeable').each(function(i){
				var j = i+1;
            $(this).find(".h-head").html('Property'+j);
			$(this).find(".construction_year").attr('id', 'construction_year'+j);
			$(this).find(".construction_year").attr('onchange', 'return compairyears('+j+');');
			$(this).find(".construction_error").attr('id', 'construction_error'+j);
			$(this).find(".purchase_year").attr('id', 'purchase_year'+j);
			$(this).find(".purchase_year").attr('onchange', 'return compairyears('+j+');');
			$(this).find(".property_type").attr('name', 'property_type'+i);
			$(this).find(".property_new_status").attr('name', 'property_new_status'+i);
			$(this).find(".saved_address").attr('name', 'saved_address'+i);
		    });
		});

		$('.edit-property').on('click', function(){
		   
			var id = $(this).attr("data-edit-id");
			$.ajax({
			 url: "{{route('investor.edit.saved.request')}}",        
			 async: true,
			 type:'GET',
			 dataType: 'json',
			 data: {id : id},
			 success: function(response){
				 console.log(response.html);
				 if(response.status == 'true'){
				   
					 $('#show_edit_property').html(response.html);
					   commonvalidation();
					 $('#editform').parsley().on('field:validated', function() {
						var ok = $('.parsley-error').length === 0;
						$('.bs-callout-info').toggleClass('hidden', !ok);
						$('.bs-callout-warning').toggleClass('hidden', ok);
					})
					 .on('form:submit', function() {
		//return true; // Don't submit form for this demo
	});

				 }else{
					 //console.log('error');
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
				 console.log(response);
				 if(response.status == true){
					 $('#remove_li'+id).hide();
					 if(response.count == 0){
						$('#show_no_data_msg').html(response.message);
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



	$('.open_confirm').on('click', function(){
	  console.log($(this).attr("data-edit-id"));
	  var id = $(this).attr("data-edit-id");
	  $('#delete_saved_address').html('<a href="javascript:void(0)" data-id = "'+id+'" class="theme-btn btn-style-one delete_address" data-dismiss="modal">Delete</a>');
  });




</script>

@endsection