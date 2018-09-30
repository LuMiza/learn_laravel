<?php
if (! function_exists('str_randoms')) {
    /**
     * 随机生成指定长度的字符串
     * @param int $length  长度
     * @return null|string
     */
    function str_randoms($length=16)
    {
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";//大小写字母以及数字
        $max = strlen($strPol)-1;

        for($i=0;$i<$length;$i++){
            $str.=$strPol[rand(0,$max)];
        }
        return $str;
    }
}

if (! function_exists('enVal')) {
    /**
     * 加密
     * @param $txt string
     * @param string $key  密钥
     * @return string
     */
    function enVal($txt, $key='')
    {
        return \App\Common\Help\MiniMcrypt::encrypt($txt,$key);
    }
}

if (! function_exists('deVal')) {
    /**
     * 解密
     * @param $txt   string
     * @param string $key  密钥
     * @param int $time  时间[单位秒]，如果$ttl大于0，那么会对加密字符串进行时间判断，超过这个时间则返回null
     * @return string
     */
    function deVal($txt, $key='', $time=0)
    {
        return \App\Common\Help\MiniMcrypt::decrypt($txt, $key, $time);
    }
}

if (! function_exists('deValCall')) {
    /**
     * 定义匿名函数自行处理解密后的数据
     * @param $txt
     * @param $key
     * @param null $callback 定义匿名函数自行处理解密后的数据
     * @return mixed
     */
    function deValCall($txt, $key, $callback=null)
    {
        return \App\Common\Help\MiniMcrypt::decryptCall($txt, $key, $callback);
    }
}

if (! function_exists('d')) {
    /**
     *开发调试 ，格式化输出内容，并且终止程序
    * d 函数参数可以一次性传入多个
    */
    function d()
    {
        $bt = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        if (isset($bt[0]['file'], $bt[0]['line'])) {
            $file =  "{$bt[0]['file']}(line:{$bt[0]['line']})";
            echo '<code><small style="margin:50px 0px;">' . $file . '</small><br /><br /><br />'  . '</code>';
            unset($bt, $file);
        }
        call_user_func_array(array(new \App\Common\Help\Dump(), '__construct'), func_get_args());
        exit();
    }
}

