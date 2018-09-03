<?php

namespace App\Http\Middleware\Group;

use Closure;

class TwoMiddleware
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
        echo 'group middleware two<br/>';
        return $next($request);
    }
}
