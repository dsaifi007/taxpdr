<?php

namespace App\Http\Middleware;

use Closure;

class Valuerapi
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
        if (\Auth::guard('api')->user()->role_category == 'valuer' )
        {
            return $next($request);
        }

         return response()->json(['status' => false, 'error_message' => \Lang::get('error_code.1005')]);
    }
}
