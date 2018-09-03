<?php

namespace App\Http\Middleware;

use App\Http\Requests\Request;
use Closure;

class HomeInitMiddleware
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
        echo $request->fullUrl(),'<br/>';
        echo 'this is Home MiddleWare' ,'<br/><br/><br/>';
    }
}
