@extends('layouts.investor_app')



@section('content')

<section>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="sp-column ">
                    <div class="sp-page-title" style="background-image: url({{ asset('images/breadcrumb1.jpg') }} );">
                        <div class="container"><h2>Chackout</h2>
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
                <div class="col-md-12">
                    <div class="panel with-nav-tabs panel-primary">
                        <div class="panel-heading">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab1primary" data-toggle="tab">Credit Card Or Debit Card</a></li>
                                <li ><a href="#tab2primary" data-toggle="tab">Saved Cards</a></li>
                            </ul>
                        </div>
                        <div class="panel-body">
                            <div class="tab-content">
                             
                                <div class="tab-pane active" id="tab1primary">
                                   <form action="{{ route('investor.pay.payment') }}" method="post" id="payment-form">

                                   {{ csrf_field() }}
                                        <div class="form-row">
                                            <label for="card-element" style="margin-bottom:15px;">
                                              Credit or debit card
                                            </label>
                                            <div id="card-element" >
                                              
                                            </div>
                                            <div id="card-errors" role="alert"></div>
                                        </div>

                                         <div class="form-row">
                                           <input type="checkbox" checked name="saved_card" value="1" /> saved card
                                         </div>
                                        <div class="modal-footer" style="margin-top:15px;padding-right:0px;">
                                          <button class="button" type="sumbit" id="paybystrip" style="padding: 7px 25px;">Pay Now</button>
                                          
                                         
                                          </div>
                                    </form> 

                                </div> 

                                <div class="tab-pane fade" id="tab2primary">
								@if(count($all_cards))
								<form action="{{ route('investor.pay.savedcard.payment') }}" method="post" id="saved-card-form">
							 {{ csrf_field() }}
                                    <div class="add-payment">
                                        <ul>
                                           
											@foreach($all_cards as $card)
												<li class="clearfix" id="saved_card_id{{ $card->id }}">
													<p>xxxxxxxxxxxxx{{ $card->card_number }} <br>{{ $card->card_exp_month }}/{{ $card->card_exp_year }}</p>
													<div class="wrap">
														<div class="pull-left">
														   													
															<!--a href="#delete-proper-ty" data-id="{{ $card->id }}" data-toggle="modal" class="open_confirm1">Remove</a-->
														</div>
														<div class="pull-right">
															<img src="{{ asset('images/visa-icon.png') }}" alt="">
														</div>
														<input type="radio" name="saved_card" value="{{$card->stripe_card_id }}"  @if($card->default_status =='1') checked @endif />
													</div>
												</li>
												@endforeach
											
                                        </ul>
										 <button class="button" type="sumbit" id="paysavedcard" style="padding: 7px 25px;">Pay Now</button>
                                    </div>
									</form>
									@else
										<div class="add-payment">
                                        <ul>
                                             <li class="center">
                                                <a href="{{route('saved.new.card')}}">
                                                    <center><img src="{{ asset('images/add-plus.png')}}" alt=""></center>
                                                    <p>Add Payment Method</p>
                                                </a>
                                            </li>
                                        </ul>
										 <button class="button" type="sumbit" id="paysavedcard" style="padding: 7px 25px;">Pay Now</button>
                                    </div>
									@endif
                                    <p>Remember: Tax PDR will never ask you to wire money. <a href="#">Learn more</a>.</p>
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
 <script type="text/javascript" src="https://js.stripe.com/v3/"></script>

<script type="text/javascript">
      
//Stripe code start   
// Create a Stripe client

var stripe = Stripe('pk_test_DVcvnjEEw3f0ziNdpxGJo5jJ');
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
    color: '#e5424d',
    ':focus': {
      color: '#303238',
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
    //console.log('raviraj');
    //console.log(token);    
    
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
            // var pack_amount = $('#stripe_amount').val();
            // var url = "{{ route('investor.pay.payment') }}";
            // var form_new = $('#payment-form');
            // $.ajax({ 
            //     type: "POST",
            //     url: form_new.attr( 'action' ),
            //     data: form_new.serialize(),
            //     success: function (response) {
            //         if(response.status == true){
            //              console.log(response);
            //              //$('#AuctionTypeForm').submit();
            //         }else{
                        
            //               console.log(response);
            //         }
                  
            //     }
            // });
  
   
}  


       </script>

   
@endsection