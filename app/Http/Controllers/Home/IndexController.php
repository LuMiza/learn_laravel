<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __construct()
    {
        $this->middleware('home.user', ['only' => [
            'show',
        ]]);
    }

    public function index()
    {
        return view('Home/Index/index');
    }

    public function show()
    {
        echo 'this action  ', route('home#Home.Index.show', ['id' => 11]),'<br/>';//获取路由地址：http://www.laravel.cn/Index/show?id=11
        return 'this is route as name';
    }

}
