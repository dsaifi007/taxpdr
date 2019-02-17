<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    
     protected $table = 'contactus'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email','mobile','content'];

    function getContactusDetails(){

    	return $result = self::first();
    }
}
