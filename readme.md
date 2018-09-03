# 学习laravel

 ###  控制器创建
  * php artisan make:controller Home/InitController --plain
 `说明：php artisan make:controller 目录/目录.../控制器名字+Controller`  
 
  * 如果没有加`--plain` 那么创建控制器的时候会默认创建几个成员方法，加了`--palin`就是一个空的控制器
  
  * [个人总结]    关于路由的别名 可以按照如下规则命名  比如执行控制器`OrdersController`的index方法在`Home\Goods\OrdersController`那么别名可以如此命名`Home.Goods.Orders.index`,如此规定方便理解与避免重名
  
### 中间件
  * 多个中间件的使用  `'middleware' => ['home.init', 'home.user'],`
  * laravel5.1中没有中间组的概念
  
  
  
  
  
  
  
  
  
 
 
 
 
