<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Lang;
use DB;
class SavedAddress extends Model
{
     protected $table = 'saved_addresses'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','property_address','suburb','property_type','state','construction_year','purchase_year','property_new_status','purchase_price','floor_area_unite','floor_area'];


     /**
    *@param integer $user_id required
    *
    *@return array;
    */

    public function getSavedAddresses($user_id){


             return $result = self::select('saved_addresses.*','property_types.name as property_type_name',DB::raw("(SELECT states.name FROM states WHERE states.id = saved_addresses.state)  as state_name"))->join('property_types','saved_addresses.property_type','=','property_types.id')->where('user_id','=',$user_id)->orderBy('saved_addresses.id','DESC')->get();

    } 


   /**
    *@param integer $ids required
    *
    *@return array;
    */

    public function getSavedAddressesbyIds($ids,$user_id){

             return $result = self::select('saved_addresses.*','property_types.name as property_type_name')->join('property_types','saved_addresses.property_type','=','property_types.id')->whereIn("saved_addresses.id", $ids)->where('user_id','=',$user_id)->orderBy('saved_addresses.id','ASC')->get();

    } 

    /**
    *@param integer $id required
    *
    *@return array;
    */

    public function getSavedAddressebyId($id,$user_id){

             $result = self::select('saved_addresses.*','property_types.name as property_type_name')->join('property_types','saved_addresses.property_type','=','property_types.id')->where("saved_addresses.id", $id)->where('user_id','=',$user_id)->get();
             if(count($result) > 0){
                   return $result[0];
             }else{
                    return $result = null;
             }

    } 


    public function getSavedAddressById($id){
          
              return $result = self::find($id);


    }


     /**
    * function to delete request by id
    *@param integer $id 
    *
    *@return array;
    */

    public function deleteRequest($id,$user_id){
             
             $result = [];
             $validatedelete = $this->validateDeleteRequest($id,$user_id);
             if($validatedelete == true ){
                $property = self::find($id);
                $property->delete();
                $result['status'] = true;
                $result['message']=Lang::get('messages.property_delete');
             }else{
                $result['status'] = false;
                $result['message']=Lang::get('messages.unable_to_delete');
                
             }
             
             return $result; 

    }
   
    public function validateDeleteRequest($id,$user_id){

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
}
