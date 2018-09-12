<?php

/**
 * 让其他controller继承InitController会出现一个问题
 * 在使用php artisan route:list 命令时 不会列出路由   而是列出如下代码exit中的内容
 * 因此登录是否失效的验证使用中间件
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class InitController extends Controller
{
    /**
     * 对登录是否失效进行处理
     * InitController constructor.
     */
    public function __construct(Request $request)
    {
        /**
         * 判断是否登录
         */
        if(!session()->has('admin_id') || !preg_match('/^[1-9]{1}\d*$/',session('admin_id')) ){
//            header('Location: '.route('admin::Admin.Login.getIndex'));
//            exit();
            exit('<script language="javascript">top.location.href="'.route('admin::Admin.Login.getIndex').'"</script>');
        }
        //判断登录是否失效
        if( !session('last_access') || (time()-session('last_access'))>config('webs.admin.config.session_expire')){
            //清空所有session信息
            session()->flush();
//            header('Location: '.route('admin::Admin.Login.getIndex'));
//            exit();
            exit('<script language="javascript">top.location.href="'.route('admin::Admin.Login.getIndex').'"</script>');
        }
    }
}
