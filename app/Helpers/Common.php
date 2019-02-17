<?php
use App\Libraries\Encryption\aesEncrypt;
use App\Models\Upload;
use App\Models\Admin;
use App\Models\RequestCharge;
use App\Models\ContactUs;
use App\Models\Cart;

// genrate randomstring
function generateRandomString($length = 60) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

//encrypt String passing encrypt type as aes or base64


function encryptString($string,$encrypttype)
{
	if($encrypttype == 'aes'){
	
	return $encode = aesEncrypt::encrypt($string);
			 
		
	}else{
		
		return $encode = base64_encode($string);
		
	}
}


/*decrypt String passing encrypt type as aes or base64
$encrypttype as aes
*/
function decryptString($encryptstring,$encrypttype)
{
	if($encrypttype == 'aes'){
		
		return $encode = aesEncrypt::decrypt($encryptstring);
			 
		
	}else{
		
		return $encode = base64_decode($string);
		
	}
}
/**
*This helper  function return error and success response
*
*@param int   $error_code  error code
*@param array $data  result
*retun response $response
*/
function responseData($error_code,$status=null,$data=null){	
	if ($data == null) {
		$response= \Response::json(
					['status' => $status, 'error_code' => $error_code, 
					 'error_message' => Lang::get('error_code.'.$error_code),
					 'error_description' => Lang::get(
					 'error_code_description.'.$error_code)
					]
					);
	} else {
		
		$response= \Response::json(
					['status' => $status, 'error_code' => $error_code, 
					 'error_message' => Lang::get('error_code.'.$error_code),
					 'error_description' => Lang::get(
					 'error_code_description.'.$error_code),
					 'data'=>$data
					]
					);
		
	}
    return 	$response;
	
}
/**
*This helper  function return success response
*
*@param int   $error_code  error code
*@param array $data  result
*retun response $response
*/
function responseSuccessData($status=null,$message=null,$count=null,$data=null){	
	if ($data == null) {
		$response= \Response::json(
					['status' => $status,
					 'total' => $count,
					 'message' => Lang::get('messages.'.$message)
					]
					);
	} else {
		
		$response= \Response::json(
					['status' => $status, 
					 'message' => Lang::get('messages.'.$message),
					 'total' => $count,
					 'data'=>$data
					]
					);
		
	}
    return 	$response;
	
}
    /**
	* This function return profile pic url
	*
	*@param int $user user id 	
	*@param string $api_token user api token 	
	*@param int $size thumb_pic1,thumb_pic1
	*@return string full image url
	*/
	function imageUrl($user_id,$api_token,$size=1){
		 if($size !=''){
			 $size = $size;
			 
		 }else{
			 $size=1;
		 }
		   return  $response = getenv('APP_URL').'/api/v1/user-pic/'.$user_id.'/'.$size.'?api_token='.$api_token;
		
	}
	
	function showAdminName()
	{
		$admin_id = \Auth::user()->id;
		$admin_model = new Admin;
		$admin_details=$admin_model->getAdminDetails($admin_id);
		$admin_name = $admin_details['name'];
		return $admin_name;
	}
	
	 function get_view_count($listing_id)
	{
		if(!(Cookie::get('listind_viewed'.$listing_id))){
			$query = DB::table('listing')->select('total_view')->where('id','=',$listing_id)->get();
			if(count($query) > 0)
			{
				
				$total_view = $query[0]->total_view;
				$total_view++;
			}		
			else{
				$total_view = 0;
			    }
				DB::table('listing')->where('id','=', $listing_id)->update(['total_view' => $total_view]);
			   $set = Cookie::queue('listind_viewed'.$listing_id, 1, 1);
				return $total_view;
		}else{
			$query = DB::table('listing')->select('total_view')->where('id','=',$listing_id)->get();
			if(count($query) > 0)
			{
				return $query[0]->total_view;
			}		
			else{
				
				return $total_view = 0;	
			}
				
		}
	} 
    
    function allAccountTypes(){


    	return $result = DB::table('roles')->select('id','name as account_type','category_name')->where('id','!=',1)->OrderBy('id','asc')->get();
    }
    

    function getAllCountries(){


    	return $result = DB::table('countries')->select('name','code')->OrderBy('id','asc')->get();
    }


    function getAllStates(){


    	return $result = DB::table('states')->select('id','name')->OrderBy('id','asc')->get();
    }

    function getStateById($id){


    	 $result = DB::table('states')->select('id','name')->where('id','=',$id)->get();
    	 if(count($result) > 0){
           return $result[0]->name;
    	 }else{
    	 	return $result = null;
    	 }
    }


    function getAllPropertytypes(){


    	return $result = DB::table('property_types')->select('id','name')->OrderBy('id','asc')->get();
    }


    function getPropertytypeNameBYId($id){


    	return $result = DB::table('property_types')->where('id','=',$id)->OrderBy('id','asc')->value('name');;
    }

    function convertIntoDateFormate($date){
		
		if($date !=null || $date !=''){
			$strtotime_time = strtotime($date);
		    return $Timestamp_time = date('jS M Y',$strtotime_time);
		}else{
            
		     return $Timestamp_time = '';
			}
		

		
	}


function getChargeHelper($construction_year,$property_new_status){
		 
    $request_charge_model = new RequestCharge;
    return $charge = $request_charge_model->getChargeBaseOnYear($construction_year,$property_new_status);
}

function contactUsHelper(){
		 
    $contact_us = ContactUs::find(1);
	if($contact_us){
		return $contact_us;
	}else{
		$contact_us->email = null;
		$contact_us->modile = null;
		return $contact_us;
	}
	
}

function cartItemsCounts($user_id){
		 
    return $items_counts = Cart::where('user_id','=',$user_id)->count();
	
	
}

 function PropertyProgressNameBYId($id){

    	return $result = DB::table('progress_status')->where('id','=',$id)->value('name');;
    }

    function getValuerByStateId($id){

    	return $result = DB::table('users')->select('id','name',DB::raw("(SELECT roles.name FROM roles WHERE roles.id = users.account_type)  as account_type_name"))->where('state','=',$id)->where('confirm_status','=',1)->where('role_category','=','valuer')->where('status','=',1)->get();
    }

