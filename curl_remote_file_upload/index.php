<?php
/**
 * 文件远程上传操作
 */
use Common\Upload;

require 'Upload.class.php';
require 'helper.php';
$config = require 'config.php';

//header('Content-Type:text/html; charset=utf-8');
date_default_timezone_set('Asia/Shanghai');

logs("[".date('Y-m-d H:i:s',time())."]  Token\r\n".$_SERVER['HTTP_X_CSRF_TOKEN']."\r\n");
/**
 * 上传文件token验证
 */
if (! isset($_SERVER['HTTP_X_CSRF_TOKEN'])) {
    $result = ['msg'=>'非法操作', 'code'=>0];
    response_json($result);
}
$token = decrypt($_SERVER['HTTP_X_CSRF_TOKEN'], $config['app_key']);
$reg_res = preg_match('/[1-9]{1}\d{9}$/',$token,$res);
if (!$reg_res || !isset($res,$res[0])) {
    $result = ['msg'=>'非法操作', 'code'=>0];
    response_json($result);
}

$obj = new Upload($config);
if (count($_FILES) == 1) {
    //单个文件上传
    $result = $obj->upload(array_pop($_FILES));
    response_json($result);
} elseif (count($_FILES) > 1) {
    //多个文件上传
    $result = $obj->multiUpload($_FILES);
    response_json($result);
} else {
    $result = ['msg'=>'非法操作', 'code'=>0];
    response_json($result);
}

