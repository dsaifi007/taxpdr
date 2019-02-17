<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\User;
use App\Models\SentRequest;
use Lang;
use App\Traits\SendEmailTrait;
use Validator;
class LoginController extends Controller
{
    use SendEmailTrait;
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        //$this->middleware('guest')->except('logout');
    }

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
            return Redirect::back()->withInput()->withErrors($validator);
        }else{
                 $check_email_exists =  User::where('email','=',$request->email)->get();
                if(count($check_email_exists) == 0 ){  // check email already exists or not 

                    return Redirect::back()->withInput()->with('error_mess',Lang::get('error_code_description.1012'));

                }

                $check_user_email =  User::where('email','=',$request->email)->where('account_type',$request->account_type)->get();
                if(count($check_user_email) == 0 ){  // check email already exists or not 

                    return Redirect::back()->withInput()->with('error_mess',Lang::get('error_code_description.1013'));

                }
                // check user is valid or not
                $veryfi_count = $user_ref->checkConfirmStatus($request->email,$request->account_type);
                if($veryfi_count == 0 ){
                      return Redirect::back()->withInput()->with('error_mess',Lang::get('error_code_description.1010'));
                }
                if($check_user_email[0]->status == 0){
                    return Redirect::back()->withInput()->with('error_mess',Lang::get('error_code_description.1038'));
                }
                 

            if (\Auth::attempt(['email' => $request->email, 'password' => $request->password, 'confirm_status' => 1,'account_type'=>$request->account_type,'status'=>1])) { 
                $user_data = \Auth::user();
                if($user_data->role_category == 'valuer') { // check user is investor or valuer
                    
                 return redirect(route('valuer-dashboard')); //  this route to your needs
                }else{
                    $count_request = SentRequest::where('user_id','=',$user_data->id)->count();
                    if($count_request > 0){
                        return redirect(route('investor-dashboard')); //  this route to your needs
                    }else{
                        return redirect(route('investor.createrequestform')); //  this route to your needs
                    }
               
                    
                }
                
            }else {

                  return Redirect::back()->withInput()->with('error_mess',Lang::get('error_code_description.1028'));
                
            }

        }
           
    }
	
	
	/**
     * show change password form .
     *
     * @return view;
     */

     public function showProfileSetting(Request $request){
        
            return  view('auth.profile_setting');

     }

     /**
     * show valuer change password form .
     *
     * @return view;
     */

     public function showValuerChabgePassword(Request $request){
        
            return  view('auth.valuer_change_password');

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
        $user_id = \Auth::user()->id;
        $user = User::find($user_id);
        if(!(\Hash::check($data['old_password'], $user->password))){
           
            return $response = responseData($error_code=1027,$status=false);

        }else{
              $user->password = bcrypt($data['new_password']);
              $user->save();
             $responsed_data = $this->commonEmailSender(\Auth::user()->email,$subject="Your TaxPDR password changed",$template_name="password_reset_confir_email",$site_link=null,$name=\Auth::user()->name,$data1=null);
            return $response= responseSuccessData($status=true, $message='password_update', $count = count($user), $data = $user);
            
        }
    }

}
