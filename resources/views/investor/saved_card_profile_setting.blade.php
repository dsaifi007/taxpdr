@extends('layouts.investor_app')

@section('content')

<section>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="sp-column ">
                <div class="sp-page-title" style="background-image: url({{ asset('images/breadcrumb1.jpg')}} );">
                    <div class="container"><h2>Saved Card</h2>
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
	<div class="alert alert-success" style="text-align: center;background-color: #ffffff;border-color:#ffffff;display:none;">
        {{ Session::get('message') }}
    </div>
    <div class="auto-container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel with-nav-tabs panel-primary">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <li ><a href="{{route('profile-setting')}}" >Change Password</a></li>
                            <li class="active"><a href="{{ route('saved.cards')}}" >Saved Cards</a></li>
                            <li><a href="{{ route('investor.show.saved.request')}}" >Saved Properties</a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                         
                            <div class="tab-pane fade in active" id="saved-c">
                                <div class="add-payment" id="all_cards">
                                    <ul>
                                      @if(count($all_cards))
                                      @foreach($all_cards as $card)
                                      <li class="clearfix" id="saved_card_id{{ $card->id }}">
                                       <p class="ellipsis">{{ ucfirst($card->card_name) }}</p>
                                       <p>xxxxxxxxxxxx{{ $card->card_number }} <br>@if($card->card_exp_month < 10)0{{ $card->card_exp_month }}@else{{ $card->card_exp_month }}@endif/{{ $card->card_exp_year }}</p>
                                       <div class="wrap">
                                          <div class="pull-left">
                                             
                                              <div class="radio">
                                                  <label><input type="radio" data-id="{{ $card->id }}" value = "{{ $card->id }}" name="set_default"  @if($card->default_status =='1') checked  @endif> <span class="default_card" id="default_card{{ $card->id }}">@if($card->default_status =='1') Default @else Set Default @endif </span></label>
                                              </div>
                                            
                                              
                                              <a href="#delete-proper-ty" data-id="{{ $card->id }}" data-toggle="modal" class="open_confirm1">Remove</a>
                                          </div>
                                          <div class="pull-right">
                                            @if($card->brand == 'MasterCard')
                                            <img src="{{ asset('images/master-card-saved-card.png') }}" alt="" /> 
                                            @elseif($card->brand == 'American Express')
                                            <img src="{{ asset('images/american-express-saved-card.png') }}" alt="" /> 
                                            @elseif($card->brand == 'Diners Club')
                                            <img src="{{ asset('images/diners-club-saved-card.png') }}" alt="" /> 
                                            @elseif($card->brand == 'Discover')
                                            <img src="{{ asset('images/discover-saved-card.png') }}" alt="" /> 
                                            @elseif($card->brand == 'JCB')
                                            <img src="{{ asset('images/jcb-saved-card.png') }}" alt="" /> 
                                            @elseif($card->brand == 'UnionPay')
                                            <img src="{{ asset('images/union-pay-saved-card.png') }}" alt="" /> 
                                            @else
                                            <img src="{{ asset('images/visa-icon-saved-card.png') }}" alt="" /> 
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                                @endif
                                <li class="center add-p">
                                    <a href="{{route('saved.new.card')}}">
                                        <center><img src="{{ asset('images/add-plus.png')}}" alt=""></center>
                                        <p>Add New Card</p>
                                    </a>
                                </li>
                            </ul>
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

$(document.body).click(function() {
         $('.alert-danger').hide();
        $('.alert-success').hide();   
            
      });

    $(document).ready(function(){
       $("#home_li").removeClass("current");
       $("#calculator_li").removeClass("current");
       $("#report_li").removeClass("current");
       $("#profile_id").addClass("current");
       
       $(document).delegate('.delete-card','click', function(){
         var id = $(this).attr("data-id");
         $.ajax({
             url: "{{route('delete.card')}}",        
             async: true,
             type:'GET',
             dataType: 'json',
             data: {id : id},
             success: function(response){
                 console.log(response);
                 if(response.status == true){
                     $('#saved_card_id'+id).hide();
                     if(response.count == 0){
                      //$('#no_property_found').html("{{trans('messages.no_request')}}");
                      
                  }
                  

              }else{
                    // $('#error_li'+id).html(response.message);
                     //$('#error_li'+id).css("color", "#a94442");
                    // $('#error_li'+id).css("font-size", "13px");
                    
                }
            }
        });
         
         
     });	
     $(document).delegate('input:radio[name=set_default]:checked','change', function(){
         var id = $(this).attr("data-id");
         $('.default_card').html('Set default');
         $('#default_card'+id).html('Default');
         $.ajax({
             url: "{{route('update.setdefault.card')}}",        
             async: true,
             type:'GET',
             dataType: 'json',
             data: {id : id},
             success: function(response){
                 console.log(response);
                 if(response.status == true){
                     if(response.count == 0){
                     
                  }
                  

              }else{
                   
                }
            }
        });
         
         
     });


		//remove saved address confirm box pop code
       $('.open_confirm1').on('click', function(){
         $('.alert-success').hide();
         var id = $(this).attr("data-id");
         $('#popup_title_id').html('Remove Card');
         $('#message_id').html('Are you sure you want to remove this card?');
         $('#delete_saved_address').html('<a href="javascript:void(0)" data-id = "'+id+'" class="theme-btn btn-style-one delete-card" data-dismiss="modal">Remove</a>');
     });

   });	

</script>

@endsection