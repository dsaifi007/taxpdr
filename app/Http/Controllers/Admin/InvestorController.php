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

class InvestorController extends Controller
{
    /**
    *this function is used for update status
    *return  $status;
    */
    public function updateInvestorStatus(Request $request){
          
          $new_status = $request->status;
          $user = User::find($request->id);
          $user->status = $new_status;
          $user->save();
          return $new_status;

    }


     /**
    *this function is used for show investor profile
    *return  $status;
    */
    public function investorProfile($inveator_id){
          
          if($inveator_id == null){
            return Redirect::back();
          }
          $i=1;
          $user_details = User::find($inveator_id);
          $sentrequest_model = new SentRequest;
          $all_requests = $sentrequest_model->getInvestorAllRequest($inveator_id);
          return view('admin.investor-details')->with(compact(['user_details','all_requests','i']));

    }
}
