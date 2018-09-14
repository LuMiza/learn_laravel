<?php

namespace App\Http\Middleware;

use Closure;

class AfterMiddleware
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
        $response = $next($request);
        // 运行动作
        echo 'after middleware <br/>';
        return $response;
    }

    /**
     *  HTTP 响应被发送到浏览器之后才运行
     * @param $request
     * @param $response
     */
    public function terminate($request, $response)
    {
        echo '<pre>';
//        print_r($request);
//        dd($response);
    }
}
