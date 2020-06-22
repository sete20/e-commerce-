<?php

namespace App\Http\Middleware;

use Closure;

class lang
{

    public function handle($request, Closure $next)
    {        if (session()->has('lang')) {
           App()->setLocale(session('lang'));
    }else {
        App()->setLocale('ar');
    }
        return $next($request);
    }
}
