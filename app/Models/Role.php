<?php

namespace App\app\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
   
    protected $table = 'roles'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','category_name'
    ];

    public function gellAllAccountType(){
           
          return $result = self::where('id','!=',1)->get();
    }

    function getCategoryNameById($id){
        
        return $result = self::find($id);

    }
    
}
