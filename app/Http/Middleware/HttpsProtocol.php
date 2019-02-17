<?php

namespace App\Http\Middleware;

use Closure;

class HttpsProtocol
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
        
 if(@$_SERVER['HTTP_X_FORWARDED_PROTO']!="https"){
         
        header("Location:https://taxpdr.com");
        die();

        }


 if(@$_SERVER['HTTP_HOST']=="www.taxpdr.com"){
          header("Location:https://taxpdr.com");
         die();

        }
     
            return $next($request); 
    }
}
