<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactUsQuery extends Model
{
     protected $table = 'contact_us_queries'; 
	   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','email','subject','phone','message'];
}
