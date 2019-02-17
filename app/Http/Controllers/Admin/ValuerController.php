<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Properties;
use App\Models\RequestCharge;
use App\Models\SavedAddress;
use App\Models\Cart;
use App\Models\SentRequest;
use App\User;
use Lang;
use Validator;
use Carbon\Carbon as Corbon;


class ValuerController extends Controller
{
   
    /**
    *this function is used for show valuer profile
    *return  $status;
    */
    public function valuerProfile($inveator_id){
          
          if($inveator_id == null){
            return Redirect::back();
          }
          $i=1;
          $user_details = User::find($inveator_id);
          $sentrequest_model = new SentRequest;
          $all_requests = $sentrequest_model->getValuerAllRequest($inveator_id);
          return view('admin.valuer-details')->with(compact(['user_details','all_requests','i']));

    }
}
