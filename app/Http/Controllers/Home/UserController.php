<?php

namespace App\Http\Controllers\Home;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\Response;

class UserController extends InitController
{
    public function index()
    {
        echo  'this is home user index action';
        echo  route('home#Home.User.index');
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

    /**
     * http 响应
     */
    public function getResponse(Request $request)
    {
        /*return response('rumble')
            ->header('Content-Type', 'text/html')
            ->header('X-Header-One', 'Header Value')
            ->header('X-Header-Two', 'Header Value');*/
//        return response()->json(['name' => 'Abigail', 'state' => 'CA']);
//        return response()->json(['name' => 'Abigail', 'state' => 'CA'])->setCallback($request->input('callback'));
//        print_r($request->header('Content-Type'));
    }

    /**
     * jsonp 功能演示
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getJsonp()
    {
//        return view('Home/User/jsonp');
//        return back();
//        return redirect()->action('Home\UserController@index');
    }



}
