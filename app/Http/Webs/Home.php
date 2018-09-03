<?php
/**
 * 设置前台的路由规则
 *
 * 将路由规则分组 方便对分组内的路由进行统计的一个规则限制  比如统一用一个中间件
 */

Route::group(['as' => 'Home#', 'prefix' => '', 'middleware' => 'home.init'],function(){

    Route::get('/', ['uses' => 'Home\IndexController@index']);

    /**
     * 路由别名作用  主要是为了【route('uadd')】可以更方便的为特定路由生成 URL 或进行重定向;
     */
    Route::get('/Index/show',  'Home\IndexController@show')->name('i_show');



});


