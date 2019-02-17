<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RejectJob extends Model
{
     protected $table = 'rejected_request_users'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','property_id'];


}
