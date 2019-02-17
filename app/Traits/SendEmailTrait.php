<?php 

namespace App\Traits;
use DB;
use App\User;
use Carbon\Carbon as Carbon;

/**
* this is trail to send email to all type of users
* for api of web use 
*/
trait SendEmailTrait {

/**
*Common function to use send email to call 
*@param $email email type resiver email required
*@param $subject string email subject required
*@param $template_name string required
*@param site_link url type optional
*
* @return true, false; 
*/
   function commonEmailSender($email,$subject,$template_name,$site_link=null,$name=null,$data1=null){

   	    $senderEmail = config('app.sender_email');
    	$senderName = config('app.sender_name');
        $base_url = config('app.url');
		$data = ['subject'=>$subject,'email'=>$email,'senderEmail'=>$senderEmail,'senderName'=>$senderName,'site_link'=>$site_link,'name'=>$name,'base_url'=>$base_url,$data1];
        print_r($base_url);die;
	    return $response = \Mail::send('email_template.'.$template_name, ['subject'=>$subject,'senderName'=>$senderName,'site_link'=>$site_link,'name'=>$name,'data1'=>$data1,'base_url'=>$base_url], function ($message) use ($data) {
                    $message->subject($data['subject']);
                    $message->to($data['email']);
					$message->from($data['senderEmail'],$data['senderName']);
                });
	}
    
/**
*forget password email sender use send email  
*@param $email email type resiver email required
*@param $account_type integer required
* @return array; 
*/  
public function forgotPasswordEmail($email,$account_type){

    if($account_type!='' && $email!=''){

        return $this->sendemailforgotPassword($email,$account_type);

    }else{
          
             return 'error';

    }
	   
}

 

Protected function sendemailforgotPassword($email,$account_type){

     $valid_user =  User::where('email',$email)->where('account_type','=',$account_type)->get();
    if(count($valid_user) > 0){
        $name = $valid_user[0]->name;
        $check_already_request = Db::table('password_resets')->select('email')->where('email','=',$email)->where('account_type','=',$account_type)->count();
        if( $check_already_request > 0){
            $token = str_random(60);
            DB::table('password_resets')->where('email','=',$email)->where('account_type','=',$account_type)->update(['token' => $token , 'created_at' => Carbon::now()]);

        }else{

            $token = str_random(60);
                    DB::table('password_resets')->insert([  ['email' => $email, 'token' => $token,'account_type'=>$account_type,'created_at' => Carbon::now()]]);
         }
                
        $reset_link = $account_type.'-'.$token;
        $reset_link = base64_encode($reset_link);
        if($account_type == 1){
            $full_link = config('app.url').'/admin/password/reset/'.$reset_link;
        }else{
            $full_link = config('app.url').'/password/reset/'.$reset_link;
        }
       
        // call comman email method to send email         
        $this->commonEmailSender($email,$subject='TaxPDR | Forgot Password Email',$template_name='forgotpasswordemail',$full_link,$name);
               return $response = ['status'=>'email_sent'];
            }
            else{

                return $response = ['status'=>'invalid_email'];
            }
    }

}