<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    
     protected $table = 'static_pages_content'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','key-name','content'];

     function getStaticPageContentByID($id){

    	return $result = self::select('name','content')->where('id','=',$id)->get();
    }
}
