<?php

namespace App\Http\Controllers\Investor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Properties;
use App\Models\RequestCharge;
use App\Models\SavedAddress;
use App\Models\Cart;
use App\Models\PaymentTransaction;
use App\Models\StripeCustomer;
use App\Models\SavedCard;
use App\Models\SentRequest;
use App\User;
use Illuminate\Support\Facades\Redirect;
use App\Traits\SendEmailTrait;
use Lang;
use Carbon\Carbon as Corbon;
use stdClass;
class PaymentController extends Controller
{
    
     use SendEmailTrait;

    /**
     *
     * show investor all added requests
     *
     * @param
     * 
    * @return view
     */
    public function checkout(Request $request){
            
			$user_id = \Auth::user()->id;
		    $savedcard = new SavedCard;
            $cart_model = new Cart;
            $total_cart_item = $cart_model->getCartItems($user_id);
		    $all_cards = $savedcard->getUserAllSavedCards($user_id);
            if(count($total_cart_item) > 0){
                return view('investor.checkout')->with(compact('all_cards'));
            }else{

                return Redirect::route('investor-dashboard');
            }
           
    }
   

    Public function payPayment(Request $request){


             $stripe = \Stripe\Stripe::setApiKey(config('app.stripe_secret_key'));
             $user_id = \Auth::user()->id;
             $properties_model = new Properties;
             $cart_model = new Cart;
             $sentrequest_model = new SentRequest;
             
        try{
               $total_amount_array = $cart_model->getCartItemsTotalCharge($user_id); 
               $total_cart_item = $cart_model->getCartItems($user_id);

                if(count($total_cart_item)){ //check cart items
                   
                $total_amount_array = $cart_model->getCartItemsTotalCharge($user_id);
                $total_amount = $total_amount_array[0]['totalamount'];
                
                if($request->saved_card){
                   $stripe_customer = $this->createStripeCustomer($user_id,$request->stripeToken);
                    $charge = \Stripe\Charge::create([
                        "amount" => 100*$total_amount,
                        "currency" => "aud",
                        "description" => "new property request payment",
                        "customer" => $stripe_customer->customer,
						"source" => $stripe_customer->id,
                    ]);
                    $this->saveCardInfoOnPaymentTime($charge,$user_id,$request->card_holder_name);
                }else{
                    // Charge the user's card:
                     $charge = \Stripe\Charge::create(array(
                              "amount" => 100*$total_amount,
                              "currency" => "aud",
                              "description" => "new property request payment",
                              "source" => $request->stripeToken,
                    ));
                } 
                $property_ids = $cart_model->getCartItemsPropertiesId($user_id);
                 if($charge->status == 'succeeded'){
                       $this->_saveTransactionInfo($user_id,$charge->id,$total_amount,$charge->status,$property_ids);
					   $sentrequest_model->sentNewRequest($user_id,$property_ids);
					   $cart_model->deleteCartItemByuserId($user_id);
                      $responsed_data = $this->commonEmailSender(\Auth::user()->email,$subject="Your TaxPDR request has been received",$template_name="request_recived",$site_link=null,$name=\Auth::user()->name,$data1=null);
                        return view('investor.payment-success');
                       //return Redirect::route('investor-dashboard')->with('message',Lang::get('messages.payment_success'));
                 }else{
                      
                       $this->_saveTransactionInfo($user_id,$charge->id,$total_amount,$$charge->status,$property_ids);

                 }
                 
            }else{
                        //no item add in carts
                        return Redirect::route('investor-dashboard')->with('message',Lang::get('messages.no_property_request_cart'));
            }
                
            }catch (\Stripe\Error\Card $e) {
               $body = $e->getJsonBody();
               $err  = $body['error'];
                //return response()->json(['status' => false, 'error' => $err['message'] ]);
                //no item add in carts
                return Redirect::back()->with('message',$err['message']);
              
        }
        

    }
	
	
	
