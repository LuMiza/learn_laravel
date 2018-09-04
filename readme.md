# 学习laravel

 ###  控制器创建
  * php artisan make:controller Home/InitController --plain
 `说明：php artisan make:controller 目录/目录.../控制器名字+Controller`  
 
  * 如果没有加`--plain` 那么创建控制器的时候会默认创建几个成员方法【RestFul资源控制器的方法】，加了`--palin`就是一个空的控制器
  
  * [个人总结]    关于路由的别名 可以按照如下规则命名  比如执行控制器`OrdersController`的index方法在`Controllers\Home\Goods\OrdersController`那么别名可以如此命名`Home.Goods.Orders.index`,如此规定方便理解与避免重名
  
### 中间件
  * 多个中间件的使用  `'middleware' => ['home.init', 'home.user'],`
  * laravel5.1中没有中间组的概念
  * [个人总结] 关于路由中间件的key命名  比如`InitMiddleware`是在`Middleware\Home\InitMiddleware`;这一这么命名：`Home.Init`  即`目录名.目录名...中间件名`这样便于理解与防止重名
  
### 请求
   * 【PSR-7 请求】在控制器或路由就可以获取http的请求信息  即$_SERVER $_COOKIE  $_SESSION  $_GET $_POST  变量的信息 ,等http请求的全部信息
   
   * laravel的闪存在首次请求时候保存到session中，第二次请求时候使用，第三次请求前被清，同时重新缓存，【主要用于第一次表单提交失败后   重新跳转表单中的数据不需要重新填写   提高用户体验】
   
   
   
  
  
 
  
  
  
  
  
  
  
  
  
 
 
 
 
