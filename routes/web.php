<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','HomeController@index')->name('home-new');

Route::get('/home','HomeController@index')->name('home-new2');
Route::get('/test-admin', function () {
    return view('admin/sign-in');
});

Route::get('/test', function () {
    return view('investor/review');
});
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Auth::routes();

//route for show contact us page
Route::get('/contact-us', 'CommonController@showContactUs')->name('contact-us');
//route for save contact us query
Route::post('/saveQuery', 'CommonController@saveQuery')->name('save.Query');

//route for show terms and conditions page
Route::get('/terms-conditions', 'CommonController@showterms')->name('showterms');
//route for show terms and conditions page
Route::get('/about-us', 'CommonController@aboutUs')->name('aboutus');

//route for show terms and conditions page
Route::get('/policy', 'CommonController@policy')->name('policy');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/verifyemail/{token}', 'Auth\RegisterController@verify')->name('verify');

//this route is to verify email and update email
Route::get('/update-email/{token}', 'Auth\RegisterController@updateVerifyEmail')->name('auth.update.verify.email');

Route::get('/common-page/{message}', 'Auth\RegisterController@success')->name('success');

//route for login user
Route::post('/attempt-login',  'Auth\LoginController@attemptLogin')->name('attemptlogin');

//reset password
Route::post('/rest-new-password',  'Auth\ResetPasswordController@resetPassword')->name('restnewpassword');

//route for send reset email
    Route::post('/send-forgot-link',  'Auth\ForgotPasswordController@postEmail')->name('sendforgotlink');

    //route for sho calculator
    Route::get('/depreciation-calculator',  'Investor\InvestorController@showCalculator')->name('show.calculator');
//check auth middleware
Route::group(['middleware'=>['checkauth']], function () {
     Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
      Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
  }) ;//end checkauth middleware


//common route for investor or valuer after login    
Route::group(['middleware'=>['auth','revalidatebackhistory']], function () {		

Route::get('/test-admin-manage', function () {
    return view('admin/manage-user');
});

// route for update profile
Route::get('/my-profile', 'Auth\RegisterController@myProfile')->name('myprofile');
Route::post('/update-profile', 'Auth\RegisterController@updateProfile')->name('update.profile');

 // route for update password
    Route::post('/update-password', 'Auth\LoginController@updatePassword')->name('update.password');

    // route for update password
    Route::get('/property-detail/{id}', 'Investor\InvestorController@showPropertyDetails')->name('show.property.details');

});
// investor after auth urls using auth middleware
Route::group(['prefix' => 'investor','middleware'=>['auth','investor','revalidatebackhistory']], function () {	
      
	  //test route createToken
	  //route for invester dashboard
      Route::get('/createToken',  'Investor\PaymentController@createToken')->name('investor-createToken');
	  
	   //route for sho calculator
      Route::get('/depreciation-calculator',  'Investor\InvestorController@showCalculator')->name('investot.show.calculator');
	
      //route for invester dashboard
      Route::get('/dashboard',  'Investor\InvestorController@dashboard')->name('investor-dashboard');

       //route for invester my reports
      Route::get('/my-report',  'Investor\InvestorController@myReports')->name('investor-reports');

      //route for show create request form
      Route::get('/create-request/{tab?}',  'Investor\InvestorController@showCreateRequest')->name('investor.createrequestform');
	  
	   //route for show create request form
      Route::get('/show-saved-request',  'Investor\InvestorController@showsavedRequest')->name('investor.show.saved.request');

      //route for show create request form
      Route::post('/save-request',  'Investor\InvestorController@saveRequest')->name('investor.saverequest');

       //route for show newly added  request
      Route::get('/newly-added-request',  'Investor\InvestorController@showNewlyAddedRequest')->name('investor.newly.added.request');
      //route for show newly added  request
      Route::get('/delete-current-request',  'Investor\InvestorController@deleteRequest')->name('investor.delete.current.request');
	  //route for show for show edit save address popup  
      Route::get('/edit-newly-request-show',  'Investor\InvestorController@showEditCurrentRequest')->name('investor.edit.newly.saved.request');
      //route for save request for saved address 
      Route::post('/saved-address-save-request',  'Investor\InvestorController@saveRequestBYSavedAddress')->name('investor.savedaddress.save.request');

      //route for show for show edit save address popup  
      Route::get('/saved-address-request-show',  'Investor\InvestorController@showEditSavedRequest')->name('investor.edit.saved.request');

      //route for show for show edit save address popup  
      Route::get('/re-fresh-saved-properties',  'Investor\InvestorController@refreshSavedProperties')->name('investor.refresh.saved.request');

      //route for show for show edit save address popup  
      Route::post('/saved-address-request-update',  'Investor\InvestorController@updateSavedAddress')->name('investor.updateSavedRequest');

      //route for delete saved  request
      Route::get('/delete-saved-request',  'Investor\InvestorController@deleteSavedAddress')->name('investor.delete.saved.request');
       
      //route for save review on report
      Route::post('saved-review',  'Investor\InvestorController@saveReview')->name('investor.saved.review');

       //route update view report status
      Route::get('update-report-view-status',  'Investor\InvestorController@updateReportViewStatus')->name('update.report.view.status');
    


      //route for show check out page
      Route::get('/checkout',  'Investor\PaymentController@checkout')->name('investor.checkout');
      //route for pay for new request
      Route::post('/payout',  'Investor\PaymentController@payPayment')->name('investor.pay.payment');
        	  
     
	   //route for pay for new request by saved card
      Route::post('/payout-saved-card',  'Investor\PaymentController@paySavedCardPayment')->name('investor.pay.savedcard.payment');
	  
	  // route for investor update password form
	  Route::get('/profile-setting', 'Auth\LoginController@showProfileSetting')->name('profile-setting');
		
		//route for show check out page
        Route::get('/saved-cards',  'Investor\PaymentController@showSavedCard')->name('saved.cards');
      //route for show check out page
        Route::get('/update-setdefault-card',  'Investor\PaymentController@changeDefaultCard')->name('update.setdefault.card');

		//route for show  delete card 
        Route::get('/delete-card',  'Investor\PaymentController@deleteSavedCard')->name('delete.card');
		//route for show check out page
        Route::get('/get-saved-cards',  'Investor\PaymentController@showSavedCard')->name('saved.cards');
		//route for show saved card 
        Route::post('/save-saved-card',  'Investor\PaymentController@saveSavedCard')->name('investor.saved.new.card');

          //route for show saved card 

         Route::get('/show-save-card',  'Investor\PaymentController@showSavedCardForm')->name('saved.new.card');

	   


});	


