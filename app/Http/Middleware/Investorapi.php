<?php

namespace App\Http\Middleware;

use Closure;

class Investorapi
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
		
		if (\Auth::guard('api')->user()->role_category == 'investor')
        {
            return $next($request);
        }

         return response()->json(['status' => false, 'error_message' => \Lang::get('error_code.1005')]);
    }
}
