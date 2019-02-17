@extends('layouts.investor_app')
@section('content')


<section>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="sp-column ">
                    <div class="sp-page-title" style="background-image: url({{ asset('images/breadcrumb1.jpg')}} );">
                        <div class="container"><h2>Send Request</h2>
                            <ol class="breadcrumb">
                                <li>You are here: &nbsp;</li>
                                <li><a href="#" class="pathway">Checkout</a></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="my-request send-request">
        <div class="auto-container">
            <div class="row">
                <div class="col-md-8 col-sm-12 send-request-left">
                    <h3>Request Information</h3>

                    <p class="has-error"><span id="no_property_found" class=" has-error help-block"></span></p>
                     @if(count($all_properties) > 0)
                    <ul class="card-property" id="card-property" >
                     
                        @foreach($all_properties as $property)
                         <span id="error_li{{$property['id'] }}"></span>
                        <li id="remove_li{{$property['id'] }}" style="background-image: url({{ asset('images/image'.rand(1,3).'.jpg') }});">
                            <div class="over-lay"></div>
                            <ol>
                                <li><div class="icon"><i class="fa fa-calendar" aria-hidden="true"></i></div> <div class="content">{{ convertIntoDateFormate( $property['updated_at']) }}</div></li>

                                <li><div class="icon"><i class="fa fa-home" aria-hidden="true"></i></div> <div class="content">{{ $property['property_address'] }}  </div></li>           

                                  <li><div class="icon"><i class="fa fa-university" aria-hidden="true"></i></div> <div class="content">{{ $property['property_type_name']}}</div></li>

                                   <li><div class="icon"><i class="fa fa-usd" aria-hidden="true"></i></div> <div class="content">{{ $property['purchase_price']}} <strong>(AUD)</strong></div></li>


                            </ol>			 
							
                            <div class="delete-icon" >
							                   <a href="#edit-proper-ty" class="edit-property" data-edit-id= "{{ $property['id'] }}" data-property-id = "{{ $property['id'] }}" data-toggle="modal"   ><i class="fa fa-edit"></i></a>
                                <a href="#delete-proper-ty" class="open_confirm" data-id = "{{ $property['id'] }}"  data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </div>
                        </li>
                        @endforeach
                     
                    </ul> 
                     @else

                     <div class="alert alert-info fade in">

   {{ trans('messages.no_item_cart') }}
</div>
                      

                      @endif     
                </div>
                <div class="col-md-4 col-sm-12 send-request-right">
                    <div class="box_general_3 booking">
                        <form name = "charge-form" id = "#lform" method="POST" action="#">
                           <div id="charges">
                            <div class="title">
                                <h3>Charges</h3>
                            </div>

                            <div class="summary">
                                <ul>
                                    <li>Date: <strong class="pull-right">{{ date('d/m/Y') }}</strong></li>
                                </ul>
                            </div>
                            <ul class="treatments checkout clearfix">
                                <?php $i = 1; 
                                       $totalcount = 0;
                               
                               foreach($all_properties as $property2){
                                    $charge = getChargeHelper($property2['construction_year'],$property2['property_new_status']);
                                    if($totalcount == 0){
                                        $totalcount = $charge; 
                                    }
                                    else {
                                       
                                        $totalcount =  $totalcount+$charge;
                                    }
                                   ?>
                                <li>
                                    Request {{ $i++ }} <strong class="pull-right">${{ $charge }}(AUD)</strong>
                                </li>

                                <?php
                                     }
                                ?>
                                <!--<li>-->
                                <!--	Refferal Amount <strong class="pull-right">$55</strong>-->
                                <!--</li>-->
                                <li class="total">
                                    Total  <strong class="pull-right">${{ $totalcount }}(AUD)</strong>
                                </li>
                            </ul>
                            <input type="hidden" name="total_amount"  id="total_amount" value="{{ $totalcount }}"/>
                            <hr>
                            @if(count($all_properties) == 0)
                                 <a href="#" class="btn_1">Checkout</a>
                            @else
                               <a href="{{ route('investor.checkout') }}" class="btn_1">Checkout</a>
                            @endif
                            </div><!--  end charges div -->

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

	
 @endsection
    <!-- include page js script - - - -->

    
@section('java-script')
<script type="text/javascript" >
$("#home_li").removeClass("current");
$("#report_li").removeClass("current");
$("#profile_id").removeClass("current");
$("#checkout_li").addClass("current");

$(document).delegate('.delete-property','click', function(){
       var id = $(this).attr("data-id");
        $.ajax({
           url: "{{route('investor.delete.current.request')}}",        
           async: true,
           type:'GET',
           dataType: 'json',
           data: {id : id},
           success: function(response){
               if(response.status == true){
                   $('#remove_li'+id).hide();
                   $('#charges').html(response.html);
                   if(response.count == 0){
                      $('#no_property_found').html("{{trans('messages.no_request')}}");
                    
                   }
					   $('.checkout_count').html(response.count);
				  
               }else{
                     $('#error_li'+id).html(response.message);
                     $('#error_li'+id).css("color", "#a94442");
                     $('#error_li'+id).css("font-size", "13px");
               }
            }
        });
			
    
    });	
		
	$('.edit-property').on('click', function(){
       
        var id = $(this).attr("data-edit-id");
         var property_id = $(this).attr("data-property-id");
		
        $.ajax({
           url: "{{route('investor.edit.newly.saved.request')}}",        
           async: true,
           type:'GET',
           dataType: 'json',
           data: {id : id,property_id:property_id},
           success: function(response){
               //console.log(response.html);
               if(response.status == true){
                 // console.log('error');
                   $('#show_edit_property').html(response.html);
                        commonvalidation1();
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
		

 

//remove saved address confirm box pop code
$('.open_confirm').on('click', function(){
	
       var id = $(this).attr("data-id");
	    $('#popup_title_id').html('Remove Property');
	    $('#message_id').html('Are you sure you want to remove this property?');
        $('#delete_saved_address').html('<a href="javascript:void(0)" data-id = "'+id+'" class="theme-btn btn-style-one delete-property" data-dismiss="modal">Remove</a>');
});

    </script>

    @endsection