	 Public function paySavedCardPayment(Request $request){

             $stripe = \Stripe\Stripe::setApiKey(config('app.stripe_secret_key'));
             $user_id = \Auth::user()->id;
             $properties_model = new Properties;
             $cart_model = new Cart;
             $sentrequest_model = new SentRequest;
			
             
        try{
               $total_amount_array = $cart_model->getCartItemsTotalCharge($user_id); 
               $total_cart_item = $cart_model->getCartItems($user_id);

                if(count($total_cart_item)){ //check cart items
                   
                $total_amount_array = $cart_model->getCartItemsTotalCharge($user_id);
                $total_amount = $total_amount_array[0]['totalamount'];
                $customer_model = new StripeCustomer;
                    $stripe_customer = $customer_model->getCustomerByUserId($user_id);
					
                    $charge = \Stripe\Charge::create([
                        "amount" => 100*$total_amount,
                        "currency" => "aud",
                        "description" => "new property request payment",
                        "customer" => $stripe_customer->stripe_customer_id,
						"source" => $request->saved_card,
                    ]);
                   
                 $property_ids = $cart_model->getCartItemsPropertiesId($user_id);
                 if($charge->status == 'succeeded'){
                       $this->_saveTransactionInfo($user_id,$charge->id,$total_amount,$charge->status,$property_ids);
					   $sentrequest_model->sentNewRequest($user_id,$property_ids);
					   $cart_model->deleteCartItemByuserId($user_id);
                       $responsed_data = $this->commonEmailSender(\Auth::user()->email,$subject="Your TaxPDR request has been received",$template_name="request_recived",$site_link=null,$name=\Auth::user()->name,$data1=null);
                       return view('investor.payment-success');
                       //return Redirect::route('investor-dashboard')->with('message',Lang::get('messages.payment_success'));
                 }else{
                      
                       $this->_saveTransactionInfo($user_id,$charge->id,$total_amount,$$charge->status,$property_ids);

                 }
                 
            }else{
                        //no item add in carts
                        return Redirect::route('investor-dashboard')->with('message',Lang::get('messages.no_property_request_cart'));
            }
                
            }catch (\Stripe\Error\Card $e) {
               $body = $e->getJsonBody();
               $err  = $body['error'];
                //return response()->json(['status' => false, 'error' => $err['message'] ]);
                //no item add in carts
                return Redirect::back()->with('message',$err['message']);
              
        }
        

    }

    private function _saveTransactionInfo($user_id,$transaction_id,$total_amount,$transaction_status,$property_ids){
        $paymenttransaction = new PaymentTransaction;
        $paymenttransaction->user_id = $user_id;
        $paymenttransaction->property_ids = $property_ids;
        $paymenttransaction->charge_id = $transaction_id;
        $paymenttransaction->amount = $total_amount;
        //$paymenttransaction->per_request_price = getChargeHelper();
        $paymenttransaction->transaction_status = $transaction_status;
        return $paymenttransaction->save();


    }


    public function createStripeCustomer($user_id,$stripetoken){
            $user = User::find($user_id);
            $stripe_customer_model = new StripeCustomer;
            try{

                $count_customer = $stripe_customer_model->getCustomerByUserId($user_id);
                if(count($count_customer) == 0){
                    // Create a Customer:
                     $customer = \Stripe\Customer::create([
                    'source' => $stripetoken,
                    'email' =>  $user->email,
                     ]);
                     $stripe_customer_model->user_id = $user_id;
                     $stripe_customer_model->stripe_customer_id = $customer->id;
    				 $stripe_customer_model->save();
                     return $customer->sources->data[0];
                }else{
                         $stripe =  \Stripe\Customer::retrieve($count_customer->stripe_customer_id);
                         return $stripe->sources->create(array("source" => $stripetoken));
    					
                }
            }catch (\Stripe\Error\Card $e) {
               $body = $e->getJsonBody();
               $err  = $body['error'];
               
               return Redirect::route('saved.cards')->with('message',$err['message']);
            }
            
           
    }

