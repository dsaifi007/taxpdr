

@extends('layouts.investor_app')
@section('content')
<section>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="sp-column ">
                <div class="sp-page-title" style="background-image: url({{ asset('images/breadcrumb1.jpg') }} );">
                    <div class="container">
                        <h2>Checkout</h2>
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
<section class="my-request check-out">
    <div class="auto-container">
    <div class="row">
	 <div class="alert-danger parsley parsley-required"  id="error_message1" style="text-align: center;background-color: #ffffff;border-color:#ffffff;display:none;padding:0px !important;margin-bottom0px;!important;">
	 {{ trans('messages.select_payment_type') }}
           </div>
        <div class="col-md-12">
            <div class="panel with-nav-tabs panel-primary">
                <div class="panel-body">
                    <div class="form-row">
                        <form action="@if(count($all_cards) == 0) {{ route('investor.pay.payment') }} @else  {{ route('investor.pay.savedcard.payment') }} @endif " method="post" id="payment-form">
                            {{ csrf_field() }}
                            <div class="form-row">
							
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="radio" @if(count($all_cards) == 0) checked @endif name="saved_card" value="another_card" class="">
                                        <label for="card-element" >
                                        &nbsp;Credit/Debit card
                                        </label>
                                    </div>

                                    <div class="col-md-6 col-sm-12">  
                                        <input type="text" maxlength="50" placeholder="Name on Card" onkeydown="checkvalue(this)" class="form-contro placeho"  name="card_holder_name" id="card_holder_name" />
                                        <span id="card_holder_name_error" class="alert alert-danger parsley"></span>
                                    </div>
                                    <div class="col-md-12 col-sm-12"></div>
                                    <div class="col-md-6 col-sm-12">
                                        <div id="card-element" >
                                        </div>
                                        <div id="card-errors" role="alert"></div>
                                    </div>

                                                                    </div>
                            </div>
                            <div class="form-row">
                                <input type="checkbox" checked name="saved_card" value="1" /> &nbsp;Save this card for future
                            </div>
                            @if(count($all_cards))
                            <div class="table-responsive">
                                <div class="width-in">
                                    <div class="row check-item">
                                        <div class="col-xs-3">
                                            <p>Your saved credit and debit cards</p>
                                        </div>
                                        <div class="col-xs-3">
                                            <p>Name on Card</p>
                                        </div>
                                        <div class="col-xs-3 text-center">
                                            <p>Card Number</p>
                                        </div>
                                        <div class="col-xs-3 text-center">
                                            <p>Expires on</p>
                                        </div>
                                    </div>
                                    @foreach($all_cards as $card)
                                    <div class="row check-item">
                                        <div class="col-xs-3">
                                            <p><input type="radio" name="saved_card" value="{{$card->stripe_card_id }}"  @if($card->default_status =='1') checked @endif  class="margin-right-20" /> 
                                                @if($card->brand == 'MasterCard')
                                                <img src="{{ asset('images/master-card.png') }}" alt="" /> 
                                                @elseif($card->brand == 'American Express')
                                                <img src="{{ asset('images/american-express.png') }}" alt="" /> 
                                                @elseif($card->brand == 'Diners Club')
                                                <img src="{{ asset('images/diners-club') }}" alt="" /> 
                                                @elseif($card->brand == 'Discover')
                                                <img src="{{ asset('images/discover.png') }}" alt="" /> 
                                                @elseif($card->brand == 'JCB')
                                                <img src="{{ asset('images/jcb.png') }}" alt="" /> 
                                                @elseif($card->brand == 'UnionPay')
                                                <img src="{{ asset('images/union-pay.png') }}" alt="" /> 
                                                @else
                                                <img src="{{ asset('images/visa-icon.png') }}" alt="" /> 
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-xs-3"> {{ $card->card_name }} </div>
                                        <div class="col-xs-3 text-center">
                                            <p>XXX-XXX-XXX-{{ $card->card_number }}</p>
                                        </div>
                                        <div class="col-xs-3 text-center">
                                            <p>@if($card->card_exp_month < 10)0{{ $card->card_exp_month }}@else{{ $card->card_exp_month }}@endif/{{ $card->card_exp_year }}</p>
                                        </div>
                                    </div>
                            
                            @endforeach
                                </div>
                            </div>
                            @endif
                            <div class="" style="margin-top:15px;padding-right:0px;">
                                <button class="button theme-btn btn-style-one" type="sumbit" id="paybystrip" style="display:@if(count($all_cards) == 0) block @else none @endif;padding: 7px 25px;">Pay Now</button>
                            </div>
                        </form>
                        <button class="button theme-btn btn-style-one" type="sumbit" id="paysavedcard" onclick="submitDetailsForm();" style="display:@if(count($all_cards) > 0) block @else none @endif;padding: 7px 25px;">Pay Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
