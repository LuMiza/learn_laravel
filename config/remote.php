<?php

return [
    //ftp连接信息
    'ftp' => [
        'host' => 'rumble.ftp-gz01.bcehost.com',
        'port' => 8010,
        'username' => 'rumble',
        'password' => 'rumblemiza',
        'root_path'     => '/webroot/AAA',//文件存放的根目录【使用绝对地址】
    ],
    //文件将要存放那个目录下
    'save_path' => 'goods_imgs',
    //允许上传的文件类型
    'allow_file' => [
        'jpg', 'png', 'jpeg', 'txt', 'xlsx', 'xls', 'pdf', 'doc', 'docx', 'md'
    ],
    'size' => 10,//单位M
];