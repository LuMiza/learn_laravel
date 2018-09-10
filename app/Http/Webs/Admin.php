<?php
/**
 * 设置后台的路由规则
 * 本后台系统的权限规则依靠 路由别名  操作方法
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
    Route::match(['get', 'post'], 'power/{p?}', 'Admin\PowerController@index')->name('Admin.Power.index')->where('p','^[1-9]{1}\d*$');
    //添加管理员
    Route::match(['get', 'post'], 'power/addAdmin', 'Admin\PowerController@addAdmin')->name('Admin.Power.addAdmin');
    //修改管理员信息
    Route::match(['get', 'post'], 'power/editAdmin/{id?}', 'Admin\PowerController@editAdmin')->name('Admin.Power.editAdmin')->where('id','^[1-9]{1}\d*$');
    //禁用管理员
    Route::post('power/disAdmin/{id}', 'Admin\PowerController@disAdmin')->name('Admin.Power.disAdmin')->where('id','^[1-9]{1}\d*$');
    //权限列表
    Route::match(['get', 'post'], '/power/rule/{p?}', 'Admin\PowerController@rule')->name('Admin.Power.rule')->where('p','^[1-9]{1}\d*$');
    //添加权限
    Route::match(['get','post'],'/power/addRule','Admin\PowerController@addRule')->name('Admin.Power.addRule');


});