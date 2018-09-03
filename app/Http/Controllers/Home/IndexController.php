<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __construct()
    {
        /*$this->middleware('home.user', ['only' => [
            'show',
        ]]);*/
    }

    public function index()
    {
        return view('Home/Index/index');
    }

    public function show()
    {
//        echo $url = action('Home\IndexController@show') .'<br/>';
//        echo 'this action  ', route('home#Home.Index.show', ['id' => 11]),'<br/>';//获取路由地址：http://www.laravel.cn/Index/show?id=11
//        return 'this is route as name';

//        echo  \Route::currentRouteAction();//正在运行的控制器行为名称  App\Http\Controllers\Home\IndexController@show
//        echo \Route::currentRouteName();//当前路由的别名
//          var_dump(\Route::currentRouteNamed('home#Home.Index.show'));//判断当前路由的别名 与 给定的是否一样
    }

}
