<?php
namespace App\Common\Help;

class CurlFile
{
    /**
     * 密钥
     * @var mixed|null
     */
    private $app_key = null;

    /**
     * 上传地址
     * @var mixed|null
     */
    private $url = null;

    /**
     * 允许上传的文件
     * @var array
     */
    private $allow_type = [];

    /**
     * 允许上传的最大size，单位M
     * @var int
     */
    private $max_size = 10;

    public function __construct()
    {
        $type = config('remote.allow_file');
        if (!$type || !is_array($type)) {
            throw new \Exception('未定义allow_file，允许上传的文件类型');
        }
        $this->max_size = config('remote.size')? config('remote.size'): 10;
        $this->allow_type = $type;
        $this->url = config('remote.curl.url');
        if (! config('remote.curl.app_key')) {
            throw new \Exception('请设置app_key');
        }
        $this->app_key = config('remote.curl.app_key');
    }

    /**
     * 多个文件上传数据处理
     * @param $files  多个文件[二维数组]
     * @return array
     */
    private function filterFiles($files)
    {
        $data = [];
        foreach ($files['name'] as $key => $val) {
            if ($val) {
                $file_size = round($files['size'][$key]/1024/1024, 2);
                if ($file_size > $this->max_size) {
                    return ['msg'=>'上传的文件大小最多只能'.$this->max_size.'M', 'code'=>0];
                }
                $infos = pathinfo($val);
                if (! isset($infos['extension'])) {
                    return ['msg'=>' 不是合法的文件', 'code'=>0];
                }
                if (! in_array($infos['extension'], $this->allow_type)) {
                    return ['msg'=>' 不允许上传的文件', 'code'=>0];
                }
                $temp = [
                    'name' => $val,
                    'type' => $files['type'][$key],
                    'tmp_name' => $files['tmp_name'][$key],
                    'error' => $files['error'][$key],
                    'size' => $files['size'][$key],
                ];
                array_push($data, $temp);
            }
        }
        return $data;
    }

    /**
     * 上传文件 [支持单个文件上传  和  多个文件上传]
     * @param $files
     * @return array|mixed
     */
    public function upload($files)
    {
        if (!class_exists('\CURLFile')) {
            return ['msg'=>'请将php版本升级至>=5.5', 'code'=>0];
        }
        if (!is_array($files['name'])) {
            $post_data = new \CURLFile($files['tmp_name'], $files['type'], $files['name']);
        } else {
            $post_data = [];
            $data = $this->filterFiles($files);
            if (isset($data['code'])) {
                return $data;
            }
            if (! $data) {
                return ['msg'=>'未有上传的文件', 'code'=>0];
            }
            foreach ($data as $key => $val) {
                $temp = new \CURLFile($val['tmp_name'], $val['type'], $val['name']);
                array_push($post_data, $temp);
            }
            if (count($post_data) == 1) {
                $post_data = $post_data[0];
            }
        }
        return $this->requestFile($this->url, $post_data);
    }

    /**
     * curl文件上传请求
     * @param $url 远程地址
     * @param $data  数据
     * @return mixed
     */
    private function requestFile($url, $data)
    {
        if (is_array($data)) {
            $post_data = [];
            foreach ($data as $key => $val) {
                $post_data['file'.$key] = $val;
            }
        } else {
            $post_data=array('file'=>$data);
        }
        /**
         * 当前token加密为：随机字符串16个+当前时间+60秒
         *  encrypt(str_randoms(16).(time()+60), $this->app_key)
         */
        $headers = [
            'X-CSRF-TOKEN:'. enVal(str_randoms(16).(time()+60), $this->app_key),
        ];
        $ch = curl_init();   //1.初始化
        //兼容https
        if(stripos($url, 'https://') !== FALSE)
        {
            //禁用后cURL将终止从服务端进行验证
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            /**
             * 1 检查服务器SSL证书中是否存在一个公用名(common name)。
             * 译者注：公用名(Common Name)一般来讲就是填写你将要申请SSL证书的域名 (domain)或子域名(sub domain)。
             * 2 检查公用名是否存在，并且是否与提供的主机名匹配。
             * */
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        }
        curl_setopt($ch, CURLOPT_HEADER, 0);
//        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url); //2.请求地址
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
        //从 PHP 5.5.0 开始, @ 前缀已被废弃，文件可通过 CURLFile 发送。 设置 CURLOPT_SAFE_UPLOAD 为 TRUE 可禁用 @ 前缀发送文件，以增加安全性。
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);//6.执行
        // 读取状态
        $status = curl_getinfo($ch);
        // 读取错误号
        $errno  = curl_errno($ch);
        // 读取错误详情
        $error = curl_error($ch);
        curl_close($ch);
//        dd($errno,$error,$status,$response,json_decode($response, true));
        return json_decode($response, true);
    }
}