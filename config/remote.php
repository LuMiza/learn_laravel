<?php

return [
    //ftp连接信息
    'ftp' => [
        'host' => 'rumst.com',//ftp地址
        'port' => 8010,//端口
        'username' => '',//用户名
        'password' => '',//密码
        'root_path'     => '/webroot/AAA',//文件存放的根目录【使用绝对地址】
    ],
    //curl远程文件操作
    'curl' => [
        'url' => 'http://rumble.*****/curl/',
        //远程文件上传供token验证
        'app_key' => 'aQtvAzZSEN3FP3DI',
    ],
    //文件将要存放那个目录下
    'save_path' => 'goods_imgs',
    //允许上传的文件类型
    'allow_file' => [
        'jpg', 'png', 'jpeg', 'txt', 'xlsx', 'xls', 'pdf', 'doc', 'docx', 'md'
    ],
    //允许上传文件的最大size  单位M
    'size' => 10,
];
