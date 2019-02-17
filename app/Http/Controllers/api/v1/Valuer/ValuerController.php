<?php

namespace App\Http\Controllers\api\v1\Valuer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Properties;
use App\Models\SentRequest;
use App\Models\RejectJob;
use Illuminate\Support\Facades\Redirect;
use Lang;
use App\Traits\SendEmailTrait;
use Carbon\Carbon as Corbon;
use App\User;
class ValuerController extends Controller
{
     use SendEmailTrait;
     /**
     *
     * show valuer accepted all requests
     *
     * @param
     * 
     * @return view
     */
    public function dashboard(Request $request){
            
            $user_id =  \Auth::guard('api')->user()->id;
            $sentrequest = new SentRequest;
            $all_accepted_requests = $sentrequest->getAcceptedJobs($user_id);
             
            if(count($all_accepted_requests) > 0){

                return responseSuccessData($status=true,$message='data_found',count($all_accepted_requests),['all_accepted_requests'=>$all_accepted_requests]);
             }else{
                return responseSuccessData($status=true,$message='no_accepted_job',count($all_accepted_requests),['all_accepted_requests'=>$all_accepted_requests]);
                    
            }

              return responseData($error_code=1003,$status=false);
    }
    
    /**
     *
     * show valuer job history 
     *
     * @param
     * 
     * @return view
     */
    public function jobHistory(Request $request){
            
            $user_id =  \Auth::guard('api')->user()->id;
            $sentrequest = new SentRequest;
            $all_accepted_requests = $sentrequest->getJobHistories($user_id);
            if(count($all_accepted_requests) > 0){

                return responseSuccessData($status=true,$message='data_found',count($all_accepted_requests),['all_accepted_requests'=>$all_accepted_requests]);
             }else{
                return responseSuccessData($status=true,$message='no_job_history',count($all_accepted_requests),['all_accepted_requests'=>$all_accepted_requests]);
                    
            }

              return responseData($error_code=1003,$status=false);

    }

    /**
     *
     * show new requests
     *
     * @param
     * 
     * @return view
     */
    public function newRequest(Request $request){
            
            $user_id =  \Auth::guard('api')->user()->id;
            $sentrequest = new SentRequest;
            $all_new_requests = $sentrequest->getNewRequests($user_id);

            if(count($all_new_requests) > 0){

                return responseSuccessData($status=true,$message='data_found',count($all_new_requests),['all_new_requests'=>$all_new_requests]);
             }else{
                return responseSuccessData($status=true,$message='no_new_jobs',count($all_new_requests),['all_new_requests'=>$all_new_requests]);
                    
            }

              return responseData($error_code=1003,$status=false);
    }

    /**
     * update reject job status 
     *
     * @param array request
     * 
     * @return view
     */
    public function rejectJob(Request $request){
            
            $user_id =  \Auth::guard('api')->user()->id; 
            $rejectjob_model = new RejectJob;
            $rejectjob_model->user_id = $user_id;
            $rejectjob_model->sent_request_id = $request->id;
            if($rejectjob_model->save()){
                 //$sentrequest = new SentRequest;
                 //$all_new_requests = $sentrequest->getNewRequests($user_id);
                return responseSuccessData($status=true,$message='rejected',count($rejectjob_model),['rejectjob'=>$rejectjob_model]);

            }else{
                  
                   return $response = responseData($error_code=1003,$status=false);
            } 
    }

     /**
     * accept new jobs 
     *
     * @param array request
     * 
     * @return view
     */
    public function acceptJob(Request $request){
            
            $user_id =  \Auth::guard('api')->user()->id; 
            $id = $request->id;
            $sentrequest = SentRequest::find($id);
            if(count($sentrequest) > 0){

                    if($sentrequest->request_status == 1){
                        $sentrequest->valuer_id = $user_id;
                        $sentrequest->request_status = 2;
                        $sentrequest->account_type = \Auth::guard('api')->user()->account_type;
                        $sentrequest->save();
                        return responseSuccessData($status=true,$message='job_accepted',count($sentrequest),['acceptjob'=>$sentrequest]);
                    }else{
                         return $response = responseData($error_code=1035,$status=false);
                    }
                    
            }else{
                  return $response = responseData($error_code=1003,$status=false);
            
            }     
    }

    /**
    * this function for show update status form  
    *@param integer id required
    *
    *@return json
    */
       

    public function showEditStatus(Request $request){
           
            $id = $request->id;
            $user_id =  \Auth::guard('api')->user()->id;
            $sentrequest = SentRequest::find($id);
            if(count($sentrequest) > 0){

                $result['status'] = true;
                $result['sentrequest'] = $sentrequest;
                return response()->json($result);
            }
            else{
                  $result['status'] = false;
                  $result['message'] = Lang::get('error_code.1003');
                  return response()->json($result);

            }

    }


     /**
     * accept new jobs 
     *
     * @param array request
     * 
     * @return view
     */
    public function updateJobStatus(Request $request){
            
            $user_id =  \Auth::guard('api')->user()->id;
            $id = $request->id;
            $new_status = $request->new_status; 
            $sentrequest = SentRequest::find($id);
            if(count($sentrequest) > 0){
                    if($sentrequest->valuer_id == $user_id){
                        $sentrequest->request_status = $new_status;
                        $sentrequest->save(); 
                    return responseSuccessData($status=true,$message='status_updated',count($sentrequest),['sentrequest'=>$sentrequest]);
                    }else{
                         return $response = responseData($error_code=1035,$status=false);
                    } 
            }
            return $response = responseData($error_code=1003,$status=false);
    }


/**
*this function is used to upload report of job
*@param array request $request
*
*@return json
*/
 public function uploadReport(Request $request){
 
        if ($request->hasFile('file')) 
            {           
                try 
                {   
                    $user_id =  \Auth::guard('api')->user()->id;
                    $job_id = $request->id;
                    $sentrequest = SentRequest::find($job_id);
                    $report_owner_id = $sentrequest->user_id;
                    $report_owner_data = User::find($report_owner_id);
                    $dir = storage_path().config('app.report_upload_path');
                    $file = $request->file('file');
                    $name = 'report_generated_'.time().'.'.$file->getClientOriginalExtension();
                    if (!file_exists($dir)) {
                          mkdir($dir, 0777, true);
                    }
                    if($request->file('file')->move($dir, $name)){
                        $sentrequest->report_name = $name;
                        $sentrequest->request_status = 5;
                        $sentrequest->save();
                        $responsed_data = $this->commonEmailSender($report_owner_data->email,$subject="Your TaxPDR report is ready",$template_name="report_ready",$site_link=null,$name=$report_owner_data->name,$data1=null);
                        return responseSuccessData($status=true,$message='status_updated',count($name),['file_name'=>$name]);
                    }else{
                        return $response = responseData($error_code=1003,$status=false);
                    }
                   

                }catch (Illuminate\Filesystem\FileNotFoundException $e) 
                 {
                  return $response = responseData($error_code=1003,$status=false);
                 }

            }else{
                
                  return $response = responseData($error_code=1003,$status=false);
            } 

    }

}
