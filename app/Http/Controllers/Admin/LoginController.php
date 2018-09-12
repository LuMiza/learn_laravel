<?php

namespace App\Http\Controllers\Admin;

use App\Common\Help\VerifyAction;
use App\Models\Admin\Admin;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * 登录页面展示
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(Request $request)
    {
        return view('Admin/Login/index/login-index');
    }

    /**
     * 登录处理
     * @param Request $request
     */
    public function postIndex(Request $request){
        if ($request->isMethod('post') && $request->isXmlHttpRequest()) {
            $post = $request->input();
            session(['last_access'=>time()]);
            if( !isset($post["username"]) || !VerifyAction::isUserName(trim($post['username']),2,16,'EN') ){
                return response()->json(array('msg'=>'用户名应为字母、数字或_的组合', 'code'=>0));
            }
            if( !isset($post["password"]) || !VerifyAction::isNumPWD(trim($post["password"])) ){
                return response()->json(array('msg'=>'密码应为六个数字', 'code'=>0));
            }
            $result = Admin::join('admin_role', 'admin_role.ar_aid', '=', 'admin.a_id')
                ->where('a_is_disabled', 0)
                ->where('a_username', trim($post["username"]))
                ->first();
            if( !$result ){
                return response()->json(array('msg'=>'不存在【'.trim($post["username"]).'】用户','code'=>0));
            }
            $result = $result->toArray();
            if( $result['a_password'] != trim($post["password"]) ){
                return response()->json(array('msg'=>'密码输入错误','code'=>0));
            }
            unset($result['a_password']);
            session(['admin_id'=>$result['a_id']]);
            session(['admin_info'=>$result]);
            return response()->json(['msg'=>'登陆成功，正在跳转中......','code'=>1,'url'=>route('admin::Admin.Index.index')]);
            exit();
        }
        abort(503);
    }

    /**
     * 退出登录
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getLogout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('admin::Admin.Login.getIndex');
    }


}
