<?php
/**
 * 设置前台的路由规则
 */

Route::get('/', ['uses' => 'Home\IndexController@index']);

Route::get('/user/add',  'Home\IndexController@ras')->name('uadd');
/**
 * 路由别名作用  主要是为了【route('uadd')】可以更方便的为特定路由生成 URL 或进行重定向;
 */




