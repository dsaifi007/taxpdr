<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;
use DateTime;
use Lang;

class CalculatorSearch extends Model
{
   protected $table = 'calculator_search_info'; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','property_type','construction_year','purchase_year','property_new_status','purchase_price','floor_area_unite','floor_area','calculate_price'];
    
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'property_type' => 'required',
            'construction_year' => 'required',
            'purchase_year' => 'required',
            'property_new_status' => 'required',
            'purchase_price' => 'required',
             
        ]);
    }

    public function calculateDepreciation($request,$user_id){
	      $validator = $this->validator($request->all());
	      if($validator->fails()){
	                return $response = responseData($error_code=1002,$status=false);
	      }
	      
	      //$construction_year_date = Date($request->construction_year.'-01'.'-01');
	       $time = strtotime($request->construction_year."/01/01");
           $newformat = Date('Y-m-d',$time);
	       $current_date = Date('Y-m-d');
	       $d1 = new DateTime($newformat);
           $d2 = new DateTime($current_date);
           $diff = $d2->diff( $d1 );
           $total_year =  $diff->y;
	       if($total_year <= 8){
		        $dep_price = round(((2.5 / 100) * $request->purchase_price),2);
		        $data['user_id'] = $user_id;
		        $data['property_type'] = $request->property_type;
		        $data['construction_year'] = $request->construction_year;
		        $data['purchase_year'] = $request->purchase_year;
		        $data['property_new_status'] = $request->property_new_status;
		        $data['purchase_price'] = $request->purchase_price;
		        $data['floor_area_unite'] = $request->floor_area_unite;
		        $data['floor_area'] = $request->floor_area;
		        $data['calculate_price'] = $dep_price;
	            $result =  self::create($data);
	            $result['dep_price'] = $dep_price;
	            $result['price_after_dep'] = $request->purchase_price - $dep_price;
		        return responseSuccessData($status=true,$message='data_found',count($result),['calculate_info'=>$result],'dep');
		      }else{
	           
	             return $response  = ['status' => false, 'error_code' => 1032,'error_message' => Lang::get('error_code.1032'),'error_description' => Lang::get('error_code_description.1032')];

	      }
      

    }
}
