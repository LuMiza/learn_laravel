<?php

namespace App\Http\Middleware\Admin;

use Closure;

class LoginMiddleware
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
        $this->verifyLogin($request);
        return $next($request);
    }

    /**
     * 对登录是否失效进行处理
     * @param $request
     */
    protected function verifyLogin($request)
    {
        if (!session()->has('admin_id') || !preg_match('/^[1-9]{1}\d*$/',session('admin_id')) ) {
//            header('Location: '.route('admin::Admin.Login.getIndex'));
//            exit();
            exit('<script language="javascript">top.location.href="'.route('admin::Admin.Login.getIndex').'"</script>');
        }
        //判断登录是否失效
        if ( !session('last_access') || (time()-session('last_access'))>config('webs.admin.config.session_expire')) {
            //清空所有session信息
            session()->flush();
//            header('Location: '.route('admin::Admin.Login.getIndex'));
//            exit();
            exit('<script language="javascript">top.location.href="'.route('admin::Admin.Login.getIndex').'"</script>');
        }
    }
}
