<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Traits\SendEmailTrait;
use Illuminate\Support\Facades\Redirect;
use Lang;
use Validator;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    use SendEmailTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email',
            'account_type' => 'required' ]);
    }

    /**
    * Send a reset link to the given user.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function postEmail(Request $request)
    {
       $validator = $this->validator($request->all());
       if($validator->fails()){
            return Redirect::back()->withInput()->withErrors($validator);
       }else{
            $email = $request->email;
            $account_type = $request->account_type;
            $responsed_data = $this->forgotPasswordEmail($email,$account_type);
            if($responsed_data['status'] == 'invalid_email'){
               return Redirect::back()->with('error_msg',Lang::get('error_code.1013'));
            }elseif($responsed_data['status'] == 'email_sent'){

                      return Redirect::back()->with('succ-messages',Lang::get('messages.reset_password_email'));
                     
            }elseif($responsed_data['status'] == 'error'){
                return Redirect::back()->with('error_msg',Lang::get('error_code.1003'));
            }
            else{
                   return Redirect::back()->with('error_msg',Lang::get('error_code.1003'));
           
           }

       }
       
 
    }
}
