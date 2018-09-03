<?php
/**
 * 设置前台的路由规则
 */

Route::group(['as' => 'Home#', 'prefix' => ''],function(){

    Route::get('/', ['uses' => 'Home\IndexController@index']);

    /**
     * 路由别名作用  主要是为了【route('uadd')】可以更方便的为特定路由生成 URL 或进行重定向;
     */
    Route::get('/Index/show',  'Home\IndexController@show')->name('i_show');



});


