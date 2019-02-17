<?php

namespace App\Http\Controllers\api\v1\Investor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Properties;
use App\Models\RequestCharge;
use App\Models\SavedAddress;
use App\Models\Cart;
use App\Models\CalculatorSearch;
use App\Models\SentRequest;
use Illuminate\Support\Facades\Redirect;
use Lang;
use Validator;
use Carbon\Carbon as Corbon;
class InvestorController extends Controller
{
	 /*
    |--------------------------------------------------------------------------
    |Investor Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the ivestor activities
    | edit  profile and settings,
    | provide this functionality without requiring any additional code.
    |
    */
     public function propertyValidate(array $data){

            return  Validator::make($data, [
            "property_lists" => 'required|array',
            "property_lists.*.property_address"  => "required|string",
            "property_lists.*.property_type"  => "required|numeric",
            "property_lists.*.suburb"  => "required|string",
            "property_lists.*.state"  => "required|numeric",
            "property_lists.*.save_address"  => "required|numeric",
            "property_lists.*.add_cart"  => "required|numeric",
            "property_lists.*.construction_year"  => "required|numeric",
            "property_lists.*.purchase_year"  => "required|numeric",
            "property_lists.*.property_new_status"  => "required",
            "property_lists.*.purchase_price"  => "required|regex:/^\d*(\.\d{1,2})?$/",
            
        ]);
     }
	 
	
	  public function tokenIdValidate(array $data)
    {
        return Validator::make($data, [
            'api_token' => 'required|string',
            'id' => 'required|numeric',
        ]);
    }
     

     /**
     *
     * show cart properties 
     *
     * @param
     * 
     * @return view
     */
    public function getAllSentRequest(Request $request){
            
            
            $sentrequest = new SentRequest;
            $user_id = \Auth::guard('api')->user()->id;
            $all_properties = $sentrequest->getUserAllRequests($user_id);
            if(count($all_properties) > 0){

                return responseSuccessData($status=true,$message='data_found',count($all_properties),['getAllSent'=>$all_properties]);
             }else{
                return responseSuccessData($status=true,$message='no_sent_request',count($all_properties),['getAllSent'=>$all_properties]);
                    
            }
            
    }


     /**
     *
     * show saved address properties 
     *
     * @param
     * 
     * @return view
     */
    public function getSavedRequest(Request $request){
            
            $user_id = \Auth::guard('api')->user()->id;
            $savedaddress_model = new SavedAddress;
            $allsaved_addresses = $savedaddress_model->getSavedAddresses($user_id);
            if(count($allsaved_addresses) > 0){

                return responseSuccessData($status=true,$message='data_found',count($allsaved_addresses),['saved_properties'=>$allsaved_addresses]);
             }else{

                    return responseSuccessData($status=true,$message='no_saved_property',count($allsaved_addresses),['saved_properties'=>$allsaved_addresses]);
                    
            }
            
    }
    


     /**
     *
     * store new request data 
     *
     * @param
     * 
     * @return view
     */
    public function saveRequest(Request $request){

            $validator = $this->propertyValidate($request->all());
		    if ($validator->fails()) {  // check valid input data validations
                 return $response = responseData($error_code=1002,$status=false);
            }
           $user_id = \Auth::guard('api')->user()->id;
		   $id = ($request->has('id'))? $request->id : null;
           $all_added_properties =  $this->_saveRequest($request,$id);
        
            if(count($all_added_properties) > 0){
                if($id > 0){
                       return responseSuccessData($status=true,$message='property_updated',count($all_added_properties),['saveRequestOnUpdate'=>$all_added_properties]);
                }else{
                    return responseSuccessData($status=true,$message='property_added',count($all_added_properties),['saveRequest'=>$all_added_properties]);
                }
                
            }else{
                    return responseSuccessData($status=true,$message='no_data_found',count($all_added_properties),['saveRequest'=>$all_added_properties]);
                     //return $response = responseData($error_code=1003,$status=false);
            }

    }
	
	
    /**
     *
     * private function to save request data 
     *
     * @param array $request required 
     * @param integer $id optional (using on update case)
     *
     * @return view
    */

