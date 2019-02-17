<?php

namespace App\Http\Controllers\api\v1\Investor;

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
use App\Traits\SendEmailTrait;
use Illuminate\Support\Facades\Redirect;
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
            
			$user_id = \Auth::guard('api')->user()->id;
		    $savedcard = new SavedCard;
            $cart_model = new Cart;
            $total_cart_item = $cart_model->getCartItems($user_id);
		    $all_cards = $savedcard->getUserAllSavedCards($user_id);
            if(count($total_cart_item) > 0){
                return responseSuccessData($status=true,$message='data_found',count($total_cart_item),['all_cards'=>$all_cards,'total_cart_item'=>$total_cart_item]);
            }else{

                return responseSuccessData($status=true,$message='no_property_request_cart',count($total_cart_item));
            }
           
    }
   

    Public function payPayment(Request $request){

             $stripe = \Stripe\Stripe::setApiKey(config('app.stripe_secret_key'));
             $user_id = \Auth::guard('api')->user()->id;
             $properties_model = new Properties;
             $cart_model = new Cart;
             $sentrequest_model = new SentRequest;
             
        try{


               $total_amount_array = $cart_model->getCartItemsTotalCharge($user_id); 
               $total_cart_item = $cart_model->getCartItems($user_id);

                if(count($total_cart_item)){ //check cart items
                   
                $total_amount_array = $cart_model->getCartItemsTotalCharge($user_id);
                $total_amount = $total_amount_array[0]['totalamount'];

                $token = \Stripe\Token::create([
                    'card' => [
                        'number'    => $request->card_number,
                        'exp_month' => $request->exp_month,
                        'exp_year'  => $request->exp_year,
                        'cvc'       => $request->cvc,
                    ],
                ]);
                
                    if($request->saved_card == 1){
                       $stripe_customer = $this->createStripeCustomer($user_id,$token->id);
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
                                  "source" =>$token->id,
                        ));
                    } 
                $property_ids = $cart_model->getCartItemsPropertiesId($user_id);
                 if($charge->status == 'succeeded'){
                       $this->_saveTransactionInfo($user_id,$charge->id,$total_amount,$charge->status,$property_ids);
					   $sentrequest_model->sentNewRequest($user_id,$property_ids);
					   $cart_model->deleteCartItemByuserId($user_id);
                       $responsed_data = $this->commonEmailSender( \Auth::guard('api')->user()->email,$subject="Your TaxPDR request has been received",$template_name="request_recived",$site_link=null,$name= \Auth::guard('api')->user()->name,$data1=null);
                       return responseSuccessData($status=true,$message='payment_success',count($charge),['charge'=>$charge]);
                     
                 }else{
                      
                        $this->_saveTransactionInfo($user_id,$charge->id,$total_amount,$$charge->status,$property_ids);
                        return responseSuccessData($status=true,$message='no_data_found',count($charge),['charge'=>$charge]);

                 }
                 
            }else{
                        //no item add in carts
                        return responseSuccessData($status=true,$message='no_property_request_cart',count($total_cart_item),['cart_item'=>$total_cart_item]);
                       
            }
                
            }catch (\Stripe\Error\Card $e) {
               $body = $e->getJsonBody();
               $err  = $body['error'];
              return $response= \Response::json(
                    ['status' => false, 'error_code' => $err['code'], 
                     'error_message' => $err['message'],
                     'error_description' => $err['message']
                    ]
                    );
        }
        

    }
	
	
	 Public function paySavedCardPayment(Request $request){

             $stripe = \Stripe\Stripe::setApiKey(config('app.stripe_secret_key'));
             $user_id = \Auth::guard('api')->user()->id;
             $properties_model = new Properties;
             $cart_model = new Cart;
             $sentrequest_model = new SentRequest;
             $savedcard_model = new SavedCard;
             if($request->saved_card_id == '' || $request->saved_card_id == null || $request->saved_card_id <= 0){
                return $response = responseData($error_code=1034,$status=false);
             }
        try{
               $total_amount_array = $cart_model->getCartItemsTotalCharge($user_id); 
               $total_cart_item = $cart_model->getCartItems($user_id);

                if(count($total_cart_item)){ //check cart items
                   
                $total_amount_array = $cart_model->getCartItemsTotalCharge($user_id);
                $total_amount = $total_amount_array[0]['totalamount'];
                $customer_model = new StripeCustomer;
                $stripe_customer = $customer_model->getCustomerByUserId($user_id);
                $saved_card_data = $savedcard_model->getCardDataByIdUserId($request->saved_card_id,$user_id);
                if(count($saved_card_data) > 0){
                     
                    $charge = \Stripe\Charge::create([
                                                "amount" => 100*$total_amount,
                                                "currency" => "aud",
                                                "description" => "new property request payment",
                                                "customer" => $stripe_customer->stripe_customer_id,
                                                "source" => $saved_card_data[0]->stripe_card_id,
                                                 ]);
                   
                     $property_ids = $cart_model->getCartItemsPropertiesId($user_id);
                    if($charge->status == 'succeeded'){
                        $this->_saveTransactionInfo($user_id,$charge->id,$total_amount,$charge->status,$property_ids);
                        $sentrequest_model->sentNewRequest($user_id,$property_ids);
                          $cart_model->deleteCartItemByuserId($user_id);
                           $responsed_data = $this->commonEmailSender( \Auth::guard('api')->user()->email,$subject="Your TaxPDR request has been received",$template_name="request_recived",$site_link=null,$name= \Auth::guard('api')->user()->name,$data1=null);
                        return responseSuccessData($status=true,$message='payment_success',count($charge),['charge'=>$charge]);
                    }else{
                      
                        $this->_saveTransactionInfo($user_id,$charge->id,$total_amount,$$charge->status,$property_ids);
                        return responseSuccessData($status=true,$message='no_data_found',count($charge),['charge'=>$charge]);

                    }
                

                }
                else{
                    return responseSuccessData($status=true,$message='no_card_found');
                }
                 
            }else{

                return responseSuccessData($status=true,$message='no_property_request_cart',count($total_cart_item),['cart_item'=>$total_cart_item]);
                        
            }
                
        }catch (\Stripe\Error\Card $e) {
               $body = $e->getJsonBody();
               $err  = $body['error'];
               return $response= \Response::json(['status' => false, 'error_code' => $err['code'], 
                     'error_message' => $err['message'],
                     'error_description' => $err['message']]);
              
        }
        

    }

    private function _saveTransactionInfo($user_id,$transaction_id,$total_amount,$transaction_status,$property_ids){
        
        $paymenttransaction = new PaymentTransaction;
        $paymenttransaction->user_id = $user_id;
        $paymenttransaction->property_ids = $property_ids;
        $paymenttransaction->charge_id = $transaction_id;
        $paymenttransaction->amount = $total_amount;
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
              return $result = 
                    ["status" => "false", "error_code" => $err['code'], 
                     "error_message" => $err['message'],
                     "error_description" => $err['message']
                    ];
              
              
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
		
		$user_id = \Auth::guard('api')->user()->id;
		$savedcard = new SavedCard;
		$all_cards = $savedcard->getUserAllSavedCards($user_id);
        if(count($all_cards) > 0){
            return responseSuccessData($status=true,$message='data_found',count($all_cards),['all_cards'=>$all_cards]);     
        }else{

            return responseSuccessData($status=true,$message='no_card_found',count($all_cards),['all_cards'=>$all_cards]);
        }
        
    }
        
	
	/**
	* this function is show all saved card form
	*
	*@return view
	*/
    public function showSavedCardForm(Request $request){
		
		$user_id = \Auth::guard('api')->user()->id;
		
		return  view('investor.savedCard_form');
		
	}
	
	
	/**
	* this function is show all saved card form
	*
	*@return view
	*/
    public function saveSavedCard(Request $request){
		

		$user_id = \Auth::guard('api')->user()->id;
		$card = new stdClass();
        $savedcard = new SavedCard;
		$stripe = \Stripe\Stripe::setApiKey(config('app.stripe_secret_key'));
        try{

            $token = \Stripe\Token::create([
                    'card' => [
                        'number'    => $request->card_number,
                        'exp_month' => $request->exp_month,
                        'exp_year'  => $request->exp_year,
                        'cvc'       => $request->cvc,
                    ],
                ]);

		  $card = $this->createStripeCustomer($user_id,$token->id);
     
      
        if($card['status'] ==  "false"){
            $card['status'] = false;
            return $response= \Response::json($card);
        }
		$result = $this->_savesavedCardWithOutCharge($card,$user_id,$request->card_holder_name);

        $all_cards = $savedcard->getUserAllSavedCards($user_id);
        return responseSuccessData($status=true,$message='card_saved',count($all_cards),['all_cards'=>$all_cards]);
		
    }catch (\Stripe\Error\Card $e) {
               $body = $e->getJsonBody();
               $err  = $body['error'];
              return $response= \Response::json(
                    ['status' => false, 'error_code' => $err['code'], 
                     'error_message' => $err['message'],
                     'error_description' => $err['message']
                    ]
                    );
              
              
        }
		
	}

    /**
    * this function is show all saved card form
    *
    *@return view
    */
    public function changeDefaultCard(Request $request){
        
        $user_id = \Auth::guard('api')->user()->id;
       
        if($request->id == '' || $request->id == null || $request->id <= 0){
             return $response = responseData($error_code=1034,$status=false);
        }else{
              $id = $request->id;
              $savedcard_model = new SavedCard;
              if($update_data = $savedcard_model->updateDefaultCard($user_id,$id)){
                 return responseSuccessData($status=true,$message='card_set_default',count($update_data),['update_data'=>$update_data]);
              }else{
               return $response = responseData($error_code=1003,$status=false);
                
              }
              
        }
        return $response = responseData($error_code=1003,$status=false);
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
            if($request->id == '' || $request->id == null || $request->id <= 0){
                return $response = responseData($error_code=1034,$status=false);
            }
            $id = $request->id;
            $user_id = \Auth::guard('api')->user()->id;
			$validate = $savedcard->validateDelete($id,$user_id);
			if($validate == true){
				  \Stripe\Stripe::setApiKey(config('app.stripe_secret_key'));
				  $stripe_customer_model = new StripeCustomer;
                  $count_customer = $stripe_customer_model->getCustomerByUserId($user_id);
				 if(count($count_customer) > 0){
					  $customer = \Stripe\Customer::retrieve($count_customer->stripe_customer_id);
					  $card_data = SavedCard::find($id);
                      $customer->sources->retrieve($card_data->stripe_card_id)->delete();
				  }
                 $result = $savedcard->deleteRequest($id,$user_id);
				if($result['status'] == true ){
					 $savedcard->updateLastAsdefault($user_id);
					 $all_cards = $savedcard->getUserAllSavedCards($user_id);
					 $result['count']= count($all_cards);
                     return responseSuccessData($status=true,$message='card_delete',count($all_cards),['all_cards'=>$all_cards]);
				}
                 return $response = responseData($error_code=1003,$status=false);
			}
			
		return $response = responseData($error_code=1003,$status=false);
	}

   
}
