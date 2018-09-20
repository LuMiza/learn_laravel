# 学习laravel
### 框架说明：
  laravel中采用了pipeline[管道设计模式]，其中middleware就是采用该设计模式；依赖注入和控制反转[laravel中的容器采用的就是这种方式];
  
#### 什么是控制反转（IoC）和依赖注入（DI）
* 控制反转(IoC) 就是说把创建对象的** 控制权 进行转移，以前创建对象的主动权和创建时机是由自己把控的，而现在这种权力转移到第三方，也就是 Laravel ** 中的容器。
* 依赖注入（DI）则是帮助容器实现在运行中动态的为对象提供提依赖的资源。

 ###  控制器创建
  * php artisan make:controller Home/InitController --plain
 `说明：php artisan make:controller 目录/目录.../控制器名字+Controller`  
 
  * 如果没有加`--plain` 那么创建控制器的时候会默认创建几个成员方法【RestFul资源控制器的方法】，加了`--palin`就是一个空的控制器
  
  * [个人总结]    关于路由的别名 可以按照如下规则命名  比如执行控制器`OrdersController`的index方法在`Controllers\Home\Goods\OrdersController`那么别名可以如此命名`Home.Goods.Orders.index`,如此规定方便理解与避免重名
  
### 中间件
  * 多个中间件的使用  `'middleware' => ['home.init', 'home.user'],`
  * laravel5.1中没有中间组的概念
  * [个人总结] 关于路由中间件的key命名  比如`InitMiddleware`是在`Middleware\Home\InitMiddleware`;这一这么命名：`Home.Init`  即`目录名.目录名...中间件名`这样便于理解与防止重名
  * 前置中间件 与 后置中间件
```php
    //前置中间件代码
    public function handle($request, Closure $next)
    {
        echo 'before middleware <br/>';
        return $next($request);
    }
    //后置中间件代码
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        // 运行动作
        echo 'after middleware <br/>';
        return $response;
    }
```
  
  
### 请求
   * 【PSR-7 请求】在控制器或路由就可以获取http的请求信息  即$_SERVER $_COOKIE  $_SESSION  $_GET $_POST  变量的信息 ,等http请求的全部信息
   
   * laravel的闪存在首次请求时候保存到session中，第二次请求时候使用，第三次请求前被清，同时重新缓存，【主要用于第一次表单提交失败后   重新跳转表单中的数据不需要重新填写   提高用户体验】
  
### 响应  
   * 【jsonp 演示】 json数据地址[服务器端]`http://www.tp5.com:8080/index.php/Index/Index?callback=showdata`  以下是该地址的处理代码
   
```php
            $data = [
                'name' => 'this is go to shopping',
                'img' => 'http://www.baidu.com',
                'price' => 88.99,
                'date' => '2018-09-05 18:00:00',
            ];
            //header("Access-Control-Allow-Origin:*");//jsonp 演示的时候 不要加这个
            header('Content-Type: application/json; charset=utf-8');
            header('yoke-content: this is my thinkphp 5');
            if ($this->request->param('callback')) {
                 echo $this->request->param('callback') ,'(' , json_encode($data) , ');';
            } else {
                echo json_encode($data);
            }
            //return json($data);
            exit;
```
* 客户端代码  地址：`http://www.laravel.cn/User/jsonp`
```javascript
  $('button').click(function(){
      $.ajax({
           url: "http://www.tp5.com:8080/index.php/Index/Index",
           type: "GET",
           dataType:'json',
           success: function (data) {
               console.info("调用success");
              console.log(data);
           }
      }); 
  });
```
* 以上客户端请求就会出现无法跨域获取json数据【报错】
`jsonp:1 Failed to load http://www.tp5.com:8080/index.php/Index/Index: No 'Access-Control-Allow-Origin' header is present on the requested resource. Origin 'http://www.laravel.cn' is therefore not allowed access.`

###### A
```html
<script src="http://www.tp5.com:8080/index.php/Index/Index?callback=showdata" type="text/javascript"></script>
```
*  如果使用以上方式获取  将会获取到   response结果：
```javascript
showdata({"name":"this is go to shopping","img":"http:\/\/www.baidu.com","price":88.99,"date":"2018-09-05 18:00:00"});
```

