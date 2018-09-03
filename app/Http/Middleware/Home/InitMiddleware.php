<?php

namespace App\Http\Middleware\Home;

use Closure;

class InitMiddleware
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
        $this->access($request);
        return $next($request);
    }

    /**
     * @param $request  \Illuminate\Http\Request
     */
    protected function access($request)
    {
        echo 'home init middleware ' ,$request->fullUrl(),'<br/>';
        echo 'Home init MiddleWare' ,'<br/><br/><br/>';
    }
}
