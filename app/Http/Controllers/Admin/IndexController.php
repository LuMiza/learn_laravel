<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return view('Admin/Index/index');
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