* 因此我们要在`A`处前定义如下方法，这样就可以获取跨域得json数据，这样获取跨域数据就可以解决，这就是jsonp
```html
<script>
    function showdata(result){
        console.log(result);
    }
</script>
```
*  如何通过jquery $.ajax获取跨域数据`[jsonp形式的ajax请求:并且通过get请求的方式传入参数,注意:跨域请求是只能是get请求不能使用post请求]`
```javascript
            $.ajax({
                 url: "http://www.tp5.com:8080/index.php/Index/Index",
                 type: "GET",
                 dataType: "jsonp",  //指定服务器返回的数据类型
                 jsonp: "callback",   //指定参数名称
                 jsonpCallback: "success",  //指定回调函数名称
                 success: function (data) {
                     console.info("调用success");
                     console.log(data);
                 }
            });
```

### php对象注入

* 用到的知识点为`ReflectionMethod`和`ReflectionClass`，代码示例在public目录下的注入，其中`zhuru`是简单的示例，`index.php`为将其封装后并且采用命名空间的方式的示例代码\

### 设置自定义函数和自定义类文件
```json
//在项目下的composer.json中添加信息
"autoload": {
        "classmap": [
            "database"
        ],
        "psr-4": {
            "App\\": "app/"
        },
        "files":[
            "app/Library/helper.php"
        ]
    },
```

* 用命令 `composer dump-auto`更新自动加载配置

### 路由补充

* laravel 如何获取全部路由数据 不要php artisan route:list
```php
    $routes = \Route::getRoutes();
    foreach($routes as $route) {
        echo $route->getPath() ,'<br/>';
        print_r($route->methods());
        echo '<pre>';
        print_r($route->getAction());
    }
    exit();
```
* 其实找到 php artisan route:list 这个命令的源码就行了。文件位置：`\vendor\laravel\framework\src\Illuminate\Foundation\Console\RouteListCommand.php` 源码里包含了你想要的信息
### trait说明

