<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface;

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

    /**
     * @param ServerRequestInterface $request PSR-7 请求
     */
    public function getHttp(ServerRequestInterface $request)
    {
        echo '<pre>';
//        print_r($request->getHeaders());
//        print_r($_SERVER);
//        print_r($request->getUploadedFiles());
        print_r($request->getServerParams());

    }

    /**
     * @param Request $request  laravel 的请求对象
     * @param ServerRequestInterface $httpRequest  PSR-7 请求
     */
    public function getRes(Request $request, ServerRequestInterface $httpRequest)
    {
        echo '<pre>';
//        print_r($httpRequest->getHeaders());
//        print_r($httpRequest->getCookieParams());
//        $httpRequest->withAttribute('u_test','rumble');
//        echo $httpRequest->getAttribute('u_test');
//        print_r( $request->session()->getId() );
        print_r($request->except());
    }
}