    private function _saveRequest($request,$id=null){
    
            $user_id = \Auth::guard('api')->user()->id;
            $request_charge_model = new RequestCharge;
            $i = 0; 

            foreach($request->property_lists as $property_list){
                if($request->has('id')){
                     $id=$request->id;
                     $cart_model = Cart::find($id);
                     $Property = Properties::find($cart_model->property_id);
                     if(count($Property)==0){
                        $cart_model = new Cart;
                        $Property = new Properties;
                     }
                }else{
                  $cart_model = new Cart;
                  $Property = new Properties;
                }
                //$charge = $request_charge_model->getAddRequestCharge();
                $charge = $request_charge_model->getChargeBaseOnYear($property_list['construction_year'],$property_list['property_new_status']);
                if($property_list['add_cart'] == 1){
                    $Property->user_id = $user_id;
                    $Property->property_address =  $property_list['property_address'];
                    $Property->property_type = $property_list['property_type'];
                    $Property->suburb = $property_list['suburb'];
                    $Property->state = $property_list['state'];
                    $Property->construction_year = $property_list['construction_year'];
                    $Property->purchase_year = $property_list['purchase_year'];
                    $Property->property_new_status = $property_list['property_new_status'];
                    $Property->purchase_price = $property_list['purchase_price'];
                    $Property->floor_area_unite = $property_list['floor_area_unite'];
                    $Property->floor_area = $property_list['floor_area'];
                    $Property->price = $charge;
                    $Property->save();
    				$property_id = $Property->id;
				}

                if($property_list['save_address'] == 1){
                   $saved_address =  1;
                } else{
                     $saved_address = null;
                } 
                if($saved_address == 1){
					 if($cart_model->saved_address_id > 0){
                        $savedaddress_model = SavedAddress::find($cart_model->saved_address_id);
                        
                    } else{
                          $savedaddress_model = new SavedAddress;
                    }
                    $savedaddress_model->user_id = $user_id;
                    $savedaddress_model->property_address = $property_list['property_address'];
                    $savedaddress_model->property_type = $property_list['property_type'];
                    $savedaddress_model->suburb = $property_list['suburb'];
                    $savedaddress_model->state = $property_list['state'];
                    $savedaddress_model->construction_year = $property_list['construction_year'];
                    $savedaddress_model->purchase_year = $property_list['purchase_year'];
                    $savedaddress_model->property_new_status = $property_list['property_new_status'];
                    $savedaddress_model->purchase_price = $property_list['purchase_price'];
                    $savedaddress_model->floor_area_unite = $property_list['floor_area_unite'];
                    $savedaddress_model->floor_area = $property_list['floor_area'];
                    $savedaddress_model->save();
                    $saved_address_id = $savedaddress_model->id;
                }else{
                    $saved_address_id = null;
                }
                if($property_list['add_cart'] == 1){
                     $cart_model->user_id = $user_id;
                     $cart_model->property_id = $property_id;
                     $cart_model->saved_address_id = $saved_address_id;
                     $cart_model->save();
                     $i++;
                }
               
            }

        if($id){
            return  $Property = Properties::find($cart_model->property_id);
        }else{
              if($i==0){
                        $savedaddress_model = new SavedAddress;
                 return $allsaved_addresses = $savedaddress_model->getSavedAddresses($user_id);
              }else{
                 $cartmodel = new Cart;
                 return $all_properties = $cartmodel->getCartItems($user_id);
                 
              } 
        }
        
    }
	
