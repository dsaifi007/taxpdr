<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\VersionControl;
use App\Models\Device;
use App\Models\ContactUs;
use App\Models\ContactUsQuery;
use App\Models\StaticPage;
use Illuminate\Support\Facades\Redirect;
use Lang;
use Validator;
use stdClass;

class CommonController extends Controller
{
     /**
     *
     * show contact us
     *
     * @param
     * 
    * @return view
     */
    public function showContactUs(Request $request){
            
			$contactus = ContactUs::find(1);
            return view('contact_us')->with(compact('contactus'));
    }
	
	
	 /**
     *
     * show terms and conditions
     *
     * @param
     * 
    * @return view
     */
    public function showterms(Request $request){
		
            $staticpage = new StaticPage;
			$pagecontent =$staticpage->getStaticPageContentByID(1);
            return view('terms_conditions')->with(compact('pagecontent'));
    }
	
	 /**
     *
     * show about us
     *
     * @param
     * 
    * @return view
     */
    public function aboutUs(Request $request){
		
            $staticpage = new StaticPage;
			$pagecontent =$staticpage->getStaticPageContentByID(2);
            return view('about_us')->with(compact('pagecontent'));
    }

     /**
     *
     * show about us
     *
     * @param
     * 
    * @return view
     */
    public function policy(Request $request){
        
            $staticpage = new StaticPage;
            $pagecontent =$staticpage->getStaticPageContentByID(2);
            return view('privacy_policy')->with(compact('pagecontent'));
    }
	
	/**
     *
     * save contact us queries
     *
     * @param
     * 
    * @return view
     */
	
    public function saveQuery(Request $request){
            
			$contactusquery = new ContactUsQuery;
			$contactusquery->name = $request->name;
			$contactusquery->email = $request->email;
			$contactusquery->phone = $request->phone;
			$contactusquery->subject = $request->subject;
			$contactusquery->message = $request->message;
			$contactusquery->save();
            return Redirect::back()->with('message',Lang::get('messages.query_sent'));
    }
   
}
