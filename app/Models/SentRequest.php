<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\Properties;
use DB;
use App\User;
class SentRequest extends Model
{
     protected $table = 'sent_requests'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','property_id','valuer_id','request_status','report_name','rate','review_description','report_view_status','property_address','suburb','property_type','state','construction_year','purchase_year','property_new_status','purchase_price','floor_area_unite','floor_area','account_type'];
	
	function sentNewRequest($user_id,$property_ids){
		
		if(count($property_ids) > 0){
			$property_ids_array = explode(',',$property_ids);
			foreach($property_ids_array as $property_id){
				$Properties = Properties::find($property_id);
				$data['user_id']= $user_id;
				$data['property_id']= $property_id;
				$data['property_address']= $Properties->property_address;
				$data['suburb']= $Properties->suburb;
				$data['property_type']= $Properties->property_type;
				$data['state']= $Properties->state;
				$data['construction_year']= $Properties->construction_year;
				$data['purchase_year']= $Properties->purchase_year;
				$data['property_new_status']= $Properties->property_new_status;
				$data['purchase_price']= $Properties->purchase_price;
				$data['floor_area_unite']= $Properties->floor_area_unite;
				$data['floor_area']= $Properties->floor_area;
				$query = self::create($data);

			}
		}
		
		return $result = true;
		
		
	}
	/**
	@ this function is used to show user all sent requestes
	@param inteter user_id required
	@
	@return array
	*/
	
	function getUserAllRequests($user_id){
		
		$file_path = asset(config('app.get_report_path'));
		return $result = self::select('sent_requests.id','sent_requests.property_id','sent_requests.request_status','sent_requests.created_at','sent_requests.report_name',DB::raw("CONCAT('".$file_path."','/',sent_requests.report_name) as full_report_path"),'sent_requests.purchase_price','sent_requests.property_address','sent_requests.property_type','sent_requests.suburb','sent_requests.state','sent_requests.account_type','property_types.name as property_type_name','states.name as state_name','sent_requests.property_new_status')->join('property_types','sent_requests.property_type','=','property_types.id')->join('states','states.id','=','sent_requests.state')->where('sent_requests.user_id','=',$user_id)->where('sent_requests.report_view_status','=','0')->orderBy('sent_requests.updated_at','desc')->get();
	}

    /**
	@ this function is get property details by id 
	@param inteter user_id required
	@
	@return array
	*/

	function getPropertydetailsById($id){
		$file_path = asset(config('app.get_report_path'));
		$result = self::select('sent_requests.id','sent_requests.property_id','sent_requests.rate','sent_requests.review_description','sent_requests.report_name',DB::raw("CONCAT('".$file_path."','/',sent_requests.report_name) as full_report_path"),'sent_requests.request_status','sent_requests.created_at','sent_requests.purchase_price','sent_requests.property_address','sent_requests.property_type','sent_requests.suburb','sent_requests.state','sent_requests.construction_year','sent_requests.purchase_year','sent_requests.property_new_status','sent_requests.floor_area_unite','sent_requests.floor_area','sent_requests.account_type','property_types.name as property_type_name','states.name as state_name','properties.price')->join('properties','properties.id','=','sent_requests.property_id')->join('states','states.id','=','sent_requests.state')->join('property_types','sent_requests.property_type','=','property_types.id')->where('sent_requests.id','=',$id)->get();
		if(count($result) > 0){
            return $result[0];
		}else{
            return $result;
		}
	}
   

    /**
	@ this function is used get all new request based on state 
	@param inteter user_id required
	@
	@return array
	*/

	function getNewRequests($user_id){

		$user_data = User::find($user_id);
		$state = $user_data->state;
		$file_path = asset(config('app.get_report_path'));
		return $result = self::select('sent_requests.id','sent_requests.request_status','sent_requests.created_at','sent_requests.purchase_price','sent_requests.property_address','sent_requests.property_type','sent_requests.suburb','sent_requests.state','property_types.name as property_type_name')->join('property_types','sent_requests.property_type','=','property_types.id')->whereNOTIn('sent_requests.id',function($query) use ($user_id){
               $query->select('sent_request_id')->from('rejected_request_users')->where('user_id','=',$user_id);
            })->where('sent_requests.state','=',$state)->where('sent_requests.request_status','=',1)->orderBy('sent_requests.created_at','desc')->get();
	}


