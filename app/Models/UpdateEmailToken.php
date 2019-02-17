<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UpdateEmailToken extends Model
{
     protected $table = 'update_email_token'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email','account_type','token'];

    function checkAlreadyEmailToken($email,$account_type){
    	
    	return $query = self::where('email','=',$email)->where('account_type','=',$account_type)->get();

       }

       function deleteTokenByUserId($user_id){
             
             $results = self::where('user_id','=',$user_id)->get();
             if(count($results) > 0 ){
                $id = $results[0]->id;
                $tokendata = self::find($id);
                $tokendata->delete();
             }

       }
}
