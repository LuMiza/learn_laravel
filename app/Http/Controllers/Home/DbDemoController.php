<?php

namespace App\Http\Controllers\Home;

use App\Models\Admin;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DbDemoController extends Controller
{
    public function index()
    {
        return 'this is db demo';
    }

    public function getList()
    {

        $admin = new Admin();

        dd($admin->all()->toArray());
        exit();
//        return 'this is db list';
//        $result = DB::select('select * from admin;');
        $result = DB::connection()->select('select * from admin;');
        $db = DB::connection();
        echo '<pre>';
        print_r($result);
        /*Event::listen('illuminate.query',function($query){
            var_dump($query);
        });*/
        //App/Providers/AppServiceProvider.php
        //boot方法中添加
        /*DB::listen(function($sql, $bindings, $time){
            //写入sql
            file_put_contents('.sqls', "[".date('Y-m-d H:i:s')."]".$sql."\r\n", FILE_APPEND);
        });*/

    }
}
