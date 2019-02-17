<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Validator;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Lang;
class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'token' => 'required',
            'password_confirmation' => 'required',
            'password' => 'required|confirmed']);
    }
   

    /**
    *this function is used to reset forgot password
    *@param $request with token,password,newpassword,
    *
    *@return view
    */
    public function resetPassword(Request $request){
            
            $user = new User;
            $validator = $this->validator($request->all());
            if($validator->fails()){
               
               return Redirect::back()->withInput()->withErrors($validator);
            }else{
                   $token_string = $request->token;
                   $decoded_data = $this->_tokenStringDecode($token_string);
                   $token_exp_status =  $user->checkTokenExpir($decoded_data['token'],$decoded_data['auccont_type']);
                  
                  if(count($token_exp_status) > 0 ){
                      $password = bcrypt($request->password);
                      $email = $token_exp_status[0]->email;
                      $token_exp_status =  $user->saveNewPassword($password,$email,$decoded_data['auccont_type']);
					  if($decoded_data['auccont_type'] == 1){
						  return Redirect::route('admin.adminlogin')->with('message',Lang::get('messages.reset_password_success'));
					  }else{
						  return Redirect('/login')->with('message',Lang::get('messages.reset_password_success'));
					  }
                     
                  }else{

                     return Redirect::back()->with('error_mesg',Lang::get('error_code.1007'));
                  }

            }

    }

    /**
    *this private function is decode url and get parameters
    *@param $token_string string required,
    *
    *@return array
    */
    private function _tokenStringDecode($token_string){

                $data = [];
                $data['token'] =  null;
                $data['auccont_type'] =  null;
                $token_data = base64_decode($token_string);
                $token_array = explode('-',$token_data);
                $auccont_type = $token_array[0];
                $token = $token_array[1];
                $data['token'] =  $token;
                $data['auccont_type'] =  $auccont_type;
                return $data;

    }

}
