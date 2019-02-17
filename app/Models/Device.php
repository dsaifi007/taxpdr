<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
     protected $table = 'devices'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'clientid','appname','appversion','deviceuid','devicetoken','devicename','devicemodel','deviceversion','os_type','status'
    ];
    /**
    * This function is use for check client 

    */
    public function getDeviceByDeviceToken($devicetoken,$clientid){

    	return $result = self::select('id')->where('devicetoken','=',$devicetoken)->where('clientid','=',$clientid)->get();
    }

    
}