	 /**
	@ this function is used get all new request based on state 
	@param inteter user_id required
	@
	@return array
	*/

	function getRequestByRequestId($id){
		
		$result = self::where('id','=',$id)->get();
		if(count($result) > 0){
             
             return $result[0];
		}else{
			return $result;
		}

	}


	/**
	@ this function is used get all new request based on state 
	@param inteter user_id required
	@
	@return array
	*/

	function getAcceptedJobs($user_id){
		$file_path = asset(config('app.get_report_path'));
		return $result = self::select('sent_requests.id','sent_requests.property_id','sent_requests.rate','sent_requests.review_description','sent_requests.report_name',DB::raw("CONCAT('".$file_path."','/',sent_requests.report_name) as full_report_path"),'sent_requests.request_status','sent_requests.created_at','sent_requests.purchase_price','sent_requests.property_address','sent_requests.property_type','sent_requests.suburb','sent_requests.state','sent_requests.construction_year','sent_requests.purchase_year','sent_requests.property_new_status','sent_requests.floor_area_unite','sent_requests.account_type','sent_requests.floor_area','property_types.name as property_type_name','states.name as state_name','users.name as investor_name')->join('property_types','sent_requests.property_type','=','property_types.id')->join('users','sent_requests.user_id','=','users.id')->join('states','states.id','=','sent_requests.state')->Where('sent_requests.valuer_id','=',$user_id)->whereBetween('sent_requests.request_status',[2,4])->orderBy('sent_requests.updated_at','desc')->get();
	}

    /**
	@ this function is used get all job history of a valuer 
	@param inteter user_id required
	@
	@return array
	*/

	function getJobHistories($user_id){
		$file_path = asset(config('app.get_report_path'));
		return $result = self::select('sent_requests.id','sent_requests.property_id','sent_requests.rate','sent_requests.review_description','sent_requests.report_name',DB::raw("CONCAT('".$file_path."','/',sent_requests.report_name) as full_report_path"),'sent_requests.request_status','sent_requests.created_at','sent_requests.purchase_price','sent_requests.property_address','sent_requests.property_type','sent_requests.suburb','sent_requests.state','sent_requests.construction_year','sent_requests.purchase_year','sent_requests.property_new_status','sent_requests.floor_area_unite','sent_requests.floor_area','sent_requests.account_type','property_types.name as property_type_name','states.name as state_name','users.name as investor_name')->join('property_types','sent_requests.property_type','=','property_types.id')->join('users','sent_requests.user_id','=','users.id')->join('states','states.id','=','sent_requests.state')->Where('sent_requests.valuer_id','=',$user_id)->where('sent_requests.request_status','=',5)->orderBy('sent_requests.updated_at','desc')->get();
	}


	 /**
	@ this function is used get all report of a investor 
	@param inteter user_id required
	@
	@return array
	*/

	function getUserAllReports($user_id){
		$file_path = asset(config('app.get_report_path'));
		return $result = self::select('sent_requests.id','sent_requests.property_id','sent_requests.rate','sent_requests.review_description','sent_requests.report_name',DB::raw("CONCAT('".$file_path."','/',sent_requests.report_name) as full_report_path"),'sent_requests.request_status','sent_requests.created_at','sent_requests.purchase_price','sent_requests.property_address','sent_requests.property_type','sent_requests.suburb','sent_requests.state','sent_requests.construction_year','sent_requests.purchase_year','sent_requests.property_new_status','sent_requests.floor_area_unite','sent_requests.floor_area','sent_requests.account_type','property_types.name as property_type_name','states.name as state_name','properties.price')->join('properties','properties.id','=','sent_requests.property_id')->join('property_types','sent_requests.property_type','=','property_types.id')->join('states','states.id','=','sent_requests.state')->Where('sent_requests.user_id','=',$user_id)->where('sent_requests.request_status','=',5)->where('sent_requests.report_view_status','=','1')->orderBy('sent_requests.updated_at','desc')->get();
	}
   
