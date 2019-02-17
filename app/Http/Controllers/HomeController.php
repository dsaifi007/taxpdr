<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::check()) {
              if(\Auth::user()->account_type == 3){
                  
                  return \Redirect::route('valuer-dashboard');
                  
              }else{
                return \Redirect::route('investor-dashboard');
              }
        }else{
          return view('welcome');
        }
        
    }
}
