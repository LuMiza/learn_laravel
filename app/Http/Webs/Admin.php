<?php
/**
 * 设置后台的路由规则
 */

Route::group(['prefix' => 'admin', 'as' => 'admin::'], function () {

    /**
     * 所有关于admin的路由全部在此操作
     */
    //后台首页
    Route::get('/', 'Admin\IndexController@index')->name('Admin.Index.index');

    //由于使用了路由前缀 那么访问如下路由 url应为：http://www.laravel.cn/admin/show
//    Route::get('/show/{id?}', 'Admin\IndexController@show')->name('Admin.Index.show');

    //管理员列表
    Route::match(['get', 'post'], 'power/{p?}', 'Admin\PowerController@index')
        ->name('Admin.Power.index')
        ->where('p','^[1-9]{1}\d*$');
    //添加管理员
    Route::match(['get', 'post'], 'power/addAdmin', 'Admin\PowerController@addAdmin')->name('Admin.Power.addAdmin');




});