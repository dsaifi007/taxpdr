<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationOtp extends Model
{
     protected $table = 'email_otp'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email','account_type','otp'];

    /**
     * Get a validator for an incoming otp request.
     *
     * @param  array  $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function otpValidator(array $data)
    {
        return \Validator::make($data, [
            'email' => 'required|email',
            'account_type' => 'required|numeric',
        ]);
    }


    function checkAlreadyEmailOtp($email,$account_type){
    	
    	return $query = self::where('email','=',$email)->where('account_type','=',$account_type)->get();

       }

}
