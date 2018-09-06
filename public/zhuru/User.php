<?php

namespace Controller;

use Plugins\Http\Request;

class User
{
    public function getInfo(Request $request,$id)
//    public function getInfo()
    {
        echo $id , '<br/>';
        $request->get();
        echo 'this is getInfo <br/>';
    }

    public function getUser()
    {
        echo 'this is get user';
    }

    /**
     * @var $_name 名字
     */
    public $_name;

    /**
     * @var $_age   年龄
     */
    protected $_age;

}