<?php

require 'User.php';
require 'Db.php';
require 'Relation.php';
require 'Request.php';

use Plugins\Relation;

header('Content-Type: text/html; charset=UTF-8');


//声明方向
$className = '\Controller\User';
$methodName = 'getInfo';
$_GET['id'] = 'this is id  8888';//非类的参数如何注入到方法  此处只是一个简单的距离  无深入封装
$relation = new Relation($className, $methodName);
$method = $relation->invoke();





/*

//未封装前  实现类的注入
//创建反射对象
$class = new ReflectionClass($className);
$method = new ReflectionMethod($className, $methodName);

//获取当前方法的参数列表
$params = $method->getParameters();

$cnames = [];
//执行方法时的参数列表
$args = [];
print_r($params);
foreach ($params as $key => $value) {
    if (is_object($value->getClass())) {
        echo '<pre>';
        echo $value->getClass()->getName() ,'<br/>';
        echo   '<br/>';
        print_r($value->getClass());
        echo   '<br/>';
        $cnames[] = $value->getClass()->getName();
        $args[] = (new ReflectionClass($value->getClass()->getName())) -> newInstance();
    }
}

print_r($args);

//执行指定方法中的代码 index
//	$method->invokeArgs($class->newInstance(), $args);*/