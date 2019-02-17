<?php

namespace App\Http\Controllers\api\v1;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Jobs\SendVerificationEmail;
use Illuminate\Auth\Events\Registered;
use App\Models\RegistrationOtp;
use App\Models\Role;
use App\User;
use App\Traits\SendEmailTrait;
use Lang;
use DB;


class RegistrationController extends Controller
{



      use SendEmailTrait;

   
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    /**
     *
     * Check register for input
     *
     * @param  array $Request required
     * 
     * @return json
     */
    public function attemptRegister(Request $request)
    {

        $user_ref = new User;
        $check_user_email =  User::where('email','=',$request->email)->where('account_type',$request->account_type)->get();
       
        if( count($check_user_email) > 0 ){  // check email already exists or not 

             return $response = responseData($error_code=1004,$status=false);

        }
        $validator =  $user_ref->validatorApi($request->all()); // call validator to check other validations
        $role_model = DB::table('roles')->select('category_name')->where('id','=',$request->account_type)->get();
         $role_category_name = $role_model[0]->category_name;
		if( $role_category_name == 'valuer'){
			   $validator =  $user_ref->valuerValidatorApi($request->all()); // call validator to check other validations
		}else{
			    $validator =  $user_ref->validatorApi($request->all()); // call validator to check other validations
		}
        if ($validator->fails()) {
            return $response = responseData($error_code=1002,$status=false);
        }
        // this for check verify email befor registration 
        $verify_email = RegistrationOtp::where('email','=',$request->email)->where('account_type','=',$request->account_type)->where('otp','=',$request->otp)->count();

        if($verify_email == 0){
             return $response = responseData($error_code=1010,$status=false);
        }
        if($request->account_type != 1) { // check user only invester or valuer not admin
           
            event(new Registered($user =  $user_ref->storedata($request->all())));  // call registered object to event

            if ($user) {
                   
                       $user->confirm_status = 1;
                       $user->confirmation_code = null;
                       $user->otp = null;
                       $user->save();
            	 $this->commonEmailSender($request->email,$subject='Welcome to TaxPDR ',$template_name="welcome_email_mobile",$site_link=null,$name=$request->name,$data1=null);

                return $response= responseSuccessData($status=true, $message='success_registor', $count = count($user), $data = ['user' => $user]);
            }
        }
        return $response = responseData($error_code=1003,$status=false);
    }

    /**
     * Create a verify user using otp .
     *
     * @param  string  $token
     * @return view
     */
   public function verifyByOtp(Request $request)
   {    
        $user_model = new User;
        $validator = $user_model->otpValidator($request->all());
        if($validator->fails()) {
            return $response = responseData($error_code=1008,$status=false);
        }
        $user = User::where('otp',$request->otp)->first();
        if(count($user) > 0){  // check otp exits or not 
            $user->confirm_status = 1;
            $user->confirmation_code = null;
            $user->otp = null;
            if($user->save()){  //update confirm status 
                return responseSuccessData($status=true,$message='account_verifyed',$count=1,$data=$user);
            }else{

               return $response = responseData($error_code=1005,$status=false);
            }
        }else{

             return $response = responseData($error_code=1029,$status=false);
        }

    }
  

    /**
     * Create a verify user using otp .
     *
     * @param  string  $token
     * @return view
     */
   public function generateVerifyEmailByOtp(Request $request)
   {    
        $registrationOtp_model = new RegistrationOtp;
        $validator = $registrationOtp_model->otpValidator($request->all());
        if($validator->fails()) {
            return $response = responseData($error_code=1001,$status=false);
        }

         $check_user_email =  User::where('email','=',$request->email)->where('account_type',$request->account_type)->get();
       
        if( count($check_user_email) > 0 ){  // check email already exists or not 

             return $response = responseData($error_code=1004,$status=false);

        }

        $digits = 4;
        $otp = rand(pow(10, $digits-1), pow(10, $digits)-1);
        $allready_email =  $registrationOtp_model->checkAlreadyEmailOtp($request->email,$request->account_type);
        
        if(count($allready_email)){
             $registrationOtp_model = RegistrationOtp::find($allready_email[0]->id);
        }
            $registrationOtp_model->email = $request->email;
            $registrationOtp_model->account_type = $request->account_type;
            $registrationOtp_model->otp = $otp;
            $registrationOtp_model->save();
            $subject = Lang::get('messages.email_otp_subject');
            $template_name = 'email_otp_verification';
            $data1['otp'] = $otp;
            $data1['email'] = $request->email;
            $this->commonEmailSender($request->email,$subject,$template_name,$site_link=null,$name=null,$data1);
            return responseSuccessData($status=true,$message='email_verifyed',$count=1,$data=null);
        
    }


    /**
     *
     * Check update profile for input
     *
     * @param  array $Request required
     * 
     * @return json
     */
    public function updateProfile(Request $request)
    {
           $user_id = \Auth::guard('api')->user()->id;
           $user_data = User::find($user_id);
           $check_user_email =  User::where('email','=',$request->email)->where('account_type',$user_data->account_type)->get();
       
           if( count($check_user_email) > 0 ){  // check email already exists or not 

                if($check_user_email[0]->id !=  $user_id){
                     return $response = responseData($error_code=1004,$status=false);
                }

           }
           if($user_data->email != $request->email){

                 // this for check verify email befor registration 
                $verify_email = RegistrationOtp::where('email','=',$request->email)->where('account_type','=',$request->account_type)->where('otp','=',$request->otp)->count();

                if($verify_email == 0){
                    return $response = responseData($error_code=1010,$status=false);
                }
           }
                 
                 $user_data->name = ($request->has('name'))?$request->name:$user_data->name;
                 $user_data->email = ($request->has('email'))?$request->email:$user_data->email;
                 $user_data->country_code = ($request->has('country_code'))?$request->country_code:$user_data->country_code;
                 $user_data->mobile_no = ($request->has('mobile_no'))?$request->mobile_no:$user_data->mobile_no;
                 $user_data->licence_number = ($request->has('licence_number'))?$request->licence_number:$user_data->licence_number;
                 $user_data->state = ($request->has('state'))?$request->state:$user_data->state;
                 $user_data->save();
                return $response= responseSuccessData($status=true, $message='profile_update', $count = count($user_data), $data = ['user' => $user_data]);

        
    }

}
