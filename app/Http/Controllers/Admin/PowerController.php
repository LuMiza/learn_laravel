<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Admin;
use App\Models\Admin\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

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
            $result = $adminModel->addAdmin($request->input());
            return response()->json($result);
            exit();
        }
        $roleModel = new Role();
        $list = $roleModel->select('role_id','role_name')->orderBy('role_add_time','desc')->where('role_is_delete','<>',1)->get();
        return view('Admin.Power.admin.admin-add', ['role_list' => $list->toArray()]);
    }
}
