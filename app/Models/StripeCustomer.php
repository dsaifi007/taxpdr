<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StripeCustomer extends Model
{
     protected $table = 'stripe_customers'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','stripe_customer_id'];

    function getCustomerByUserId($user_id){
    	$result = self::where('user_id','=',$user_id)->get();
    	if(count($result) > 0){
              return $result[0];
    	}else{
    		return $result = null;
    	}
    }

    
}
