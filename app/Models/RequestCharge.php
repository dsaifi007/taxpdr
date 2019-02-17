<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestCharge extends Model
{
    
     protected $table = 'property_request_charge'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['min_charge','charge'];


    function getAddRequestCharge(){

    	return $result = self::first()->value('charge');
    }

    function getAddRequestMinCharge(){

        return $result = self::first()->value('min_charge');
    }


    function getChargeBaseOnYear($construction_year,$property_new_status){
                     $current_year =  DATE('Y');
                    $year_diff = $current_year - $construction_year;
                    if($year_diff <= 2 && $property_new_status == "yes"){
                      $charge = $this->getAddRequestMinCharge();
                    }else{
                       $charge = $this->getAddRequestCharge();
                    }
            return $charge;
    }
}
