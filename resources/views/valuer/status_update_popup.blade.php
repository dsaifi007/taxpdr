<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Job Status</h4>
            </div>
             <form id="editform" name="lform" method="POST" action="{{ route('valuer.update.job.status') }}" >
													{{ csrf_field() }}
            <div class="modal-body">

            	 @if($sentrequest->request_status == 1)
	            	<div class="checkbox">
	                     <label><input type="checkbox" name="current_status" checked="checked" value="" disabled> Request Received</label>
	                </div>
	                <div class="checkbox">
                     <label><input type="checkbox" required data-parsley-required-message="{!! trans('messages.update_status_required') !!}" name="new_status" value="2" id="checkstatusid">Assigned</label>
                    </div>
	             @endif 

	             @if($sentrequest->request_status == 2)
	            	<div class="checkbox">
	                     <label><input type="checkbox" name="current_status" checked="checked" value="" disabled>Assigned</label>
	                </div>
	                <div class="checkbox">
                     <label><input type="checkbox" required data-parsley-required-message="{!! trans('messages.update_status_required') !!}" name="new_status" value="3" id="checkstatusid"> Visit Scheduled</label>
                    </div>
	             @endif  

	              @if($sentrequest->request_status == 3)
	            	<div class="checkbox">
	                     <label><input type="checkbox" name="current_status" checked="checked" value="" disabled> Visit Scheduled</label>
	                </div>
	                <div class="checkbox">
                     <label><input type="checkbox" required data-parsley-required-message="{!! trans('messages.update_status_required') !!}" name="new_status" value="4" id="checkstatusid" > Visit Completed </label>
                    </div>
	             @endif

	             @if($sentrequest->request_status == 4)
	            	<div class="checkbox">
	                     <label><input type="checkbox" name="current_status" checked="checked" value="" disabled> Visit Completed</label>
	                </div>
	                <div class="checkbox">
                     <label><input type="checkbox" id="checkstatusid" required data-parsley-required-message="{!! trans('messages.update_status_required') !!}" name="new_status" value="5"> Report Generated</label>
                    </div>
	             @endif           
     
               
            </div>
            <div style="text-align: center;" class="modal-footer">
            	<input type="hidden" name="job_id" value="{{ $sentrequest->id }}" />
                <button type="submit" onclick= "return checkstatuschecked();"" class="theme-btn btn-style-one" >Update</button>
               
            </div>
        </form>