    public function saveCardInfoOnPaymentTime($charge,$user_id,$card_name=null){
             
            $savedcard_model = new SavedCard;
			$savedcard_model ->updateCardDefaultStatus($user_id);
            $savedcard_model->user_id = $user_id;
			$check_card_allready = $savedcard_model->getSavedCardByCardNumber($charge->source->last4,$user_id);
			if(count($check_card_allready) > 0){
				 $savedcard_model = SavedCard::find($check_card_allready[0]->id);
			}
            $savedcard_model->stripe_card_id = $charge->source->id;
            $savedcard_model->card_number = $charge->source->last4;
            $savedcard_model->card_name = $card_name;
            $savedcard_model->brand = $charge->source->brand;
            $savedcard_model->card_exp_month = $charge->source->exp_month;
            $savedcard_model->card_exp_year = $charge->source->exp_year;
            $savedcard_model->default_status = '1';
            return $savedcard_model->save();
           

    }
    
	
	/**
	* this function is show all saved cards function 
	*
	*@return view
	*/
    public function showSavedCard(Request $request){
		
		$user_id = \Auth::user()->id;
		$savedcard = new SavedCard;
		$all_cards = $savedcard->getUserAllSavedCards($user_id);
		return  view('investor.saved_card_profile_setting')->with(compact('all_cards'));
		
	}
	
	/**
	* this function is show all saved card form
	*
	*@return view
	*/
    public function showSavedCardForm(Request $request){
		
		$user_id = \Auth::user()->id;
		
		return  view('investor.savedCard_form');
		
	}
	
	
	/**
	* this function is show all saved card form
	*
	*@return view
	*/
    public function saveSavedCard(Request $request){
		
		$user_id = \Auth::user()->id;
		$card = new stdClass();
		$stripe = \Stripe\Stripe::setApiKey(config('app.stripe_secret_key'));
		$card = $this->createStripeCustomer($user_id,$request->stripeToken);
		$this->_savesavedCardWithOutCharge($card,$user_id,$request->card_holder_name);
		return Redirect::route('saved.cards')->with('message',Lang::get('messages.card_saved'));
		
	}

    /**
    * this function is show all saved card form
    *
    *@return view
    */
    public function changeDefaultCard(Request $request){
        
        $user_id = \Auth::user()->id;
       
        if($request->id == '' || $request->id == null || $request->id <= 0){
             $result['status'] = 'false';
             $result['error_message'] = Lang::get('messages.no_card_selected');
        }else{
              $id = $request->id;
              $savedcard_model = new SavedCard;
              if($savedcard_model->updateDefaultCard($user_id,$id)){
                $result['status'] = 'true';
                $result['error_message'] = Lang::get('messages.card_set_default');
                
              }else{
                $result['status'] = 'false';
                $result['error_message'] = Lang::get('error_code.1003');
                
              }
              
        }
        return response()->json($result);
    }

	
	private function _savesavedCardWithOutCharge($card,$user_id,$card_name=null){
		
		    $savedcard_model = new SavedCard;
			$savedcard_model ->updateCardDefaultStatus($user_id);
            $savedcard_model->user_id = $user_id;
			$check_card_allready = $savedcard_model->getSavedCardByCardNumber($card->last4,$user_id);
			if(count($check_card_allready) > 0){
				 $savedcard_model = SavedCard::find($check_card_allready[0]->id);
			}
            $savedcard_model->stripe_card_id = $card->id;
            $savedcard_model->card_number = $card->last4;
            $savedcard_model->card_name = $card_name;
            $savedcard_model->brand = $card->brand;
            $savedcard_model->card_exp_month = $card->exp_month;
            $savedcard_model->card_exp_year = $card->exp_year;
            $savedcard_model->default_status = '1';
            $savedcard_model->save();
	}
	
	
	
	
	/**
	* this function is used to remove a card 
	*
	*@return view
	*/
    public function deleteSavedCard(Request $request){
		
		    $savedcard = new SavedCard;
            $id = $request->id;
            $user_id = \Auth::user()->id;
			$validate = $savedcard->validateDelete($id,$user_id);
			if($validate == true){
				  \Stripe\Stripe::setApiKey(config('app.stripe_secret_key'));
				  $stripe_customer_model = new StripeCustomer;
                  $count_customer = $stripe_customer_model->getCustomerByUserId($user_id);
				 if(count($count_customer) > 0){
					  $customer = \Stripe\Customer::retrieve($count_customer->stripe_customer_id);
					  $card_data = SavedCard::find($id);
                      //$customer->sources->retrieve($card_data->stripe_card_id)->delete();
				  }
                 $result = $savedcard->deleteRequest($id,$user_id);
				if($result['status'] == true ){
					 $savedcard->updateLastAsdefault($user_id);
					 $all_cards = $savedcard->getUserAllSavedCards($user_id);
					 $result['count']= count($all_cards);
				}
                return response()->json($result);
			}
			
		
	}

   
}
