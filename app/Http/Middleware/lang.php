<?php

namespace App\Http\Middleware;

use Closure;

class lang
{

    public function handle($request, Closure $next){

           App()->setLocale(lang());
 
  
        return $next($request);
    }
}
