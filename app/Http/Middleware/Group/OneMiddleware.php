<?php

namespace App\Http\Middleware\Group;

use Closure;

class OneMiddleware
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
        echo 'group middleware one <br/>';
        return $next($request);
    }
}
