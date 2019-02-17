@extends('layouts.investor_app')



@section('content')

<section>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="sp-column ">
                    <div class="sp-page-title" style="background-image: url({{ asset('images/breadcrumb1.jpg') }} );">
                        <div class="container"><h2>Add New Card</h2>
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
    
	<section class="my-request check-out save-card ">
        <div class="auto-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="create-request">
                        <div class="main-body">
                            <div class="body-inner">
                                <div class="card bg-white">
                                    <div class="card-content">
                                        <div class="box_general_3 cart">
                                             <form action="{{ route('investor.saved.new.card') }}" method="post" id="payment-form">

                                   {{ csrf_field() }}
                                        <div class="form-row">
                                            <label for="card-element" style="margin-bottom:15px;">
                                              Credit/Debit card
                                            </label>
                                             <div class="row">  
                                              <div class="col-md-6 col-sm-12" style="">  
                                               <input type="text" placeholder="Name on card" maxlength="50" onkeydown="checkvalue(this)" class="form-contro placeho"  name="card_holder_name" id="card_holder_name" />
                                                <span id="card_holder_name_error" class="alert alert-danger parsley"></span>
                                              </div>
                                            </div>
                                            <div class="row">  
                                              <div class="col-md-6 col-sm-12">
                                                  <div id="card-element" ></div>
                                                  <div id="card-errors" role="alert"></div>
                                             </div>
                                           </div>


                                        </div>

                                         
                                        <div class="" style="margin-top:15px;padding-right:0px;">
                                          <button class="button theme-btn btn-style-one" type="sumbit" id="paybystrip" style="padding: 7px 25px;">Save</button>
                                          
                                         
                                          </div>
                                    </form> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div></section>
@endsection
<!-- include page js script - - - -->
@section('java-script')
 <script type="text/javascript" src="https://js.stripe.com/v3/"></script>

<script type="text/javascript">
$(document).ready(function(){
      $("#home_li").removeClass("current");
    $("#calculator_li").removeClass("current");
    $("#report_li").removeClass("current");
    $("#profile_id").addClass("current");
	
	});
	  
//Stripe code start   
// Create a Stripe client

var stripe = Stripe('<?php echo config('app.stripe_public_key'); ?>');
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
   
}  

function checkvalue(ele) {
          var card_holder_name = document.getElementById('card_holder_name').value;
     if(card_holder_name=='' || card_holder_name == null){
       document.getElementById('card_holder_name_error').innerHTML = '';
     }
    }


       </script>

   
@endsection