<?php

Route::get('/','Admin\IndexController@index')->name('Admin.Index.index');
//后台首页
Route::controller('index', 'Admin\IndexController', [
    'getDesktop' => 'Admin.Index.getDesktop',
]);

//后台登陆
Route::controller('login','Admin\LoginController', [
    'getIndex' => 'Admin.Login.getIndex',
    'postIndex' => 'Admin.Login.postIndex',
    'getLogout' => 'Admin.Login.getLogout',
]);