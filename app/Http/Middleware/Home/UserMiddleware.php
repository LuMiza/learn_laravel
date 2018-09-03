<?php

namespace App\Http\Middleware\Home;

use Closure;

class UserMiddleware
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
        echo 'home user MiddleWare' ,'<br/><br/><br/>';
        return $next($request);
    }
}
