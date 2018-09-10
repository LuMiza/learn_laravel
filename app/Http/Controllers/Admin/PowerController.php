<?php

namespace App\Http\Controllers\Admin;

use App\Common\Help\VerifyAction;
use App\Models\Admin\Admin;
use App\Models\Admin\Privilege;
use App\Models\Admin\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PowerController extends Controller
{
    /**
     * 管理员列表
     * @param Request $request
     * @param $p 分页页码
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request, $p=null)
    {
        if ($request->isMethod('post') && $request->isXmlHttpRequest()) {
            $page = ($p && preg_match('/^[1-9]{1}\d*$/',$p))? $p: 1;
            $pageSize = 10;
            $adminModel = new Admin();
            $list = $adminModel->getList($page,$pageSize);
            $assign_data = [
                'page_total' => ceil($adminModel->count()/$pageSize),
                'admin_list' => $list,
            ];
            return view('Admin.Power.admin.adminListAjax', $assign_data);
            exit();
        }
        return view('Admin.Power.admin.admin-list');
    }

    /**
     * 添加管理员
     */
    public function addAdmin(Request $request)
    {
        if ($request->isMethod('post') && $request->isXmlHttpRequest()) {
            $adminModel = new Admin();
            $result = $adminModel->addOrEditAdmin($request->input(), false);
            return response()->json($result);
            exit();
        }
        $roleModel = new Role();
        $list = $roleModel->select('role_id','role_name')->orderBy('role_add_time','desc')->where('role_is_delete','<>',1)->get();
        return view('Admin.Power.admin.admin-add', ['role_list' => $list->toArray()]);
    }

    /**
     * 修改管理员信息
     * @param Request $request
     * @param null $id
     */
    public function editAdmin(Request $request, $id=null)
    {
        if ($request->isMethod('post') && $request->isXmlHttpRequest()) {
            $adminModel = new Admin();
            $result = $adminModel->addOrEditAdmin($request->input(),true);
            return response()->json($result);
            exit();
        }
        $list = Admin::find($id);
        $assign_data = [
            'admin_list' => array_merge($list->toArray(),$list->adminRole->toArray()),
            'role_list'  => Role::select('role_id', 'role_name')
                                ->orderBy('role_add_time','desc')
                                ->where('role_is_delete','<>','1')
                                ->get()
                                ->toArray(),
        ];
        return view('Admin.Power.admin.admin-edit', $assign_data);
    }

    /**
     * 禁用管理员
     * @param Request $request
     * @param null $id
     */
    public function disAdmin(Request $request, $id=null)
    {
        if ($request->isMethod('post') && $request->isXmlHttpRequest()) {
            $post = $request->input();
            if (!VerifyAction::isId($id)) {
                return response()->json(['msg'=>'非法操作', 'code'=>0]);
            }
            $disable = trim($post['disabled']) ? 0 : 1;
            $msgTip = trim($post['disabled']) ? '启用' : '禁用';
            $result = Admin::where('a_id', $id)->update(['a_is_disabled'=>$disable]);
            if( $result === false ){
                return response()->json( array('msg'=>$msgTip.'失败','code'=>0) );
            }
            return response()->json( array('msg'=>$msgTip.'成功','code'=>1) );
            exit();
        }
        exit('非法操作');
    }

    /**
     * 获取权限列表
     * @param Request $request
     * @param null $p  分页 页码
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function rule(Request $request, $p=null)
    {
        if ($request->isMethod('post') && $request->isXmlHttpRequest()) {
            $page = ($p && preg_match('/^[1-9]{1}\d*$/',$p))? $p: 1;
            $pageSize = 10;
            $ruleModel = new Privilege();
            $list = $ruleModel->getList($page,$pageSize);

            $assign_data = [
                'page_total' => ceil($ruleModel->count()/$pageSize),
                'rule_list' => $list,
            ];
            return view('Admin.Power.rule.rule-List-Ajax', $assign_data);
            exit();
        }
        return view('Admin.Power.rule.rule-list');
    }

    public function addRule(Request $request)
    {
        if ($request->isMethod('post') && $request->isXmlHttpRequest()) {
            $ruleModel = new Privilege();
            $result = $ruleModel->addOrEditRule($request->input(), false);
            return response()->json($result);
            exit();
        }
        $assign_data = [
            'privilege_list' => Privilege::select(\DB::raw('concat(p_paths,",",p_id) as level_paths'),'p_id','p_name','p_paths')->orderBy('level_paths')->where('p_is_delete', 0)->get()->toArray(),
        ];
        foreach ($assign_data['privilege_list'] as $key => &$val) {
            $val['level'] = count(explode(',',$val['level_paths']));
        }
        return view('Admin.Power.rule.rule-add', $assign_data);
    }
}
