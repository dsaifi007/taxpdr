<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;
use App\Traits\SendEmailTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\User;
use App\Models\SentRequest;
use App\Models\StaticPage;
use App\Models\PaymentTransaction;
use Lang;
use Validator;

class AdminController extends Controller
{
    //
	 use SendsPasswordResetEmails;

         use SendEmailTrait;

	
	public function showLogin(){
		
		 return view('admin/sign-in');
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
        $validator =  $user_ref->adminValidator($request->all()); // call validator to check other validations
        if ($validator->fails()) {  // check valid input data validations
            return Redirect::back()->withInput()->withErrors($validator);
        }else{
                 $check_email_exists =  User::where('email','=',$request->email)->get();
                if(count($check_email_exists) == 0 ){  // check email already exists or not 

                    return Redirect::back()->withInput()->with('error_mess',Lang::get('error_code_description.1012'));

                }

                $check_user_email =  User::where('email','=',$request->email)->where('account_type','=',1);
                if(count($check_user_email) == 0 ){  // check email already exists or not 

                    return Redirect::back()->withInput()->with('error_mess',Lang::get('error_code_description.1013'));

                }
                // check user is valid or not
                $veryfi_count = $user_ref->checkConfirmStatus($request->email,1);
                if($veryfi_count == 0 ){
                      return Redirect::back()->withInput()->with('error_mess',Lang::get('error_code_description.1010'));
                }
            if (\Auth::attempt(['email' => $request->email, 'password' => $request->password, 'confirm_status' => 1,'account_type'=>1])) { 
                $user_data = \Auth::user();
                    return redirect(route('admin.dashboard')); //  this route to your needs
                
            }else {

                  return Redirect::back()->withInput()->with('error_mess',Lang::get('error_code_description.1028'));
                
            }

        }
           
    }

    public function showChangePassword(){
         
         return view('admin.change-password');

    }

    public function showTermsCondition(){
         
         $terms_conditions = StaticPage::find(1);
         $policy = StaticPage::find(2);
         return view('admin.terms-conditions')->with(compact(['terms_conditions','policy']));

    }

    public function updateContent(Request $reruest){
         
         $terms_conditions = StaticPage::find(1);
         $terms_conditions->content = $reruest->terms_conditions;
         $terms_conditions->save();
         $policy = StaticPage::find(2);
         $policy->content = $reruest->policy;
         $policy->save();
         return Redirect::back()->withInput()->with('error_mess',Lang::get('error_code_description.1013'));

    }

    public function showResetForm($token){
         
         return view('admin.passwords.reset')->with(compact('token'));

    }
	
	public function dashboard(){
		 $user_model = new User;
         $all_investors = $user_model->getAllInvestors();
         $i = 1;
		 return view('admin/manage-user')->with(compact(['all_investors','i']));
	}

    public function manageValuers(){
         $user_model = new User;
         $all_valuers = $user_model->getAllValuers();
         $i = 1;
         return view('admin/manage-valuers')->with(compact(['all_valuers','i']));
    }

    
    public function manageRequests(){
         $sentrequest_model = new SentRequest;
         $all_requests = $sentrequest_model->getAllAssignRequest();
         $i = 1;
         return view('admin/manage-requests')->with(compact(['all_requests','i']));
    }

    public function managePendingRequests(){
         $sentrequest_model = new SentRequest;
         $all_requests = $sentrequest_model->getAllPendingRequests();
         $i = 1;
         return view('admin/pending-request')->with(compact(['all_requests','i']));
    }

     public function assignValuer($request_id,$valuer_id){

         $user = User::find($valuer_id);
         $sentrequest_model = SentRequest::find($request_id);
         $sentrequest_model->valuer_id = $valuer_id;
         $sentrequest_model->request_status = 2;
         $sentrequest_model->account_type = $user->account_type;
         $sentrequest_model->save();
         return redirect::back()->with('message',Lang::get('messages.assign_success'));
    }

    public function manageCompletedRequests(){
         $sentrequest_model = new SentRequest;
         $all_requests = $sentrequest_model->getAllCompletedRequest();
         $i = 1;
         return view('admin/completed-requests')->with(compact(['all_requests','i']));
    }

    public function manageTransactions(){
          $PaymentTransaction = new PaymentTransaction;
          $all_requests =  $PaymentTransaction->getAllTranctions();
          $i = 1;
         return view('admin/manage-transactions')->with(compact(['all_requests','i']));
    }

	public function logout(Request $request) {
            \Auth::logout();
            return redirect::route('admin.adminlogin');
    }
	
	
	public function forgotPassword(){
		
		 return view('admin.passwords.email');
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
