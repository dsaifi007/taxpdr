<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VersionControl extends Model
{
    protected $table = 'version_control'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','os_type'
    ];

    public function getVersionCount($name,$ostype){
           
          return $result = self::where('name','=',$name)->where('os_type','=',$ostype)->count();
    }
}
