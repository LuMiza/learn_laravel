<?php
/**
 * 设置后台的路由规则
 */

Route::group(['prefix' => 'admin'], function () {

    /**
     * 所有关于admin的路由全部在此操作
     */
    //后台首页
    Route::get('/', 'Admin\IndexController@index');



});