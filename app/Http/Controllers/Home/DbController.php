<?php

namespace App\Http\Controllers\Home;

use App\Common\Help\CurlFile;
use App\Common\Help\FTP;
use App\Events\Admin\SomeEvent;
use App\Models\Admin;
use App\Models\Home\Privilege;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;

class DbController extends Controller
{
    public function index()
    {
        return redirect()->action('Home\DbController@getDemo');
        return 'this is db demo';
    }

    public function getRemote()
    {
//        $str = 'http://t00img.yangkeduo.com/goods/images/2018-09-19/4aeecae077c00406a81c51a74660d7bb.jpeg';
//        echo dirname($str);
//        dd(pathinfo($str));
//        exit;

        $ftp = new FTP();
//        $result = $ftp->delete('goods_imgs/2018/09/20/20180920021013_1260.jpg');
        $result = $ftp->download('goods_imgs/2018/09/20/20180920023234_7959.jpg',base_path('Aimage/'));
        dd($result);
        $result = $ftp->upload(base_path('Aimage/1.jpg'));
        file_put_contents(base_path('remote_file.txt'),$result['path']."\r\n",FILE_APPEND);
        dd($result);
    }

    public function getDemo()
    {
        header('Content-type:text/html;charset=utf-8;');
        echo mb_strimwidth('本地化功能提供方便的方法来获取多语言的字符串',0,'10','','UTF-8');
        exit();
        $files = \Storage::allFiles(app_path());
        dd($files);
        $post_ =array (
            'author' => 'Gonn',
            'mail'=>'gonn@nowamagic.net',
            'url'=>'http://www.nowamagic.net/',
            'text'=>'欢迎访问简明现代魔法');
        $data=http_build_query($post_);
        $opts = array (
            'http'=>array(
                'method' => 'POST',
                'header'=> "Content-type: application/x-www-form-urlencoded\r\n" .
                    "Content-Length: " . strlen($data) . "\r\n",
                'content' => $data)
        );

        echo $context = stream_context_create($opts);exit;
        echo $data=http_build_query($post_);exit;
        echo PATHINFO_EXTENSION;exit;
        echo storage_path('app');
        exit;
//        event('log.notice');
//        Event::fire('log.notice');
        event(new SomeEvent('<br>this is my event<br>'));
        //触发一个事件
        Event::fire(new SomeEvent('<br>this is my event<br>'));
        exit;
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

    public function getFile()
    {
        /*$arr = [
            'file' => [
                "name" => "1.jpg",
                "type" => "image/jpeg",
                "tmp_name" => "/tmp/phprXylSc",
                "error" => 0,
                "size" => 275859,
            ]
        ];
        print_r($arr);
        dd(array_pop($arr));*/
//        dd( class_exists('Thread') );
//        header('Content-Type:text/html; charset=utf-8');
//        dd(decrypt('xJDMY_r2m9XTQwvlehyNvcDf-q-48U4mFtCtY5-L2o9XHRwDTBtx2vl','aQtvAzZSEN3FP3DI'));

//        $t = preg_match('/[1-9]{1}\d{9}$/',decrypt('UGcrXqe8T.MpT9Or1leJlwecnQXgqWXJIoi59fWKe-T8Z4P_Z4lUTI4','aQtvAzZSN3FP3DI'),$t,$res);
//        dd($res);
        return view('Home/Db/file');
    }
    public function postUpload()
    {

//        dd($_FILES);
        $curl = new CurlFile();
        $result = $curl->upload($_FILES['remote_upload']);
        dd($result);
        exit;
//        $ftp = new FTP();
//        $result = $ftp->upload($_FILES['remote_upload']['tmp_name']);
//        dd($result);
//        dd($_FILES['remote_upload']);


        $file= $_FILES['remote_upload']['tmp_name'];
        if (!class_exists('\CURLFile')) {
            return ['msg'=>'请将php版本升级至>=5.5', 'code'=>0];
        }
        $cfile = new \CURLFile($_FILES['remote_upload']['tmp_name'], $_FILES['remote_upload']['type'], $_FILES['remote_upload']['name']);
        $post_data=array('file'=>$cfile);
        $url="http://rumble.gz01.bdysite.com/curl/";
        $ch = curl_init();   //1.初始化
        curl_setopt($ch, CURLOPT_URL, $url); //2.请求地址
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
        //从 PHP 5.5.0 开始, @ 前缀已被废弃，文件可通过 CURLFile 发送。 设置 CURLOPT_SAFE_UPLOAD 为 TRUE 可禁用 @ 前缀发送文件，以增加安全性。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);//6.执行
        dd($response);

        $ch = curl_init('http://rumble.gz01.bdysite.com/curl/');

        $cfile = new \CURLFile($_FILES['remote_upload']['name'],$_FILES['remote_upload']['type'],'@'.$_FILES['remote_upload']['tmp_name']);

        $data = array('test_file' => $cfile);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        dd($response);
    }
}
