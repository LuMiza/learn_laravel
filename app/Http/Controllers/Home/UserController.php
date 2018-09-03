<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends InitController
{
    public function index()
    {
        return 'this is home user index action';
    }

    /**
     * 响应对 GET /users/show/1 的请求
     */
    public function getShow()
    {
        echo \Route::currentRouteName();
    }

}