    /**
     *
     * store new request data  from already saved address
     *
     * @param $request required
     * 
     * @return view
     */
    public function saveRequestBYSavedAddress(Request $request){
            
            $validator = Validator::make($request->all(), [
                               "saved_ids"    => "required|array",
                           ]);

		   if ($validator->fails()) {  // check valid input data validations
                 return $response = responseData($error_code=1002,$status=false);
            }
            $user_id = \Auth::guard('api')->user()->id;
            $savedaddress_model = new SavedAddress;
            $request_charge_model = new RequestCharge;
            $all_saved_ids = $request->saved_ids;
            $allsaved_addresses = $savedaddress_model->getSavedAddressesbyIds($all_saved_ids,$user_id);
            $charge = $request_charge_model->getAddRequestCharge();
			if(count($allsaved_addresses) > 0){
				foreach($allsaved_addresses as $saved_address){
                   $check_already_added =  Cart::where('saved_address_id','=',$saved_address->id)->get();
                   $charge = $request_charge_model->getChargeBaseOnYear($saved_address->construction_year,$saved_address->property_new_status);
                    if(count($check_already_added) == 0){
                        $Property = new Properties;
                        $Property->user_id = $user_id;
                        $Property->property_address = $saved_address->property_address;
                        $Property->property_type = $saved_address->property_type;
                        $Property->suburb = $saved_address->suburb;
                        $Property->state = $saved_address->state;
                        $Property->construction_year = $saved_address->construction_year;
                        $Property->purchase_year = $saved_address->purchase_year;
                        $Property->property_new_status = $saved_address->property_new_status;
                        $Property->purchase_price = $saved_address->purchase_price;
                        $Property->floor_area_unite = $saved_address->floor_area_unite;
                        $Property->floor_area = $saved_address->floor_area;
                        $Property->price = $charge;
                        $Property->save();
                        $property_id = $Property->id;

                        $cart_model = new Cart;
                        $cart_model->property_id = $property_id;
                        $cart_model->saved_address_id = $saved_address->id;
                        $cart_model->user_id = $saved_address->user_id;
                        $cart_model->save(); 
                    }
                }
            
               $cart_model = new Cart;
               $all_properties = $cart_model->getCartItems($user_id);
               return responseSuccessData($status=true,$message='property_added',count($all_properties),['savebysavedadress'=>$all_properties]);
            
			}else{
				  return responseSuccessData($status=true,$message='no_property',count($allsaved_addresses),['savebysavedadress'=>$allsaved_addresses]);
				//return $response = responseData($error_code=1030,$status=false);
			}
    
    }

     /**
     *
     *This function is use for get all cart items
     *
     * @param api_token required
     * 
     * @return json
     */ 

    public function showNewlyAddedRequest(){

            $cart_model = new Cart;
			$user_id = \Auth::guard('api')->user()->id;
            $all_properties = $cart_model->getCartItems($user_id);
            if(count($all_properties) > 0 ){
               return responseSuccessData($status=true,$message='data_found',count($all_properties),['showNewlyAdded'=>$all_properties]);
             }else{
                   return responseSuccessData($status=true,$message='no_saved_property',count($all_properties),['showNewlyAdded'=>$all_properties]);    
                     //return $response = responseData($error_code=1016,$status=false);
            }

    } 
    
	 /**
     *
     *This function is use for delete cart items
     *
     * @param api_token required
     * @param integer id required
     * 
     * @return json
     */

    public function deleteRequest(Request $request){
           
		    $validator =  $this->tokenIdValidate($request->all()); // call validator to check other validations
            if ($validator->fails()) {  // check valid input data validations
                 return $response = responseData($error_code=1002,$status=false);
            }
			
            $cart_model = new Cart;
            $id = $request->id;
            $user_id = \Auth::guard('api')->user()->id;
            $result = $cart_model->deleteRequest($id,$user_id);
            if($result['status'] == true ){
                $all_properties = $cart_model->getCartItems($user_id);
                return responseSuccessData($status=true,$message='property_delete',count($all_properties),['remaining_properties'=>$all_properties]);
            }
            if($result['status'] == false ){
                 return $response = responseData($error_code=1025,$status=false);

            }
           

    }
    /**
    *@ this function for show edit form of saved address 
	*@param integer id required
    *
	*return json
    */   

    public function showEditSavedRequest(Request $request){
            
    		try{
                $validator =  $this->tokenIdValidate($request->all()); // call validator to check other validations
                if ($validator->fails()) {  // check valid input data validations
                     return $response = responseData($error_code=1002,$status=false);
                }
    			
                $savedaddress_model = new SavedAddress;
                $saved_address = $savedaddress_model->getSavedAddressById($request->id);
                $id = $request->id;
                $user_id = \Auth::guard('api')->user()->id;
                 return responseSuccessData($status=true,$message='data_found',count($saved_address),['showeditsaved'=>$saved_address]);
                }catch (\Exception $e) {
             return $response = responseData($error_code=1003,$status=false);
            }
            
    }
	
