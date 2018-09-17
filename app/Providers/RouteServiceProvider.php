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
        $configs = config('routes.routes');
        //如下判断是为了防止artisan命令失效
        if (isset($_SERVER['HTTP_HOST'])) {
            $hostPrefix = substr($_SERVER['HTTP_HOST'],0, stripos($_SERVER['HTTP_HOST'], '.'));
            if (isset($configs[$hostPrefix])) {
                $this->mapRoutes($router, $configs[$hostPrefix]);
            } else {
                abort(404);
            }
        }
        //artisan 命令情况下将载入所有站点的路由规则
        if (isset($_SERVER['PHP_SELF']) && $_SERVER['PHP_SELF']=='artisan') {
            $this->mapRoutes($router, $configs);
        }
    }

    /**
     * 载入对应站点的路由规则
     * @param $router
     * @param $web  配置的站点  在config/routes.php文件中
     */
    protected function mapRoutes($router, $web)
    {
        if (!is_array($web)) {
            $router->group(['namespace' => $this->namespace], function () use ($web){
                $route_path = app_path('Http/Routes/'. ucwords($web) .'/routes.php');
                if (file_exists($route_path)) {
                    require $route_path;
                } else {
                    abort(404);
                }
            });
        } else {
            $router->group(['namespace' => $this->namespace], function () use ($web){
                foreach ($web as $values) {
                    $route_path = app_path('Http/Routes/'. ucwords($values) .'/routes.php');
                    if (file_exists($route_path)) {
                        require $route_path;
                    }
                }
            });
        }
    }


}
