<?php

return [
    //ftp连接信息
    'ftp' => [
        'host' => 'rumble.ftp-gz01.bcehost.com',//ftp地址
        'port' => 8010,//端口
        'username' => 'rumble',//用户名
        'password' => 'rumblemiza',//密码
        'root_path'     => '/webroot/AAA',//文件存放的根目录【使用绝对地址】
    ],
    //文件将要存放那个目录下
    'save_path' => 'goods_imgs',
    //允许上传的文件类型
    'allow_file' => [
        'jpg', 'png', 'jpeg', 'txt', 'xlsx', 'xls', 'pdf', 'doc', 'docx', 'md'
    ],
    //允许上传文件的最大size
    'size' => 10,//单位M
];