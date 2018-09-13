<?php


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
    Route::match([ 'post', 'get'], '/power/rule/{p?}', 'Admin\PowerController@rule')->name('Admin.Power.rule')->where('p','^[1-9]{1}\d*$');
    //添加权限
    Route::match(['get','post'],'/power/addRule','Admin\PowerController@addRule')->name('Admin.Power.addRule');
    //修改权限
    Route::match(['get', 'post'], '/power/editRule/{id?}', 'Admin\PowerController@editRule')->name('Admin.Power.editRule')->where('id','^[1-9]{1}\d*$');
    //删除权限
    Route::post('/power/delRule/{id}', 'Admin\PowerController@delRule')->name('Admin.Power.delRule')->where('id','^[1-9]{1}\d*$');
    //角色列表
    Route::match(['get', 'post'], 'power/role/{p?}','Admin\PowerController@role')->name('Admin.Power.role')->where('p','^[1-9]{1}\d*$');
    //添加角色
    Route::match(['get', 'post'], 'power/addRole','Admin\PowerController@addRole')->name('Admin.Power.addRole');
    //修改角色
    Route::match(['get', 'post'], '/power/editRole/{id?}', 'Admin\PowerController@editRole')->name('Admin.Power.editRole')->where('id','^[1-9]{1}\d*$');
    //删除角色
    Route::post('/power/delRole/{id}', 'Admin\PowerController@delRole')->name('Admin.Power.delRole')->where('id','^[1-9]{1}\d*$');
    //分配权限
    Route::match(['get', 'post'], '/power/allotPriv/{id?}', 'Admin\PowerController@allotPriv')->name('Admin.Power.allotPriv')->where('id','^[1-9]{1}\d*$');