<!-- include page js script - - - -->
@section('java-script')
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
    //Stripe code start   
    // Create a Stripe client
    
    var stripe = Stripe('<?php echo config('app.stripe_public_key') ; ?>');
    // Create an instance of Elements
     var elements = stripe.elements();
    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
    var style = {
      base: {
        color: '#303238',
        fontSize: '16px',
        fontFamily: '"Open Sans", sans-serif',
        fontSmoothing: 'antialiased',
        '::placeholder': {
          color: '#CFD7DF',
        },
      },
      invalid: {
        color: '#a94442',
        ':focus': {
          color: '#a94442',
        },
      },
    };
    
    // Create an instance of the card Element
    var card = elements.create('card', {style: style});
    
    // Add an instance of the card Element into the `card-element` <div>
    card.mount('#card-element');
    
    // Handle real-time validation errors from the card Element.
    card.addEventListener('change', function(event) {
      var displayError = document.getElementById('card-errors');
      if (event.error) {
        displayError.textContent = event.error.message;
      } else {
        displayError.textContent = '';
      }
    });
    
    // Handle form submission
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
      event.preventDefault();
      $('#paybystrip').prop('disabled', true);
      setTimeout(function(){$('#paybystrip').prop('disabled', false);},4000);
     var card_holder_name = document.getElementById('card_holder_name').value;
     if(card_holder_name=='' || card_holder_name == null){
       document.getElementById('card_holder_name_error').innerHTML = 'This field is rquired.';
       document.getElementById('card_holder_name').focus();
       return false;
     }
      stripe.createToken(card).then(function(result) {
        if (result.error) {
          // Inform the user if there was an error
          var errorElement = document.getElementById('card-errors');
          errorElement.textContent = result.error.message;
        } else {
          // Send the token to your server
          stripeTokenHandler(result.token);
        }
      });
    }); 
    function stripeTokenHandler(token) {
       
      // Insert the token ID into the form so it gets submitted to the server
      var form = document.getElementById('payment-form');
      var hiddenInput = document.createElement('input');
      hiddenInput.setAttribute('type', 'hidden');
      hiddenInput.setAttribute('name', 'stripeToken');
      hiddenInput.setAttribute('id', 'stripeToken');
      hiddenInput.setAttribute('value', token.id);
      form.appendChild(hiddenInput);
    
      // Submit the form
      form.submit();
      
       
    }  
    
    function submitDetailsForm() {
		 //$('#error_message').hide();
		 var checked_size = $('input[type=radio]:checked').size();
		if (checked_size == 0) {
			console.log(checked_size);
			$('#error_message1').show();
                //$('#error_message').html("Please select any payment method.");
				
				return false;
            }
			
       $("#payment-form").submit();
    }
    
    function checkvalue(ele) {
          var card_holder_name = document.getElementById('card_holder_name').value;
     if(card_holder_name=='' || card_holder_name == null){
       document.getElementById('card_holder_name_error').innerHTML = '';
     }
    }
    
    $(document).ready(function() {
		 
		
    $('input:radio[name=saved_card]').change(function() {
		 $('#error_message1').hide();
        var radio_val = $('input[name=saved_card]:checked' ).val();
        if (radio_val == 'another_card') {
         
           $('#paysavedcard').hide();
           $('#paybystrip').show();
           $('#payment-form').attr("action", "{{ route('investor.pay.payment') }}");
		   
        }
        else{
            $('#paybystrip').hide();
            $('#paysavedcard').show();
            $('#payment-form').attr("action", "{{ route('investor.pay.savedcard.payment') }}");
        }
       
    });
    });
           
</script>
@endsection

