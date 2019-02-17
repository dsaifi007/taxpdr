<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Lang;
class Properties extends Model
{
      protected $table = 'properties'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','property_address','suburb','property_type','state','payment_status','status','construction_year','purchase_year','property_new_status','purchase_price','floor_area_unite','floor_area'
    ];
    
    /**
    *@param integer $user_id required
    *
    *@return array;
    */

    public function getNewlyAddedRequest($user_id){

             return $result = self::select('properties.*','property_types.name as property_type_name')->join('property_types','properties.property_type','=','property_types.id')->where('user_id','=',$user_id)->orderBy('properties.id','ASC')->where('properties.status','=','0')->get();

    }


     /**
     *this function is used for get all sent requests
    *@param integer $user_id required
    *
    *@return array;
    */

    public function getSentRequest($user_id){

             return $result = self::select('properties.*','property_types.name as property_type_name')->join('property_types','properties.property_type','=','property_types.id')->where('user_id','=',$user_id)->orderBy('properties.id','ASC')->get();

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
    /**
    * function to validate delete request by id and user id
    *@param integer $id 
    *@param integer $user_id 
	*
    *@return true ,false;
    */
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
	
	/**
    * function get property by id
    *@param integer $id
	*
    *@return array;
    */
    public function getPropertyById($id){

              return $result = self::find($id);


    }

     /**
    * function update property payment status and remove from cart
    *@param integer $user_id
    *
    *@return array;
    */
    public function updatePropertyStatus($user_id){

            $results = self::select('properties.id','cart.id as cart_id')->join('cart','properties.id','=','cart.property_id')->where('properties.user_id','=',$user_id)->get();
            $total_update = 0;
            if(count($results) > 0){

                foreach($results as $result){
                    
                    $property = self::find($result->id);
                    $property->payment_status = 1;
                    $property->save();
                    $cart_model = new Cart;
                    //$cart_model->deleteRequest($result->cart_id,$user_id);
                    $total_update++;

                }

            }

            return $total_update;



    }
}
