<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Lang;
class SavedCard extends Model
{
      protected $table = 'saved_card'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','card_holder_name','card_number','card_exp_month','card_exp_year','default_status'];
	
	function updateCardDefaultStatus($user_id){
		
		$data['default_status'] = '0';
		return $query = self::where('user_id','=',$user_id)->update($data);
		
	}
	
	function getUserAllSavedCards($user_id){
		
		return $results = self::where('user_id','=',$user_id)->orderBy('id','desc')->get();
	}
	
	
	function getSavedCardByCardNumber($card_number,$user_id){
		
		return $results = self::where('card_number','=',$card_number)->where('user_id','=',$user_id)->get();
	}
	
	
	/**
    * function to delete request by id
    *@param integer $id 
    *
    *@return array;
    */

    public function deleteRequest($id,$user_id){
             
             $result = [];
             $validatedelete = $this->validateDelete($id,$user_id);
             if($validatedelete == true ){
                $property = self::find($id);
                $property->delete();
                $result['status'] = true;
                $result['message']=Lang::get('messages.card_delete');
             }else{
                $result['status'] = false;
                $result['message']=Lang::get('messages.unable_to_delete_card');
                
             }
             
             return $result;
            

    }
    /**
    * function to validate delete request by id and user id
    *@param integer $id 
    *@param integer $user_id 
	*
    *@return true ,false;
    */
    public function validateDelete($id,$user_id){

            $find_request = self::where('id','=',$id)->where('user_id','=',$user_id)->get();
            if (count($find_request) > 0) 
            {  
                 return true;
            }
            else
            {
                return false;
            }
    }
	
	function updateLastAsdefault($user_id){
		
        $data['default_status'] = '0';
		$update_default_status = self::where('user_id','=',$user_id)->update($data);
		$data['default_status'] = '1';
		$find_request = self::where('user_id','=',$user_id)->OrderBy('created_at','DESC')->first();
        if(count($find_request) > 0){
            $update_default_status = self::where('id','=',$find_request->id)->update($data);
        }
		
	}

    function updateDefaultCard($user_id,$id){
        $data['default_status'] = '0';
        $update_default_status = self::where('user_id','=',$user_id)->update($data);
        $data['default_status'] = '1';
        return $update_default_status = self::where('user_id','=',$user_id)->where('id','=',$id)->update($data);
    }

    function getCardDataByIdUserId($id,$user_id){
        return $result = self::where('id','=',$id)->where('user_id','=',$user_id)->orderBy('id','desc')->get();
        
    }
	
}
