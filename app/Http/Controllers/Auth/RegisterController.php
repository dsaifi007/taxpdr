<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Jobs\SendVerificationEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Redirect;
use Lang;
use App\Models\Role;
use App\Models\UpdateEmailToken;
use App\Traits\SendEmailTrait;
use DB;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    use SendEmailTrait;


    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/success';

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
     * @return redirect
     */
    public function register(Request $request)
   {
           $user_ref = new User;
           $role_model = DB::table('roles')->select('category_name')->where('id','=',$request->account_type)->get();
         $role_category_name = $role_model[0]->category_name;
		   if($role_category_name == 'valuer'){
			   $validator =  $user_ref->valuerValidator($request->all()); // call validator to check other validations
		   }else{
			    $validator =  $user_ref->validator($request->all()); // call validator to check other validations
		   }
            if ($validator->fails()) {
                return Redirect::back()->withInput()->withErrors($validator);
           
           }
            $check_user_email =  User::where('email','=',$request->email)->where('account_type',$request->account_type)->get();
       
            if( count($check_user_email) > 0 ){  // check email already exists or not 
               
               if($check_user_email[0]->confirm_status == 1){
                 return Redirect::back()->with('error_mess',Lang::get('error_code.1004'));
               }else{
                $this->_registorAgain($check_user_email[0]->id,$request);
                    event(new Registered($user = User::find($check_user_email[0]->id)));  // call registered object to event
                    if ($user) {

                
                          dispatch(new SendVerificationEmail($user)); // send veryfication email when success regisertion
               
                        return redirect(route('success',array('message' => 'success'))); //  this route to your needs
                  }
 
                   return Redirect::back(); // Creturn back


               }
               

            }
  
            event(new Registered($user =  $user_ref->storedata($request->all())));  // call registered object to event
            if ($user) {

                
                dispatch(new SendVerificationEmail($user)); // send veryfication email when success regisertion
               
                return redirect(route('success',array('message' => 'success'))); //  this route to your needs
            }
 
           return Redirect::back(); // Creturn back
    }

    private function _registorAgain($user_id,$request){


         $digits = 4;
         $otp = rand(pow(10, $digits-1), pow(10, $digits)-1);
         $role_model = DB::table('roles')->select('category_name')->where('id','=',$request->account_type)->get();
         $role_category_name = $role_model[0]->category_name;
         if( $role_category_name == 'valuer'){
            $data['state'] = $request->state;
            $data['licence_number'] =  $request->licence_number;
         }else{
             $data['state'] = null;
             $data['licence_number'] = null;

         }
         
         
         $user = User::find($user_id);
         $user->name = $request->name;
         $user->email = $request->email;
         $user->password = bcrypt($request->password);
         $user->account_type = $request->account_type;
         $user->role_category = $role_category_name;
         $user->country_code = $request->country_code;
         $user->mobile_no = $request->mobile_no;
         $user->licence_number = $data['licence_number'];
         $user->state = $data['state'];
         $user->api_token = str_random(60);
         $user->confirmation_code = str_random(30);
         $user->otp = $otp;
         return $user->save();
    

   }

    /**
     * Create a verify user .
     *
     * @param  string  $token
     * @return view
     */
   public function verify($token)
   {
        $user = User::where('confirmation_code',$token)->first();
        
        if(count($user) > 0){

            $user->confirm_status = 1;
            $user->confirmation_code = null;
            $user->otp = null;
            if($user->save()){

              $message = "account_verifyed";
              return  view('auth.success')->with(['message' => $message]);
            }else{
                 
                  $message = 1005;
                  return  view('auth.success')->with(['message' => $message]);
            }
        }else{

               $message = 1029;
               return  view('auth.success')->with(['message' => $message]);
            
        }
        

    }


     /**
     * Create a success function to redirect after successfully register user .
     *
     * @return view;
     */

     public function success($message){
        
            return  view('auth.success')->with(['message' => $message]);

     }
	 
	 
	 /**
     * show update profile form .
     *
     * @return view;
     */

     public function myProfile(Request $request){
        
            return  view('auth.myprofile');

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
           $user_id = \Auth::user()->id;
           $user_data = User::find($user_id);
           $check_user_email =  User::where('email','=',$request->email)->where('account_type',$user_data->account_type)->get();
       
           if( count($check_user_email) > 0 ){  // check email already exists or not 

                if($check_user_email[0]->id !=  $user_id){
                     return $response = responseData($error_code=1004,$status=false);
                }

           }
           if($user_data->email != $request->email){

               $this->_sendEmailUpdateMail($request);
                $message ='for_email_update';
           }else{
               
                $user_data->email = ($request->has('email'))?$request->email:$user_data->email;
                $message ='profile_update';
           }     
                 $user_data->name = ($request->has('name'))?$request->name:$user_data->name;
                 $country_code = ($request->has('country_code'))?$request->country_code:$user_data->country_code;
                   if($country_code[0] != '+'){
                       $country_code = '+'.$country_code;
                   }
                 $user_data->country_code = $country_code;
                 $user_data->mobile_no = ($request->has('mobile_no'))?$request->mobile_no:$user_data->mobile_no;
                 $user_data->licence_number = ($request->has('licence_number'))?$request->licence_number:$user_data->licence_number;
                 $user_data->state = ($request->has('state'))?$request->state:$user_data->state;
                 $user_data->save();

                return $response= responseSuccessData($status=true, $message, $count = count($user_data), $data = ['user' => $user_data]);

        
    }


     /**
     * Create a private function to send update email address  .
     *
     * @param  string  $token
     * @return view
     */
   public function _sendEmailUpdateMail(Request $request)
   {    
               // this for check verify email befor registration 
                $user_id = \Auth::user()->id;
                $token = generateRandomString();//helper function
                $verify_email = UpdateEmailToken::where('account_type','=',\Auth::user()->account_type)->where('user_id','=',$user_id)->first();

                if(count($verify_email) == 0){
                     $update_emailtoken_model = new UpdateEmailToken;
                }else{

                    $update_emailtoken_model = UpdateEmailToken::find($verify_email->id);
                }
               
                $update_emailtoken_model->user_id = $user_id;
                $update_emailtoken_model->email = $request->email;
                $update_emailtoken_model->account_type = \Auth::user()->account_type;
                $update_emailtoken_model->token = $token;
                
                if($update_emailtoken_model->save()){
                    
                    $subject = Lang::get('messages.subject_verify_email_update');
                    $template_name = 'update_email_template';
                    $data1['token'] = $token;
                    $site_link = url('/').'/update-email/'.$data1['token'];
                    $data1['email'] = $request->email;
                    $this->commonEmailSender($request->email,$subject,$template_name,$site_link,$name= \Auth::user()->name,$data1);
                    return responseSuccessData($status=true,$message='email_verifyed',$count=1,$data=null);
                }
        
    }


     /**
     * Create a  verify and update eamil user .
     *
     * @param  string  $token
     * @return view
     */
   public function updateVerifyEmail($token)
   {
         $updateemailtoken = UpdateEmailToken::where('token',$token)->first();
        
        if(count($updateemailtoken) > 0){

              $check_user_email =  User::where('email','=',$updateemailtoken->email)->where('account_type',$updateemailtoken->account_type)->get();
       
           if( count($check_user_email) > 0 ){  // check email already exists or not 

                if($check_user_email[0]->id !=  $updateemailtoken->user_id){
                       $message = 1004;
                       return  view('auth.success')->with(['message' => $message]);
                }

           }
            $user = User::find($updateemailtoken->user_id);
            $user->email = $updateemailtoken->email;
            if($user->save()){
               $update_email_model = new UpdateEmailToken;
               $update_email_model->deleteTokenByUserId($updateemailtoken->user_id);
              $message = "update_email_success";
              return  view('auth.success')->with(['message' => $message]);
            }else{
                 
                  $message = 1005;
                  return  view('auth.success')->with(['message' => $message]);
            }
        }else{

               $message = 1029;
               return  view('auth.success')->with(['message' => $message]);
            
        }
        

    }

}
