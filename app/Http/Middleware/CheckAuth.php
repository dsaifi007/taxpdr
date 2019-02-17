<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Closure;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ( \Auth::check() && \Auth::user()->account_type == 1 )
        {
            return Redirect::route('admin.dashboard');
        }else if ( \Auth::check() && \Auth::user()->role_category == 'valuer' )
        {
            return Redirect::route('valuer-dashboard');
        }elseif(\Auth::check() && \Auth::user()->role_category == 'investor'){
            return Redirect::route('investor-dashboard');
        }else{
              
              return $next($request);
        }
    }
}
