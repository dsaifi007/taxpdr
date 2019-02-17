<?php

namespace App\Http\Controllers\Valuer;

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
            
            $user_id = \Auth::user()->id; 
            $sentrequest = new SentRequest;
            $all_accepted_requests = $sentrequest->getAcceptedJobs($user_id);
            return view('valuer.show_accepted_requests')->with(compact('all_accepted_requests'));
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
            
            $user_id = \Auth::user()->id; 
            $sentrequest = new SentRequest;
            $all_accepted_requests = $sentrequest->getJobHistories($user_id);
            return view('valuer.job_history')->with(compact('all_accepted_requests'));
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
            
            $user_id = \Auth::user()->id; 
            $sentrequest = new SentRequest;
            $all_new_requests = $sentrequest->getNewRequests($user_id);

            return view('valuer.new_request')->with(compact('all_new_requests'));
    }

    /**
     * update reject job status 
     *
     * @param array request
     * 
     * @return view
     */
    public function rejectJob(Request $request){
            
            $user_id = \Auth::user()->id; 
            $rejectjob_model = new RejectJob;
            $rejectjob_model->user_id = $user_id;
            $rejectjob_model->sent_request_id = $request->id;
            if($rejectjob_model->save()){
                 $sentrequest = new SentRequest;
                 $all_new_requests = $sentrequest->getNewRequests($user_id);
                return responseSuccessData($status=true,$message='no_sent_request',count($all_new_requests),['getallnewjobs'=>$all_new_requests]);

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
    public function acceptJob($id){
            
            $user_id = \Auth::user()->id; 
            $sentrequest = SentRequest::find($id);
            if(count($sentrequest) > 0){

                    if($sentrequest->request_status == 1){
                        $sentrequest->valuer_id = $user_id;
                        $sentrequest->request_status = 2;
                        $sentrequest->account_type = \Auth::user()->account_type;
                        $sentrequest->save();
                        $sentrequest = new SentRequest;
                        $all_new_requests = $sentrequest->getNewRequests($user_id);
                         return Redirect::route('valuer-dashboard')->with('success',Lang::get('messages.job_accepted'));
                        //return responseSuccessData($status=true,$message='no_sent_request',count($all_new_requests),['getallnewjobs'=>$all_new_requests]);
                    }else{
                        return Redirect::back()->with('error_msg',Lang::get('error_code.1035'));
                         //return $response = responseData($error_code=1035,$status=false);
                    }
                    
            }else{
                  
              return Redirect::back()->with('error_msg',Lang::get('error_code.1003'));
            }     
    }

    /**
    *@ this function for show update status form  
    *@param integer id required
    *
    *return json
    */   

    public function showEditStatus(Request $request){
           
            $id = $request->id;
            $user_id = \Auth::user()->id;
            $sentrequest = SentRequest::find($id);
            if(count($sentrequest) > 0){

                $result['status'] = true;
                $result['html'] = view('valuer.status_update_popup')->with(compact('sentrequest'))->render();
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
            
            $user_id = \Auth::user()->id;
            $id = $request->job_id;
            $new_status = $request->new_status; 
            $sentrequest = SentRequest::find($id);
            if(count($sentrequest) > 0){
                    if($sentrequest->valuer_id == $user_id){
                        $sentrequest->request_status = $new_status;
                        $sentrequest->save();
                         return Redirect::back()->with('success',Lang::get('messages.status_updated'));
                    }else{
                         
                         return Redirect::back()->with('error_msg',Lang::get('error_code.1003'));

                    }    
            }else{
                  
              return Redirect::back()->with('error_msg',Lang::get('error_code.1003'));
            }     
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
                    $user_id = \Auth::user()->id;
                    $job_id = $request->job_id;
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
                        $result['file_name'] =$name;
                        $result['status'] = true;
                        return response()->json($result);
                    }else{
                        $result['status'] = false;
                        $result['message'] = Lang::get('error_code.1003');
                        return response()->json($result);
                    }
                   

                }catch (Illuminate\Filesystem\FileNotFoundException $e) 
                 {
                  $result['status'] = false;
                  $result['message'] = Lang::get('error_code.1003');
                  return response()->json($result);
                 }

            }else{
                
                  $result['status'] = false;
                  $result['message'] = Lang::get('error_code.1003');
                  return response()->json($result);
            } 

    }





}