// valuer after auth urls using auth middleware
Route::group(['prefix' => 'valuer','middleware' => ['auth','valuer','revalidatebackhistory']], function () {	
      
      // route for valuer update password form
    Route::get('/change-password', 'Auth\LoginController@showValuerChabgePassword')->name('change.password');
      //route for show valuer dashboard 
      Route::get('/valuer-dashboard',  'Valuer\ValuerController@dashboard')->name('valuer-dashboard');

      //route show all new requests
      Route::get('/new-request',  'Valuer\ValuerController@newRequest')->name('valuer.new.request');
      //route for reject new request
      Route::get('/reject-new-job',  'Valuer\ValuerController@rejectJob')->name('valuer.reject.new.request');
      
      //route for accept job request
      Route::get('/accept-job/{id}',  'Valuer\ValuerController@acceptJob')->name('valuer.accept.job');

       //route for job history request
      Route::get('/job-history',  'Valuer\ValuerController@jobHistory')->name('valuer.job.history');


      //route for show update status 
      Route::get('/show-job-status',  'Valuer\ValuerController@showEditStatus')->name('valuer.show.job.status');

      //route for show update status 
      Route::post('/update-job-status',  'Valuer\ValuerController@updateJobStatus')->name('valuer.update.job.status');

      Route::post('/upload-report','Valuer\ValuerController@uploadReport')->name('valuer.upload.report');
      
});

//-------------Admin route start --------------------------------->\
//this route is used for admin login
Route::group(['middleware'=>['checkauth']], function () {
    Route::get('/admin-login','Admin\AdminController@showLogin')->name('admin.adminlogin');

    Route::get('admin/password/reset/{token}', 'Admin\AdminController@showResetForm');

     //this route is used for admin login
    Route::get('/admin/password-reset','Admin\AdminController@forgotPassword')->name('admin.forgotPassword');

    //route for send reset email
    Route::post('/admin-send-forgot-link',  'Admin\AdminController@postEmail')->name('admin.sendforgotlink');
 
  });//End checkauth middleware
    
//this route is used for admin login
Route::get('/admin-logout','Admin\AdminController@logout')->name('admin.logout');

//route for login Admin
Route::post('/admin-attempt-login',  'Admin\AdminController@attemptLogin')->name('admin.attemptlogin');
// Admin after auth urls using auth middleware
Route::group(['prefix' => 'Admin','middleware'=>['auth','admin','revalidatebackhistory']], function () {
   	    
       //route for show change password  
      Route::get('/chage-password',  'Admin\AdminController@showChangePassword')->name('admin.change.password');   
  
       //route for show content management  
      Route::get('/terms-conditions',  'Admin\AdminController@showTermsCondition')->name('admin.terms.conditions');   

      //route for update content management  
      Route::post('/update-content',  'Admin\AdminController@updateContent')->name('admin.update.content'); 

      //route for show manage investor  
      Route::get('/dashboard',  'Admin\AdminController@dashboard')->name('admin.dashboard');	
      //route for show  investor profile 
      Route::get('/investor-profile/{investor_id}',  'Admin\InvestorController@investorProfile')->name('admin.investor.profile');  

       //route for show valuer profile  
      Route::get('/valuer-profile/{valuer_id}',  'Admin\ValuerController@valuerProfile')->name('admin.valuer.profile');

      //route for show valuer dashboard 
      Route::get('/manage-valuers',  'Admin\AdminController@manageValuers')->name('admin.manage.valuers');

       //route for show assign requests 
      Route::get('/manage-request',  'Admin\AdminController@manageRequests')->name('admin.manage.requests');

      //route for show assign requests to valuer
      Route::get('/assign-to-valuer/{request_id}/{valuer_id}',  'Admin\AdminController@assignValuer')->name('admin.assign.valuer');

        //route for show pending requests 
      Route::get('/pending-requests',  'Admin\AdminController@managePendingRequests')->name('admin.pending.requests');

       //route for show completed requests 
      Route::get('/completed-requests',  'Admin\AdminController@manageCompletedRequests')->name('admin.completed.requests');

       //route for show all transaction 
      Route::get('/manage-transactions',  'Admin\AdminController@manageTransactions')->name('admin.manage.transactions');

       //route for show valuer status 
      Route::post('/update-investor-status',  'Admin\InvestorController@updateInvestorStatus')->name('admin.update.investor.status');  

});	

