<?php

namespace App\Http\Controllers\Investor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Properties;
use App\Models\RequestCharge;
use App\Models\SavedAddress;
use App\Models\Cart;
use App\Models\SentRequest;
use Illuminate\Support\Facades\Redirect;
use Lang;
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
     public function propertyValidate(){

             $validator = Validator::make($request->all(), [
            "property_address" => 'required|array',
            "property_address.*" => 'required|string',
            "suburb" => 'required|array',
            "suburb.*" => 'required|string',
            "state" => 'required|array',
            "state.*" => 'required|string',
            "property_type.*" => 'required|string',
        ]);
     }
     



    /**
     *
     * show investor all added requests
     *
     * @param
     * 
     * @return view
     */
    public function dashboard(Request $request){
            $sentrequest = new SentRequest;
			$user_id = \Auth::user()->id;
			$all_sent_requests = $sentrequest->getUserAllRequests($user_id);
            return view('investor.show_all_properties')->with(compact('all_sent_requests'));
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
            $user_id = \Auth::user()->id;
            $property_details = $sentrequest->getPropertydetailsById($request->id);
            if(count($property_details) > 0){
                return view('common.property_details')->with(compact('property_details'));
            }else{
                return abort(404);
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
            $user_id = \Auth::user()->id;
            $all_sent_requests = $sentrequest->getUserAllReports($user_id);
            return view('investor.report')->with(compact('all_sent_requests'));
    }


    /**
     *
     * show create new request form 
     *
     * @param
     * 
     * @return view
     */
    public function showCreateRequest(Request $request){
            
            $user_id = \Auth::user()->id;
            $savedaddress_model = new SavedAddress;
            $allsaved_addresses = $savedaddress_model->getSavedAddresses($user_id);
            return view('investor.create_request')->with(compact('allsaved_addresses'));
    }
	
	
	  /**
     *
     * show saved properties 
     *
     * @param
     * 
     * @return view
     */
    public function showsavedRequest(Request $request){
            
            $user_id = \Auth::user()->id;
            $savedaddress_model = new SavedAddress;
            $allsaved_addresses = $savedaddress_model->getSavedAddresses($user_id);
            return view('investor.saved_request_on_setting')->with(compact('allsaved_addresses'));
    }
    

    /**
     *
     * show refrsh saved properties
     *
     * @param
     * 
     * @return view
     */
    public function refreshSavedProperties(Request $request){
            
            $user_id = \Auth::user()->id;
            $savedaddress_model = new SavedAddress;
            $allsaved_addresses = $savedaddress_model->getSavedAddresses($user_id);
            $result['status']=true;
             $result['html'] = view('investor.refresh_saved')->with(compact('allsaved_addresses'))->render();
            return response()->json($result);
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

           $user_id = \Auth::user()->id;
		 
		   $id = ($request->has('id'))? $request->id : null;
           $this->_saveRequest($request,$id);
        
           return Redirect::route('investor.newly.added.request');

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

            
            $user_id = \Auth::user()->id;
            $savedaddress_model = new SavedAddress;
            $request_charge_model = new RequestCharge;
            $all_saved_ids = $request->saved_id;
            $allsaved_addresses = $savedaddress_model->getSavedAddressesbyIds($all_saved_ids,$user_id);
            $charge = $request_charge_model->getAddRequestCharge();

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
            
            return Redirect::route('investor.newly.added.request');

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
    
            $user_id = \Auth::user()->id;
            $request_charge_model = new RequestCharge;
            foreach($request->property_address as $key=>$val){
                if($id){
                     $cart_model = Cart::find($id);
                     $Property = Properties::find($cart_model->property_id);
                }else{
                  $cart_model = new Cart;
                  $Property = new Properties;
                }
                $charge = $request_charge_model->getAddRequestCharge();
                $property_new_status_key = 'property_new_status'.$key;
                $charge = $request_charge_model->getChargeBaseOnYear($request->construction_year[$key],$request->$property_new_status_key);
                $type_key = 'property_type'.$key;
                $save_address_key = 'saved_address'.$key;
                
                $Property->user_id = $user_id;
                $Property->property_address = $val;
                $Property->property_type = $request->$type_key;
                $Property->suburb = $request->suburb[$key];
                $Property->state = $request->state[$key];
                $Property->construction_year = $request->construction_year[$key];
                $Property->purchase_year = $request->purchase_year[$key];
                $Property->property_new_status = $request->$property_new_status_key;
                $Property->purchase_price = $request->purchase_price[$key];
                $Property->floor_area_unite = $request->floor_area_unite[$key];
                $Property->floor_area = $request->floor_area[$key];
                $Property->price = $charge;
                $Property->save();
                $property_id = $Property->id;

                $saved_address = ($request->has($save_address_key)) == '1' ? 1 : null;
                if($saved_address == 1){
                    if($cart_model->saved_address_id > 0){
                        $savedaddress_model = SavedAddress::find($cart_model->saved_address_id);
                        
                    } else{
                          $savedaddress_model = new SavedAddress;
                    }
                    
                    $savedaddress_model->user_id = $user_id;
                    $savedaddress_model->property_address = $val;
                    $savedaddress_model->property_type = $request->$type_key;
                    $savedaddress_model->suburb = $request->suburb[$key];
                    $savedaddress_model->state = $request->state[$key];
					$savedaddress_model->construction_year = $request->construction_year[$key];
					$savedaddress_model->purchase_year = $request->purchase_year[$key];
					$savedaddress_model->property_new_status = $request->$property_new_status_key;
					$savedaddress_model->purchase_price = $request->purchase_price[$key];
					$savedaddress_model->floor_area_unite = $request->floor_area_unite[$key];
					$savedaddress_model->floor_area = $request->floor_area[$key];
                    $savedaddress_model->save();
                    $saved_address_id = $savedaddress_model->id;
                   
                }else{
                    $saved_address_id = null;

                }
                    $cart_model->user_id = $user_id;
                    $cart_model->property_id = $property_id;
                    $cart_model->saved_address_id = $saved_address_id;
                    $cart_model->save();
               
            }
    }


    public function showNewlyAddedRequest(){

            //$Property = new Properties;
            $cart_model = new Cart;
            $user_id = \Auth::user()->id;
            $all_properties = $cart_model->getCartItems($user_id);
            if(count($all_properties) > 0 ){
               return view('investor.newly_created_request')->with(compact('all_properties'));
            }else{
                  
                  return view('investor.newly_created_request')->with(compact('all_properties'));
              //return Redirect::route('investor-dashboard')->with('error_msg',Lang::get('error_code.1011'));
            }

    } 

     /**
     *
     *This function is use for delete cart items
     *
     * @param integer id required
     * 
     * @return json
     */
    public function deleteRequest(Request $request){
           
            $cart_model = new Cart;
            $id = $request->id;
            $user_id = \Auth::user()->id;
            $result = $cart_model->deleteRequest($id,$user_id);
            if($result['status'] == true ){
                $all_properties = $cart_model->getCartItems($user_id);
                $result['html'] = view('investor.charges')->with(compact('all_properties'))->render();
                 $result['count']= count($all_properties);
            }
            return response()->json($result);

    }
    /**
    *@ this function for show edit form of saved address 
	*@param integer id required
    *
	*return json
    */   

    public function showEditSavedRequest(Request $request){
           
            $savedaddress_model = new SavedAddress;
            $saved_address = $savedaddress_model->getSavedAddressById($request->id);
            $id = $request->id;
            $user_id = \Auth::user()->id;
            if(count($saved_address)){
				$result['status'] = 'true';
               $result['html'] = view('investor.edit_property_popup')->with(compact('saved_address'))->render();
                return response()->json($result);
            }elseif($request->id == 0){
				$saved_address = new SavedAddress;
				$result['status'] = 'true';
				$add ='add';
                $result['html'] = view('investor.create_saved_address')->with(compact('saved_address','add'))->render();
                return response()->json($result);
			}
			else{
                  $result['status'] = 'false';
                  $result['message'] = 'false';
                  return response()->json($result);

            }

    }
	
	/**
    *@ this function for show edit form of newly added property 
	*@param integer id required
    *
	*return json
    */   

	 public function showEditCurrentRequest(Request $request){
           
            $properties_model = new Properties;
            $cart_model = Cart::find($request->property_id);
            $property_id =  $cart_model->property_id;
            $saved_address = $properties_model->getPropertyById($property_id);
            $id = $request->property_id;
            $user_id = \Auth::user()->id;
            if(count($saved_address)){
                $saved_address['cart_id'] = $id;
                $result['status'] = true;
               $result['html'] = view('investor.edit_newly_property_popup')->with(compact('saved_address'))->render();
                return response()->json($result);
            }else{
                  $result['status'] = false;

            }
            return response()->json($result);

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
           
            if($request->id == 0){
			       $this->_saveNewOnUpdateSavedProperty($request);
				   return Redirect::back()->with('success',Lang::get('messages.property_added'));
		    }else{
                  $cart = new Cart;
                  $cart->updateCartSavedAddressId($request->id); 
				  $this->_saveNewOnUpdateSavedProperty($request);
				   return Redirect::back()->with('success',Lang::get('messages.property_updated'));
		    }
		   

           
    }

    /**
    * this private function is used for save new update saved addres info 
    *@param  array $request required
    *
    *@return new address array
    */


    private function _saveNewOnUpdateSavedProperty($request){
		   
		    
                $user_id = \Auth::user()->id;
                $Property = new Properties;
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
                return $savedaddress_model->save();

    }


    /**
     * this delete saved address  
    *@param  integer id required
    *
    *@return json
    */

    public function deleteSavedAddress(Request $request){
           
            $savedaddress = new SavedAddress;
            $id = $request->id;
            $user_id = \Auth::user()->id;
            $result = $savedaddress->deleteRequest($id,$user_id);
            $allsaved_addresses = $savedaddress->getSavedAddresses($user_id);
            if(count($allsaved_addresses) == 0){
                     $result['count'] = count($allsaved_addresses);
                     $result['message'] = Lang::get('messages.no_saved_requests');
            }else{
            $result['count'] = count($allsaved_addresses);
            
            }
            return $result;
           //return Redirect::route('investor.edit.saved.request')->with('success',Lang::get('messages.deleted_saved_address'));
           
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
            "sent_request_id" => 'required|integer',
            "rate" => 'required|integer',]);
            if($validator->fails()){
                return Redirect::back()->with('error_msg',Lang::get('error_code.1002'));
            }
            
            $user_id = \Auth::user()->id;
            $id = $request->sent_request_id;
            $sentrequest_model =   SentRequest::find($id);
            if(count($sentrequest_model) > 0){
                if($sentrequest_model->user_id == $user_id && $sentrequest_model->request_status == 5 && $sentrequest_model->report_name !=null){
                    $sentrequest_model->rate = $request->rate;
                    $sentrequest_model->review_description = $request->review_description;
                    $sentrequest_model->save();
                    return responseSuccessData($status=true,$message='review_saved',count($sentrequest_model),['property'=>$sentrequest_model]); 

                }else{
                     return $response = responseData($error_code=1036,$status=false);
                   
                }

            } 
           
    }

    /**
    *this function is used for update report view status
    *@param Request $request required
    *
    *@return array
    */
    public function updateReportViewStatus(Request $request){
         
         
         if($request->id){
            $user_id = \Auth::user()->id;
            $sentrequest = SentRequest::find($request->id);
            $sentrequest->report_view_status = '1';
            if($user_id == $sentrequest->user_id){
                $sentrequest->save();
                return responseSuccessData($status=true,$message='property_updated',count($sentrequest),['property'=>$sentrequest]);    
            }else{
                return $response = responseData($error_code=1002,$status=false);                
            }
            
         }else{

            return $response = responseData($error_code=1002,$status=false);
         }
         
    }

     public function showCalculator(){
    
             return view('investor.calculator');
        
    }
    
    

}
