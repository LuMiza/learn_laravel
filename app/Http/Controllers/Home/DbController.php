<?php

namespace App\Http\Controllers\Home;

use App\Models\Admin;
use App\Models\Home\Privilege;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class DbController extends Controller
{
    public function index()
    {
        return redirect()->action('Home\DbController@getDemo');
        return 'this is db demo';
    }

    public function getDemo()
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7]);

        $chunks = $collection->chunk(4);
        dd($chunks->toArray());
        $values = Cache::store('file')->get('foo','rumble');
        dd($values);
//        echo $url = url('foo');
//        echo '<br/>this is laravel demo<br/>';
        echo $url = action('Home\DbController@getList');
    }

    public function getList(Request $request)
    {
        echo $request->fullUrl();
        print_r($request->method());
        dd($request->route()->getAction());
        exit();

        $environment = app()->environment();
        dd($environment);
        exit;
        $admin = new Privilege();
        $admin->getData();

        exit;
        $admin = \DB::table('privilege');
        $admin->where('p_name', 'like', '%管理员%');
        $admin->orWhere('p_id', 1);

        dd($admin->get());
        exit;
        $admin = new Admin\Admin();
        $admin->where('a_id', 5);

        dd($admin->get()->toArray());
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
