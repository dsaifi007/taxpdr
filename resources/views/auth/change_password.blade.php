<div class="create-request">

                                            <div class="main-body">
												<div class="alert-success"  id="success-msg" style="text-align: center;background-color: #ffffff;border-color:#ffffff;display:none;padding:0px !important;margin-bottom0px !important;">
           </div>
		   <div class="alert-danger parsley parsley-required"  id="error_message" style="text-align: center;background-color: #ffffff;border-color:#ffffff;display:none;padding:0px !important;margin-bottom0px;!important;">
           </div>
											
											
                                                <div class="body-inner">
												<form  method="POST" action="{{ route('update.password') }}" id="lform" autocomplete="off">
                        {{ csrf_field() }}
                                                    <div class="card bg-white">
                                                        <div class="card-content">
                                                            <div class="row">
                                                                <div class="col-md-4 col-sm-12 col-xs-12">
                                                                    <div class="form-group">
                                                                        <label>Enter Current Password</label>
                                                                        <input type="password" name="old_password" id="old_password" required class="form-contro">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-sm-12 col-xs-12">
                                                                    <div class="form-group">
                                                                        <label>Enter New Password</label>
                                                                        <input type="password" name="new_password" id="new_password" required class="form-contro">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 col-sm-12 col-xs-12">
                                                                    <div class="form-group">
                                                                        <label>Confirm New Password</label>
                                                                        <input type="password" name="confirm_password" id="confirm_password" required class="form-contro">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="tow-btn text-center">
                                                               <button type="submit" id="updatepassword" class="theme-btn btn-style-one">Save</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
												</form>
                                            </div>
                                        </div>