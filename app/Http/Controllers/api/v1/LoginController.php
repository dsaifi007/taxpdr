<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Lang;
use Validator;
use App\Traits\SendEmailTrait;
class LoginController extends Controller
{
    use SendEmailTrait;  
    /**
     *
     * Check login for given inputs
     *
     * @param  array $Request required
     * 
     * @return json
     */ 
    public function attemptLogin(Request $request)
    {

        $user_ref = new User;
        $redirect_url = ''; //difine var for redirect after login
        $validator =  $user_ref->loginValidator($request->all()); // call validator to check other validations

        if ($validator->fails()) {  // check valid input data validations
            $response  = ['status' => false, 'error_code' => 1002,'error_message' => Lang::get('error_code.1002'),'error_description' => Lang::get('error_code_description.1002'),'erros'=>$validator->errors()];
            return response()->json($response);
        }else{
                
                $check_email_exists =  User::where('email','=',$request->email)->get();
                if(count($check_email_exists) == 0 ){  // check email already exists or not 

                     return $response = responseData($error_code=1012,$status=false);

                }

                $check_user_email =  User::where('email','=',$request->email)->where('account_type',$request->account_type)->get();
                if(count($check_user_email) == 0 ){  // check email with type already exists or not 

                     return $response = responseData($error_code=1013,$status=false);

                }
                 // check user is valid or not
                $veryfi_count = $user_ref->checkConfirmStatus($request->email,$request->account_type);
                if($veryfi_count == 0 ){
                    return $response = responseData($error_code=1010,$status=false);
                     
                }

                if($check_user_email[0]->status == 0){
                     return $response = responseData($error_code=1038,$status=false);
                }

            if (\Auth::attempt(['email' => $request->email, 'password' => $request->password, 'confirm_status' => 1,'account_type'=>$request->account_type])) { 
		 		$user_data = \Auth::user();
		 		if($user_data->role_category == 'investor') { // check user is investor or valuer
		 			$redirect_url = 'investor';
				}elseif($user_data->role_category == 'valuer'){
		 			$redirect_url = 'valuer';
		 		}
		 		return response()->json(['status' => true, 'data' => ['user' =>$user_data,'redirect'=>$redirect_url] ]);
		 	}else {
		 		return $response = responseData($error_code=1028,$status=false);
		 	}

        }
           
	}

    /**
     * Get a validator for an incoming password change request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'old_password'     => 'required',
            'new_password'     => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);
    }


    public function updatePassword(Request $request)
        {
        $validate =  $this->validator($request->all());
       
        if ($validate->fails()) {  // check valid input data validations
            
            if($validate->errors()->has('new_password')){
                $message_error = $validate->errors()->get('new_password');
            }
            if($validate->errors()->has('old_password')){
                $message_error = $validate->errors()->get('old_password');
            }
            if($validate->errors()->has('confirm_password')){
                $message_error = $validate->errors()->get('confirm_password');
            }

            $response  = ['status' => false, 'error_code' => 1002,'error_message' =>$message_error,'error_description' => $message_error];

            return response()->json($response);
        }
        $data = $request->all();
        $user_id = \Auth::guard('api')->user()->id;
        $user = User::find($user_id);
        if(!(\Hash::check($data['old_password'], $user->password))){
           
            return $response = responseData($error_code=1027,$status=false);

        }else{
              $user->password = bcrypt($data['new_password']);
              $user->save();
              $responsed_data = $this->commonEmailSender(\Auth::guard('api')->user()->email,$subject="Your TaxPDR password changed",$template_name="password_reset_confir_email",$site_link=null,$name=\Auth::guard('api')->user()->name,$data1=null);
            return $response= responseSuccessData($status=true, $message='password_update', $count = count($user), $data = $user);
            
        }
    }


    /**
     *
     * Check auto login 
     *
     * @param  array $Request required
     * 
     * @return json
     */ 
    public function autoLogin(Request $request)
    {
          $user  = User::where('api_token','=',$request->api_token)->first();
          if($user){
             return response()->json(['status' => true, 'data' => ['user' =>$user]]);
            }else {
                return $response = responseData($error_code=1015,$status=false);
            }
     
           
    }


}
