<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Validator;
use DB;
use Carbon\Carbon as Carbon;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','account_type','country_code','mobile_no','api_token','confirm_status','confirmation_code','otp','licence_number','state','role_category'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['remember_token','confirmation_code','otp'
    ];

 /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:25',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'account_type' => 'required|min:1',
            'country_code' => 'required',
            'mobile_no' => 'required|numeric|min:10',
        ]);
    }
     
	  /**
     * Get a validator for an incoming registration request for valuer.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function valuerValidator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:25',
            'email' => 'required|string|email|max:255',
            'licence_number' => 'required',
            'state' => 'required',
            'password' => 'required|string|min:6',
            'account_type' => 'required|min:1',
            'country_code' => 'required',
            'mobile_no' => 'required|numeric|min:10',
        ]);
    }

/**
     * Get a validator for Api an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validatorApi(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:25',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'account_type' => 'required|min:1',
            'country_code' => 'required',
            'mobile_no' => 'required|numeric|min:10',
            'otp' => 'required|numeric|min:4',
        ]);
    }
     
      /**
     * Get a validator for Api an incoming registration request for valuer.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function valuerValidatorApi(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:25',
            'email' => 'required|string|email|max:255',
            'licence_number' => 'required',
            'state' => 'required',
            'password' => 'required|string|min:6',
            'account_type' => 'required|min:1',
            'country_code' => 'required',
            'mobile_no' => 'required|numeric|min:10',
            'otp' => 'required|numeric|min:4',
        ]);
    }

     /**
     * Get a validator for an incoming login request.
     *
     * @param  array  $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function loginValidator(array $data)
    {
        return Validator::make($data, [
            'account_type' => array('required'),
            'email' => 'required|email|',
            'password' => 'required',
        ]);
    }
    
	 /**
     * Get a validator for an incoming login request.
     *
     * @param  array  $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function adminValidator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|',
            'password' => 'required',
        ]);
    }

    /**
     * Get a validator for an incoming otp request.
     *
     * @param  array  $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function otpValidator(array $data)
    {
        return Validator::make($data, [
            'otp' => 'required|numeric|min:4',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function storedata($data)

    {   
         $digits = 4;
         $otp = rand(pow(10, $digits-1), pow(10, $digits)-1);
         $role_model = DB::table('roles')->select('category_name')->where('id','=',$data['account_type'])->get();
         $role_category_name = $role_model[0]->category_name;
         if($role_category_name == 'valuer'){
            $data['state'] = $data['state'];
         }else{
             $data['state'] = null;
			 $data['licence_number'] = null;

         }
         $data['account_type'];
         
        return self::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'account_type' => $data['account_type'],
            'role_category' => $role_category_name,
            'country_code' => $data['country_code'],
            'mobile_no' => $data['mobile_no'],
            'licence_number' => $data['licence_number'],
            'state' => $data['state'],
            'api_token' => str_random(60),
            'confirmation_code' => str_random(30),
            'otp' => $otp,
        ]);
    }
    
    
    /**
     * check token expired of not.
     *
     * @param  string  $token reqired
     *@param   int account_type reqired
     * @return \App\User
     */
    public function checkTokenExpir($token,$account_type){
         
         return $result = DB::table('password_resets')->select('email')->where('token','=',$token)->where('account_type','=',$account_type)->where('created_at','>',Carbon::now()->subHours(24))->get();
        }
         
    public function saveNewPassword($password,$email,$account_type){

           $data['password'] = $password;
           $result = null;;
           if($account_type){
                $result = self::where('email','=',$email)->where('account_type','=',$account_type)->update($data);
                
                if($result){
                    DB::table('password_resets')->where('email','=',$email)->delete();
                }
           }
            return $result;
           

    }

    /** 
    *this function is use for account verified of not 
    *@param email @email required
    *@param integer $account_type
    *
    *@return array
    */
    public function checkConfirmStatus($email,$account_type){

       return $result =  self::select('confirm_sataus')->where('email','=',$email)->where('account_type','=',$account_type)->where('confirm_status','=',1)->count();
    }

    /** 
    *this function is use for get all investors
    *
    *@return array
    */

    public function getAllInvestors(){

        return $result =  self::select('users.*','roles.name as account_type_name')->join('roles','users.account_type','=','roles.id')->where('role_category','=','investor')->where('account_type','>',1)->orderBy('id','desc')->get();

    }
    
     /** 
    *this function is use for get all investors
    *
    *@return array
    */

    public function getAllValuers(){

        return $result =  self::select('users.*','roles.name as account_type_name')->join('roles','users.account_type','=','roles.id')->where('role_category','=','valuer')->orderBy('id','desc')->get();

    }
}