   /**
    * this function get investor all requests for admin use
    *@param required $user_id investor id
    *
    *@return result array
    */
    public function getInvestorAllRequest($user_id){

            $file_path = asset(config('app.get_report_path'));
		return $result = self::select('sent_requests.id','sent_requests.property_id','sent_requests.rate','sent_requests.review_description','sent_requests.report_name','sent_requests.request_status','sent_requests.created_at','sent_requests.purchase_price','sent_requests.property_address','sent_requests.property_type','sent_requests.suburb','sent_requests.state','sent_requests.construction_year','sent_requests.purchase_year','sent_requests.property_new_status','sent_requests.floor_area_unite','sent_requests.floor_area','sent_requests.account_type','property_types.name as property_type_name','states.name as state_name')->join('property_types','sent_requests.property_type','=','property_types.id')->join('states','states.id','=','sent_requests.state')->Where('sent_requests.user_id','=',$user_id)->orderBy('sent_requests.updated_at','desc')->get();
	
    }

    /**
    * this function get valuer all accpeted requests for admin use
    *@param required $user_id valuer id
    *
    *@return result array
    */
    public function getValuerAllRequest($user_id){

            $file_path = asset(config('app.get_report_path'));
		return $result = self::select('sent_requests.id','sent_requests.property_id','sent_requests.rate','sent_requests.review_description','sent_requests.report_name',DB::raw("CONCAT('".$file_path."','/',sent_requests.report_name) as full_report_path"),'sent_requests.request_status','sent_requests.created_at','sent_requests.purchase_price','sent_requests.property_address','sent_requests.property_type','sent_requests.suburb','sent_requests.state','sent_requests.construction_year','sent_requests.purchase_year','sent_requests.property_new_status','sent_requests.floor_area_unite','sent_requests.floor_area','sent_requests.account_type','property_types.name as property_type_name')->join('property_types','sent_requests.property_type','=','property_types.id')->Where('sent_requests.valuer_id','=',$user_id)->orderBy('sent_requests.updated_at','desc')->get();
	
    }
    

    /**
    * this function get all assigned requests
    *@param 
    *
    *@return result array
    */
    public function getAllAssignRequest(){
		return $result = self::select('sent_requests.id','sent_requests.request_status','sent_requests.created_at','u.name as investor_name','u.email as investor_email', DB::raw("(SELECT users.name FROM users WHERE users.id = sent_requests.valuer_id)  as valuer_name"), DB::raw("(SELECT users.email FROM users WHERE users.id = sent_requests.valuer_id)  as valuer_email"))->Where('sent_requests.request_status','>',1)->join('users as u','sent_requests.user_id','=','u.id')->orderBy('sent_requests.updated_at','desc')->get();
	
    }


     /**
    * this function get all pending requests
    *@param 
    *
    *@return result array
    */
    public function getAllPendingRequests(){
		return $result = self::select('sent_requests.id','sent_requests.state','sent_requests.request_status','sent_requests.created_at','u.name as investor_name','u.email as investor_email')->Where('sent_requests.request_status','=',1)->join('users as u','sent_requests.user_id','=','u.id')->orderBy('sent_requests.updated_at','desc')->get();
	
    }


    /**
    * this function get all assigned requests
    *@param 
    *
    *@return result array
    */
    public function getAllCompletedRequest(){
		return $result = self::select('sent_requests.id','sent_requests.request_status','sent_requests.created_at','u.name as investor_name','sent_requests.report_name','u.email as investor_email', DB::raw("(SELECT users.name FROM users WHERE users.id = sent_requests.valuer_id)  as valuer_name"), DB::raw("(SELECT users.email FROM users WHERE users.id = sent_requests.valuer_id)  as valuer_email"))->Where('sent_requests.request_status','=',5)->join('users as u','sent_requests.user_id','=','u.id')->orderBy('sent_requests.updated_at','desc')->get();
	
    }

	
}