	/**
    *@ this function for show edit form of added property 
	*@param integer id required
    *
	*return json
    */   

	 public function showEditCurrentRequest(Request $request){
            
			
			$validator =  $this->tokenIdValidate($request->all()); // call validator to check other validations
            if ($validator->fails()) {  // check valid input data validations
                 return $response = responseData($error_code=1002,$status=false);
            }
			
			$properties_model = new Properties;
            $cart_model = Cart::find($request->id);
            if(count($cart_model)){
                 $property_id =  $cart_model->property_id;
                 $saved_address = $properties_model->getPropertyById($property_id);
                 $id = $request->id;
                 $user_id = \Auth::guard('api')->user()->id;
                 if(count($saved_address)){
                     $saved_address['id'] = $id;
                     $saved_address['property_id'] = $property_id;
                     return responseSuccessData($status=true,$message='data_found',count($saved_address),['showeditcurrent'=>$saved_address]);
                }else{
                    return responseSuccessData($status=true,$message='no_data_found',count($saved_address),['showeditcurrent'=>$saved_address]);

                }
            }else{
                 return responseSuccessData($status=true,$message='no_data_found',0,['showeditcurrent'=>null]);
            }
           

    }

    /**
     * this function is used for update saved addres info 
    *@param  string propert_address required
    *@param  string suburb required
    *@param  string propert_type required
    *@param  string state required
    *@return true or false status
    */

    public function updateSavedAddress(Request $request){
           
            $validator =  $this->tokenIdValidate($request->all()); // call validator to check other validations
            if ($validator->fails()) {  // check valid input data validations
                 return $response = responseData($error_code=1002,$status=false);
            }
            
		    if($request->id == 0){
                    $saved_property = $this->_saveNewOnUpdateSavedProperty($request);
			        return responseSuccessData($status=true,$message='property_added',count($saved_property),['updatesavedaddress'=>$saved_property]);
                   
             }else{
                $saved_address = SavedAddress::find($request->id);
                if($saved_address){
                    $cart = new Cart;
                    $cart->updateCartSavedAddressId($request->id);
                    $saved_property = $this->_saveNewOnUpdateSavedProperty($request);
                    return responseSuccessData($status=true,$message='property_updated',count($saved_property),['updatesavedaddress'=>$saved_property]);
                }else{
               
                   return $response = responseData($error_code=1026,$status=false);
                }
                   
            }
		    
    
    }
    
     private function _saveNewOnUpdateSavedProperty($request){
                
                $user_id = \Auth::guard('api')->user()->id;
                $request_charge_model = new RequestCharge;
                //$charge = $request_charge_model->getAddRequestCharge();
                $charge = $request_charge_model->getChargeBaseOnYear($request->construction_year,$request->property_new_status);
                if($request->id > 0){
                   $savedaddress_model = SavedAddress::find($request->id);
                }else{
                    $savedaddress_model = new SavedAddress;
                }
                $savedaddress_model->user_id = $user_id;
                $savedaddress_model->property_address = $request->property_address;
                $savedaddress_model->property_type = $request->property_type;
                $savedaddress_model->suburb = $request->suburb;
                $savedaddress_model->state = $request->state;
                $savedaddress_model->construction_year = $request->construction_year;
                $savedaddress_model->purchase_year = $request->purchase_year;
                $savedaddress_model->purchase_price = $request->purchase_price;
                $savedaddress_model->floor_area = $request->floor_area;
                $savedaddress_model->floor_area_unite = $request->floor_area_unite;
                $savedaddress_model->property_new_status = $request->property_new_status;
                $savedaddress_model->save();
                $id = $savedaddress_model->id;
                $savedaddressmodel = new SavedAddress;
                return $savedaddressmodel->getSavedAddressebyId($id,$user_id);
                

    }


    /**
     * this delete saved address  
    *@param  integer id required
    *
    *@return json
    */

