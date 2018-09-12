<?php

namespace App\Http\Middleware\Admin;

use App\Common\Help\Errors;
use Closure;

class AuthPermissionMiddleware
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
        $this->auth($request);
        return $next($request);
    }

    /**
     * @param $request
     */
    protected function auth($request)
    {
        //路由别名
        $request->route()->getName();
        //控制器方法
        $request->route()->getActionName();
        $result = \DB::table('role_privilege')
            ->join('privilege', 'privilege.p_id', '=', 'role_privilege.rp_pid')
            ->where('route_name', $request->route()->getName())
            ->where('action_name', $request->route()->getActionName())
            ->count();
        if (!$result) {
            Errors::throwMsg('');
            exit();
        }
    }
}