```php
//在laravel的Controller.php文件中出现这样的代码，在class内部use类，这是一种代码复用，php 语法为trait
abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
```
* 自 PHP 5.4.0 起，PHP 实现了一种代码复用的方法，称为 [trait](http://www.php.net/manual/zh/language.oop5.traits.php)
### 辅助函数调用

* config函数使用 取`config\webs\admin.php` 中的title `config('webs.admin.title')`

### 数据库

* sql语句记录
```php
    \Event::listen('illuminate.query', function($query){
        var_dump($query);
    });
```

* 由于laravel的查询构造器和thinkphp不一样，在构建 `可选查询条件` `【查询条件可能有，也可能没用】`的时候不能够将查询条件塞入一个数组，那么laravel的可选查询条件构造如何操作如下：
```php
    //以下代码在在model为Privilege.php文件中
    protected $table = 'privilege';//表名
    protected $primaryKey = 'p_id';//主键
    public  $timestamps = false;   
    
    
    //第一种操作【不行，将会取出所有数据】
    $this->where('p_name', 'like', '%管理员%');
    $this->where('p_name', 'like', '%管理员%');
    dd($this->get()->toArray());
    //以上查询sql为：select * from `privilege`
    
    
    //第二种操作 【将会依据条件取出符合的数据】
    $obj = \DB::table($this->table);//或  \DB::table('privilege')
    $obj->where('p_name', 'like', '%管理员%');
    $obj->where('p_id', 1);
    $result = $obj->get();
    dd($result);
    //以上查询sql为：select * from `privilege` where `p_name` like ? and `p_id` = ?
    
    //那么可选查询时候就可以这么操作了,对第二种代码进行改造
    if (isset($_POST['p_name'])) {
        $obj->where('p_name', 'like', '%'.$_POST['p_name'].'%');
    }
    if (isset($_POST['id'])) {
        $obj->where('p_id', $_POST['id']);
    }
```

###  配置二级域名 
####  方式一 [二开后的] [推荐]
* 第一步：在config目录下建立`routes.php`文件，内容如下
```php
    return [
        'routes' => [
            'admin' => 'admin',//后台
            'www' => 'home',//前台
        ],
    ];
```
* 第二步：在`app\Http`下建立`Routes`文件夹，比如`Admin.php(后台路由)` `Home.php（前台路由）` 
* 第三步：对文件`RouteServiceProvider.php`中的代码进行改写,代码如下
```php
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
                $route_path = app_path('Http/Routes/'. ucwords($web) .'.php');
                if (file_exists($route_path)) {
                    require $route_path;
                } else {
                    abort(404);
                }
            });
        } else {
            $router->group(['namespace' => $this->namespace], function () use ($web){
                foreach ($web as $values) {
                    $route_path = app_path('Http/Routes/'. ucwords($values) .'.php');
                    if (file_exists($route_path)) {
                        require $route_path;
                    }
                }
            });
        }
    }
```
* 第四步：服务器配置二级域名 比如：`admin.laravel.cn(后台)` `www.laravel.cn(前台)`
####   方式二 [laravel自带的] [不推荐]
* 子域名可以通过domain关键字来设置：
```php
    Route::group(['domain'=>'{service}.laravel.app'],function(){
        Route::get('/write/laravelacademy',function($service){
            return "Write FROM {$service}.laravel.app";
        });
        Route::get('/update/laravelacademy',function($service){
            return "Update FROM {$service}.laravel.app";
        });
        
        Route::get('/',function($service){
            return "Write FROM {$service}.laravel.cn";
        });
        //如果这样 比如配置的二级域名为 write.laravel.app ，这样访问是会报错的
    });
    //这样我们在浏览器中访问http://write.laravel.app:8000/write/laravelacademy，则输出
    
    //Write FROM write.laravel.app
    //访问http://update.laravel.app:8000/write/laravelacademy时，则输出：
    
    //Write FROM update.laravel.app
    //注意：要想让子域名解析生效，需要在hosts中绑定IP地址
    
    
```

### 事件与监听器

* 第一种：通过`EventServiceProvider.php`的属性`$listen`来注册事件与对应的监听器，如下代码：
```php
   protected $listen = [
        //事件
        'App\Events\Admin\SomeEvent' => [
            //SomeEvent 对应的监听器，可以SomeEvent可以对应多个监听器
            'App\Listeners\Admin\EventListener',
        ],
    ];
```
* 然后通过php artisan event:generate 命令来生成`EventServiceProvider.php`的属性`$listen`配置好的事件以及对应的监听器,关于SomeEvent事件的行为逻辑定义可以根据需求开发定义，然后在监听器EventListener中的handle方法中进行监听操作,最后我们触发事件，如下代码：
```php
//触发事件可以用助手函数event 或 Event::fire()来触发
event(new SomeEvent());//触发事件
Event::fire(new SomeEvent());//触发事件
```

* 第二种：手动注册事件，`EventServiceProvider.php`中的`boot`方法内`DispatcherContract $events`来注册事件，如下代码:
```php
$events->listen('log.notice', function ($ars) {
    header('Content-type:text/html;charset=utf-8;');
    print_r($ars);
    echo '<br/>这个是手动注册事件<br/>';
});
```
* 调用方式如下:
```php
event('log.notice',[444,5522]);//方式1
Event::fire('log.notice',[444,55556]);//方式2
```

### 功能开发
* FTP远程文件操作，类所在地址：`app/Common/Help/FTP.php`，配置信息`config/remote.php`,FTP远程文件上传[`upload`] 文件删除[`delete`] 文件下载[`download`]
```php
        $ftp = new FTP();
        //文件删除
        $result = $ftp->delete('goods_imgs/2018/09/20/20180920021013_1260.jpg');
        //文件下载
        $result = $ftp->download('goods_imgs/2018/09/20/20180920023234_7959.jpg',base_path('Aimage/'));
        //文件上传
        $result = $ftp->upload(base_path('Aimage/1.jpg'));
        //返回值为数组[msg=>提示消息, code=>0:出错；1:成功, path=>'文件路径'] 或者抛出异常  
```


### 额外知识插入：
* mongodb的默认端口是27017  那么要启用mongodb的web控制台的话，在启用mongod的服务时候 加一个参数 `--httpinterface`,然后在浏览器中输入ip地址+mongodb的默认端口号+1000 【http://192.168.80.137:28017/】
* 如何判断参数是否是匿名函数`$name instanceof Closure`
```php
    function test($name) {
        var_dump($name instanceof  Closure);
        //如果$name 是匿名函数  那么就为true，否则false
    }
```
* 字符串截取 `mb_strimwidth('本地化功能提供方便的方法来获取多语言的字符串',0,'10','','UTF-8')`，敢于助手函数，比如处理字符串或者数组的建议不采用，直接用php原生的













   
  
  
 
  
  
  
  
  
  
  
  
  
 
 
 
 
