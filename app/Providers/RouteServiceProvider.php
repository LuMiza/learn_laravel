<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $hostPrefix = substr($_SERVER['HTTP_HOST'],0, stripos($_SERVER['HTTP_HOST'], '.'));
        if (config('routes.'.$hostPrefix.'_host')) {
            $func = 'map'.ucwords($hostPrefix);
            $this->$func($router);
        } else {
            abort(404);
        }
    }

    /**
     * 后台路由规则定义
     * @param  $router
     */
    protected function mapAdmin($router)
    {
        $router->group(['namespace' => $this->namespace], function(){
            require app_path('Http/Routes/Admin/routes.php');
        });
    }

    /**
     * 前台路由规则定义
     * @param  $router
     */
    protected function mapWww($router)
    {
        $router->group(['namespace' => $this->namespace], function(){
            require app_path('Http/Routes/Home/routes.php');
        });
    }

}
