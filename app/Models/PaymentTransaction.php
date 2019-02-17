<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
     protected $table = 'payment_transactions'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['property_ids','user_id','charge_id','amount','per_request_price','transaction_status'];

    function getAllTranctions(){

    	return $result = self::select('payment_transactions.charge_id','payment_transactions.created_at','users.name as investor_name','users.email as investor_email','payment_transactions.transaction_status','payment_transactions.amount')->join('users','payment_transactions.user_id','=','users.id')->get();
    }
}
