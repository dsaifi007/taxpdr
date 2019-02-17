<?php

namespace App\Models;
use Lang;
use DB;
use Illuminate\Database\Eloquent\Model;
class Cart extends Model
{
     protected $table = 'cart'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['property_id','user_id'];

    /**
     * This function is used for get cart item
    *@param integer $user_id required
    *
    *@return array;
    */
    public function getCartItems($user_id){

             return $result = self::select('cart.*','properties.property_address','properties.suburb','properties.state','properties.property_type','properties.price','properties.construction_year','properties.purchase_year','properties.property_new_status','properties.purchase_price','properties.floor_area_unite','properties.floor_area','property_types.name as property_type_name',DB::raw("(SELECT states.name FROM states WHERE states.id = properties.state)  as state_name"))->join('properties','cart.property_id','=','properties.id')->join('property_types','properties.property_type','=','property_types.id')->where('cart.user_id','=',$user_id)->orderBy('cart.id','ASC')->get();

    } 


     /**
     * This function is used for get cart item total amount
    *@param integer $user_id required
    *
    *@return array;
    */
    public function getCartItemsTotalCharge($user_id){

             return $result = self::select(DB::raw("SUM(properties.price) as totalamount"))->join('properties','cart.property_id','=','properties.id')->where('cart.user_id','=',$user_id)->get();

    } 


     /**
     * This function is used for get cart item total amount
    *@param integer $user_id required
    *
    *@return array;
    */
    public function getCartItemsPropertiesId($user_id){

          $result = self::select(DB::raw('group_concat(property_id) as property_ids'))->where('user_id','=',$user_id)->get();
          if(count($result) > 0){
               return $result = $result[0]->property_ids;
          }else{

                 return $result = null;
          }

    } 

	 /**
     * This function is used for get cart item
    *@param integer $id required
    *
    *@return array;
    */
    public function getCartItemById($id){

             return $result = self::select('cart.*','properties.property_address','properties.suburb','properties.state','properties.property_type','properties.price','properties.construction_year','properties.purchase_year','properties.property_new_status','properties.purchase_price','properties.floor_area_unite','properties.floor_area','property_types.name as property_type_name')->join('properties','cart.property_id','=','properties.id')->join('property_types','properties.property_type','=','property_types.id')->where('cart.id','=',$id)->orderBy('properties.id','ASC')->get();
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
     * This function is used for delete user cart items by user id 
    *@param integer $user_id required
    *
    *@return array;
    */
    public function deleteCartItemByuserId($user_id){

             $results = self::select('*')->where('user_id','=',$user_id)->get();
			 if(count($results) > 0){
				 foreach($results as $result){
					 $this->deleteRequest($result->id,$user_id);
				 }
			
			 }

    } 


    /** 
    * this function is used update cart when saved address update
    *@param integer saved_address_id required
    *
    *@return true;
    */

    public function updateCartSavedAddressId($saved_address_id){
          
           $getcartdata = self::where('saved_address_id','=',$saved_address_id)->get();
           if(count($getcartdata) > 0){
            $cart = self::find($getcartdata[0]->id);
            $cart->saved_address_id = null;
            return $cart->save();

           }else{
              return true;
           }

    }
	
	
	
}
