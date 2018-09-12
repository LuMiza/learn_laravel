<?php
/**
 * Created by PhpStorm.
 * User: Rumble
 * Date: 2018/9/12
 * Time: 21:27
 */

namespace App\Common\Help;


class Errors
{
    public static function throwMsg($msg='', $url=null,$code=403)
    {
        echo view('errors.admin.'.$code, ['message'=>$msg, 'url'=>$url]);
        exit();
    }
}