    public function deleteSavedAddress(Request $request){
           
		    $validator =  $this->tokenIdValidate($request->all()); // call validator to check other validations
            if ($validator->fails()) {  // check valid input data validations
                 return $response = responseData($error_code=1002,$status=false);
            }
			
            $savedaddress = new SavedAddress;
            $id = $request->id;
            $user_id = \Auth::guard('api')->user()->id;
            $result = $savedaddress->deleteRequest($id,$user_id);
            $allsaved_addresses = $savedaddress->getSavedAddresses($user_id);
            if($result['status'] == true ){
                return responseSuccessData($status=true,$message='property_delete',count($allsaved_addresses),['remainsavedaddress'=>$allsaved_addresses]);
            }
            if($result['status'] == false ){
                 return $response = responseData($error_code=1025,$status=false);

            }
           
    }

    /**
    *this function is used for update report view status
    *@param Request $request required
    *
    *@return array
    */
    public function updateReportViewStatus(Request $request){
         
         if($request->id && $request->api_token){
           $user_id =  \Auth::guard('api')->user()->id;
            $sentrequest = SentRequest::find($request->id);
            if(count($sentrequest) > 0){
                 $sentrequest->report_view_status = '1';
                if($user_id == $sentrequest->user_id){
                   $sentrequest->save();
                   $sentrequest = new SentRequest;
                   $property_details = $sentrequest->getPropertydetailsById($request->id);
                   return responseSuccessData($status=true,$message='property_updated',count($property_details),['Report_View_property'=>$property_details]);    
                }else{
                   return $response = responseData($error_code=1002,$status=false);                
                }
            }else{
                return $response = responseData($error_code=1026,$status=false);
            }
           
            
         }else{

            return $response = responseData($error_code=1002,$status=false);
         }
         
    }

    /**
     *
     * show property details
     *
     * @param
     * 
     * @return view
     */
    public function showPropertyDetails(Request $request){
            $sentrequest = new SentRequest;
            $user_id = \Auth::guard('api')->user()->id;
            $property_details = $sentrequest->getPropertydetailsById($request->id);
            if(count($property_details) > 0){
                return responseSuccessData($status=true,$message='data_found',count($property_details),['property'=>$property_details]);
            }else{
               return $response = responseData($error_code=1026,$status=false);
            }
            
    }

    /**
     *
     * show report of commpleted request properties
     *
     * @param
     * 
     * @return view
     */
    public function myReports(Request $request){
            $sentrequest = new SentRequest;
            $user_id = \Auth::guard('api')->user()->id;
            $all_sent_requests = $sentrequest->getUserAllReports($user_id);
            if(count($all_sent_requests) > 0){
                  return responseSuccessData($status=true,$message='data_found',count($all_sent_requests),['property'=>$all_sent_requests]);
            }else{
                return responseSuccessData($status=true,$message='no_report',count($all_sent_requests),['property'=>$all_sent_requests]);
            }
           return $response = responseData($error_code=1003,$status=false);
    }


   /**
     * store reviews 
     *
     * @param array Request $request
     * 
     * @return view
     */
    public function saveReview(Request $request){

            $validator = \Validator::make($request->all(), [
            "id" => 'required|integer',
            "rate" => 'required|integer',]);
            if($validator->fails()){
                return $response = responseData($error_code=1002,$status=false); 
            }
            
            $user_id = \Auth::guard('api')->user()->id;
            $id = $request->id;
            $sentrequest_model =   SentRequest::find($id);
            if(count($sentrequest_model) > 0){
                if($sentrequest_model->rate == null){

                    if($sentrequest_model->user_id == $user_id && $sentrequest_model->request_status == 5 && $sentrequest_model->report_name !=null){
                        $sentrequest_model->rate = $request->rate;
                        $sentrequest_model->review_description = $request->review_description;
                        $sentrequest_model->save();
                        return responseSuccessData($status=true,$message='review_saved',count($sentrequest_model),['save_review_property'=>$sentrequest_model]); 

                    }else{
                         return $response = responseData($error_code=1036,$status=false);
                       
                    }
                }else{
                      return $response = responseData($error_code=1037,$status=false);
                }

            } 
           
    }

    /**
     * this function is used for calculate depreciation
    *@param  array $request
    *
    *@return json
    */

    public function calculateDep(Request $request){

           $user_id = 10;
           $calculator_model = new CalculatorSearch;
           return $result = $calculator_model->calculateDepreciation($request,$user_id);
           
    }


    
    

}
