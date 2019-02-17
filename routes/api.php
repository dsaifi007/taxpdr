<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('table', function () {
 
  return "pawan";
 
});


  

Route::group(['prefix' => 'v1','namespace' => 'api\v1'], function () {	 

       // for cors - but not a valid way to do it	 
		Route::options('{all}', function () {
			return response('ok', 200)
				->header('Access-Control-Allow-Credentials', 'true')
				->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
				->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With,X-PINGOTHER, X-File-Name, Cache-Control')
				->header('Access-Control-Allow-Origin', '*');
		})->where('all', '.*');


        //test route 
         Route::get('/test1', function () {
		    return 'hello';
		});
        
        //route for load all countries codes
        Route::get('/get-countries-code',  'CommonController@getAllCountriesCodes');
         //route for load all states
        Route::get('/get-all-states',  'CommonController@getAllStates');

         //route for load all account types
        Route::get('/get-all-account-types',  'CommonController@getAllAccounttypes');

         //route for load all property types
        Route::get('/get-all-property-types',  'CommonController@getAllPropertyTypes');

        //route for load all required data in single api
        Route::get('/get-all-required-data',  'CommonController@getAllRequiredDataSingleApi');

        //route for load contact us details
        Route::get('/contact-us',  'CommonController@getContactUs');
         //route for load contact us details
        Route::get('/terms-conditions',  'CommonController@getTermsConditions');
         //route for load contact us details
        Route::get('/about-us',  'CommonController@getAboutUs');

	    //route for register
        Route::post('/register',  'RegistrationController@attemptRegister');

         //route for generate otp for mobile registration
        Route::post('/generate-otp',  'RegistrationController@generateVerifyEmailByOtp');

        //route for login user
        Route::post('/login',  'LoginController@attemptLogin');
        
         //route for send reset email
        Route::post('/send-forgot-link',  'ForgotPasswordController@postEmail');

          //route for verify account 
        Route::post('/verify-account',  'RegistrationController@verifyByOtp');
         //route for check app version allow or not
        Route::post('/check-version',  'CommonController@checkVersion');

        // investor api middileware routes start 
        Route::group(['middleware' => ['auths:api']], function(){
         
         //route for update password
         Route::post('/update-password',  'LoginController@updatePassword');
          //route for update profile
         Route::post('/update-profile',  'RegistrationController@updateProfile');

          //route for update profile
         Route::post('/auto-login',  'LoginController@autoLogin');

          //route show property details 
        Route::post('property-details',  'Investor\InvestorController@showPropertyDetails');

        });
       //route for update cart item by saved properties id  single
        Route::post('/calculate-depreciation',  'Investor\InvestorController@calculateDep');

       
	   // investor api middileware routes start 
		Route::group(['middleware' => ['auths:api','investorapi']], function(){

		 	   //route for register device on installation
         Route::post('/register-device',  'CommonController@registerDevice');
         
        //route for show user all saved properties 
         Route::post('/get-saved-properties',  'Investor\InvestorController@getSavedRequest');

          //route for show user all saved properties 
         Route::post('/get-my-reports',  'Investor\InvestorController@myReports');
         //route for submit a review on report 
         Route::post('/save-review',  'Investor\InvestorController@saveReview');
         //route for get saved property address by id  single
         Route::post('/get-saved-property',  'Investor\InvestorController@showEditSavedRequest');
          //route for delete saved proerty 
         Route::post('/delete-saved-request',  'Investor\InvestorController@deleteSavedAddress');
         //route update save address
         Route::post('/saved-property-update',  'Investor\InvestorController@updateSavedAddress');
		 
		 
        //route for show user all sent properties  request 
         Route::post('/get-sent-properties-request',  'Investor\InvestorController@getAllSentRequest');

          //route for show cart (newly added ) request
         Route::post('/get-cart-request',  'Investor\InvestorController@showNewlyAddedRequest');
         //route for delete cart (newly added ) request
         Route::post('/delete-cart-request',  'Investor\InvestorController@deleteRequest');
   
         //route for get cart property  by id  single
         Route::post('/get-cart-property',  'Investor\InvestorController@showEditCurrentRequest');

         //route for update cart item by id  single
        Route::post('/update-cart-property',  'Investor\InvestorController@saveRequest');

        //route for update cart item by saved properties id  single
        Route::post('/add-svaed-properties-to-cart',  'Investor\InvestorController@saveRequestBYSavedAddress');

         //route update view report status
       Route::post('update-report-view-status',  'Investor\InvestorController@updateReportViewStatus');

        //route for update cart item by saved properties id  single
        Route::post('/payout',  'Investor\PaymentController@payPayment');
        
         //route for pay for new request by saved card
       Route::post('/payout-saved-card',  'Investor\PaymentController@paySavedCardPayment');

        //route for show saved card 
        Route::post('/get-save-card',  'Investor\PaymentController@showSavedCard');
        //route for show saved card 
        Route::post('/save-saved-card',  'Investor\PaymentController@saveSavedCard');
       
        //route for show check out page
        Route::post('/update-setdefault-card',  'Investor\PaymentController@changeDefaultCard');

            //route for show  delete card 
        Route::post('/delete-card',  'Investor\PaymentController@deleteSavedCard'); 


		 });

         // valuer  api middileware routes start 
      Route::group(['middleware' => ['auths:api','valuerapi']], function(){

		 	   //route for register device on installation
      Route::post('/register-device',  'CommonController@registerDevice');

        //route for show valuer dashboard 
      Route::post('/valuer-dashboard',  'Valuer\ValuerController@dashboard');

      //route show all new requests
      Route::post('/new-request',  'Valuer\ValuerController@newRequest');
      //route for reject new request
      Route::post('/reject-new-job',  'Valuer\ValuerController@rejectJob');
      
      //route for accept job request
      Route::post('/accept-job',  'Valuer\ValuerController@acceptJob');

       //route for job history request
      Route::post('/job-history',  'Valuer\ValuerController@jobHistory');


      //route for show update status 
      Route::post('/show-job-status',  'Valuer\ValuerController@showEditStatus');

      //route for show update status 
      Route::post('/update-job-status',  'Valuer\ValuerController@updateJobStatus');

      Route::post('/upload-report','Valuer\ValuerController@uploadReport');


		 }); 		 
});
