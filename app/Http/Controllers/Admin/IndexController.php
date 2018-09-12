<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Privilege;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __construct()
    {
        //对登录是否失效进行处理
        $this->middleware('Admin.Login');
    }
    /**
     * 后台首页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $menu_list = Privilege::select(\DB::raw('concat(p_paths,",",p_id) as level_paths'),'privilege.*')
            ->where('p_is_delete',0)
            ->orderBy('level_paths', 'asc')
            ->get()
            ->toArray();
        $assign_data = [
            'menu_string' => \App\Common\Help\Privilege::menuTree($menu_list),
        ];
        return view('Admin/Index/index/index', $assign_data);
    }

    /**
     * 后台默认显示页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDesktop(Request $request)
    {
        return view('Admin/Index/index/desktop');
    }

    public function show(Request $request,$id=null)
    {
        $str =  'this is admin show<br/>' . route('admin::Admin.Index.index') .'<br/>' . url('/admin/show', ['id'=>88]);
        $str .=  '<br/>'. $id;
        $str .=  '<br/>'. route('home#Home.Index.index');
//        echo $request->root() ,'<br/>';//http://www.laravel.cn
//        echo $request->fullUrl() ,'<br/>';//全路径 http://www.laravel.cn/admin/show/110
//        echo csrf_token();
//        echo csrf_field();
        return $str ;

    }
}
