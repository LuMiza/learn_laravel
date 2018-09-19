<?php

return [
    //ftp连接信息
    'ftp' => [
        'host' => 'rumble.ftp-gz01.bcehost.com',
        'port' => 8010,
        'username' => 'rumble',
        'password' => 'rumblemiza',
        'path'     => '/webroot/rumble',//文件存放路径
    ],
    //允许上传的文件类型
    'alllow_file' => [
        'jpg', 'png', 'jpeg', 'txt', 'xlsx', 'xls', 'pdf', 'doc', 'docx', 'md'
    ],
    'size' => 10,//单位M
];