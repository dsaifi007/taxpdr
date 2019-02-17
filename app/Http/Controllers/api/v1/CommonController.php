<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\VersionControl;
use App\Models\Device;
use App\Models\ContactUs;
use App\Models\StaticPage;
use Lang;
use Validator;
use stdClass;

class CommonController extends Controller
{
   

     /**
     * Get a validator for an incoming  check version request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required',
            'os_type' => 'required' ]);
    }
     
     /**
     * Get a validator for an incoming  check version request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function deviceValidator(array $data)
    {
        return Validator::make($data, [
            'api_token' => 'required',
            'os_type'=>'required',
            'devicetoken'=>'required']);
    }


     /**
     *
     * Check version for given inputs
     *
     * @param  array $Request required
     * 
     * @return json
     */ 
    public function checkVersion(Request $request)
    {
          
        $validator = $this->validator($request->all());
        if($validator->fails()){
            $response  = ['status' => false, 'error_code' => 1002,'error_message' => Lang::get('error_code.1002'),'error_description' => Lang::get('error_code_description.1002'),'erros'=>$validator->errors()];
            return response()->json($response);
        }else{
              $versioncontrol = new VersionControl;
              $count = $versioncontrol->getVersionCount($request->name,$request->os_type);
              if($count > 0){

                       return responseSuccessData($status=true,$message='version_found',$count=1,$data=null);
              }else{

                     return $response = responseData($error_code=1009,$status=false);
              }
           
	    }
    }


    /**
     *
     * save new device info for given inputs
     *
     * @param  json $Request required
     * 
     * @return json
     */ 
    public function registerDevice(Request $request)
    {
          
        $validator = $this->deviceValidator($request->all());
        if($validator->fails()){
            $response  = ['status' => false, 'error_code' => 1002,'error_message' => Lang::get('error_code.1002'),'error_description' => Lang::get('error_code_description.1002'),'erros'=>$validator->errors()];
            return response()->json($response);
        }else{
                $device = new Device;
                $result = $device->getDeviceByDeviceToken($request->devicetoken,$request->clientid);
              
                if(count($result) > 0){
                    $device = Device::find($result[0]->id);

               }

            $clientid = \Auth::guard('api')->user()->id;
            $device->clientid =  $clientid;
            $device->appname = $request->appname; 
            $device->appversion = $request->appversion; 
            $device->deviceuid = $request->deviceuid; 
            $device->devicetoken = $request->devicetoken;  
            $device->devicename = $request->devicename; 
            $device->os_type = $request->os_type; 
            $device->deviceversion = $request->deviceversion; 
            $device->devicemodel = $request->devicemodel;
            $device->status = $request->status;
            if($device->save()){
                       return responseSuccessData($status=true,$message='save_device',$count=1,$data=null);
            }else{

                  return $response = responseData($error_code=1003,$status=false);
            }


           
	    }
    }
    

    /**
     *
     * This function is  use for return all countries phone codes
     *
     * @param  array $Request required
     * 
     * @return json
     */ 
    public function getAllCountriesCodes(Request $request)
    {
        $all_countries = getAllCountries();

        if(count($all_countries) > 0){

                return responseSuccessData($status=true,$message='data_found',count($all_countries),['countries'=>$all_countries]);
        }else{

                     return $response = responseData($error_code=1015,$status=false);
        }
    }
     

    /**
     *
     * This function is  use for return all states
     *
     * @param  array $Request required
     * 
     * @return json
     */ 
    public function getAllStates(Request $request)
    {
        $all_States = getAllStates();

        if(count($all_States) > 0){

                return responseSuccessData($status=true,$message='data_found',count($all_States),['all_state'=>$all_States]);
        }else{

                     return $response = responseData($error_code=1015,$status=false);
        }
    }
     

     /**
     *
     * This function is  use for return all account types
     *
     * @param  array $Request required
     * 
     * @return json
     */ 
    public function getAllAccountTypes(Request $request)
    {
        $all_account_types = allAccountTypes();

        if(count($all_account_types) > 0){

                return responseSuccessData($status=true,$message='data_found',count($all_account_types),['account_types'=>$all_account_types]);
        }else{

                     return $response = responseData($error_code=1015,$status=false);
        }
    } 


    /**
     *
     * This function is  use for return all property types
     *
     * @param  array $Request required
     * 
     * @return json
     */ 
    public function getAllPropertyTypes(Request $request)
    {
        $all_property_types = getAllPropertytypes();

        if(count($all_property_types) > 0){

                return responseSuccessData($status=true,$message='data_found',count($all_property_types),['property_types'=>$all_property_types]);
        }else{

                     return $response = responseData($error_code=1015,$status=false);
        }
    } 


    /**
     *
     * This function is  use for return all required data in single api
     *
     * @param  array $Request required
     * 
     * @return json
     */ 
    public function getAllRequiredDataSingleApi(Request $request)
    {
        $all_countries = getAllCountries();
        $all_account_types = allAccountTypes();
        $all_States = getAllStates();
        if(count($all_countries) > 0){
            $data['countries'] = $all_countries;
        }else{
            $data['countries'] = null;
        }

        if(count($all_account_types) > 0){
            $data['account_types'] = $all_account_types;
        }else{
            $data['account_types'] = null;
        }
  
        if(count($all_States) > 0){
            $data['states'] = $all_States;
        }else{
            $data['states'] = null;
        }

        if(count($data) > 0){

                return responseSuccessData($status=true,$message='data_found',count($data),$data);
        }else{

                     return $response = responseData($error_code=1015,$status=false);
        }
    }


/**
*
* This function is  use for return comtact us page details
*
* @param  array $Request required
* 
* @return json
*/ 
    public function getContactUs(Request $request)
    {
        $contactus_model = new ContactUs;

        //$result = $contactus_model->getContactusDetails()
        $result = ContactUs::find(1);
        if(count($result) > 0){
                 return response()->json(['status' => true, 'data' => ['contact_us' =>$result] ]);
                //return responseSuccessData($status=true,$message='data_found',count($result),['contact_us'=>$result]);
        }else{

                     return $response = responseData($error_code=1015,$status=false);
        }
    }
    
/**
*
* This function is  use for return terms and conditions page details
*
* @param  array $Request required
* 
* @return json
*/ 
    public function getTermsConditions(Request $request)
    {
        $static_page_model = new StaticPage;

        $result = StaticPage::find(1);

        if(count($result) > 0){
                return response()->json(['status' => true, 'data' => ['terms_conditions' =>$result] ]);
               
        }else{

                     return $response = responseData($error_code=1015,$status=false);
        }
    }

    /**
*
* This function is  use for return About us page details
*
* @param  array $Request required
* 
* @return json
*/ 
    public function getAboutUs(Request $request)
    {
        $static_page_model = new StaticPage;

        $result = StaticPage::find(2);
        //$static_page_model->getStaticPageContentByID(2);

        if(count($result) > 0){
         return response()->json(['status' => true, 'data' => ['about_us' =>$result] ]);
                //return responseSuccessData($status=true,$message='data_found',count($result), $object);
        }else{

                     return $response = responseData($error_code=1015,$status=false);
        }
    }


}
