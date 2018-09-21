<?php
namespace Common;

class Upload
{
    /**
     * 根目录
     * @var string
     */
    private $root_path = __DIR__;

    /**
     * 存放在根目录下哪个目录
     * @var string
     */
    private $save_path = '';

    /**
     * 允许上传的文件
     * @var null
     */
    private $allow_ext = null;

    /**
     * 允许上传的最大文件   单个M
     * @var int
     */
    private $max_size = 10;

    public function __construct($config)
    {
        $path = (isset($config['root_path']) && $config['root_path'])? $config['root_path'] : __DIR__;
        if (!$path) {
            throw new \Exception('root_path的值未设置');
        }
        $pos = strrpos($path,'/');
        if (!is_bool($pos) && (strlen($path) - 1)==$pos) {
            throw new \Exception('root_path的值末尾不要加  / ');
        }
        $this->root_path = $path;

        $path = (isset($config['save_path'])  &&  $config['save_path'])? $config['save_path']: '';
        if ($path) {
            $pos = strpos($path,'/');
            if (!is_bool($pos) && $pos==0) {
                throw new \Exception('save_path的值前不要加  / ');
            }
            $pos = strrpos($path,'/');
            if (!is_bool($pos) && (strlen($path) - 1)==$pos) {
                throw new \Exception('save_path的值末尾不要加  / ');
            }
        }
        $this->save_path = $path;

        $this->allow_ext = (isset($config['allow_type']) && is_array($config['allow_type']))? $config['allow_type']: ['jpg', 'png', 'jpeg', 'txt', 'xlsx', 'xls', 'pdf', 'doc', 'docx', 'zip'];

        $this->max_size = (isset($config['size']) && preg_match('/^[1-9]{1}\d*$/', $config['size']))? $config['size']: 10;
    }

    /**
     * 单个文件上传
     * @param $file  一维数组
     * @return array
     */
    public function upload($file)
    {
        if (!$this->save_path) {
            $relative_path = date('Y', time()) . '/' . date('m', time()) . '/' .date('d', time());
        } else {
            $relative_path = $this->save_path .'/' .date('Y', time()) . '/' . date('m', time()) . '/' .date('d', time());
        }
        $this->createDir($this->root_path.'/'.$relative_path);
        $infos = pathinfo(ltrim($file['name'],'@'));

        if (!isset($infos['extension'],$file['size'])) {
            return ['msg'=>'不是一个合法的文件', 'code'=>0];
        }
        if (! in_array($infos['extension'], $this->allow_ext)) {
            return ['msg'=>'不允许上传的文件格式', 'code'=>0];
        }

        $file_size = round($file['size']/1024/1024, 2);
        if ($file_size > $this->max_size) {
            return ['msg'=>'上传的文件大小最多只能'.$this->max_size.'M', 'code'=>0];
        }

        $real_path = $relative_path . '/' .date('YmdHis',time()).'_'.mt_rand(1,9999) .'.' . $infos['extension'];
        if (!move_uploaded_file($file['tmp_name'],$this->root_path.'/'.$real_path)) {
            return ['msg'=>'文件上传失败', 'code'=>0];
        }
        return ['msg'=>'文件上传成功', 'code'=>1, 'path'=>$real_path];
    }

    /**
     * 多个文件上传
     * @param $files  二维数组
     * @return array
     */
    public function multiUpload($files)
    {
        $paths = [];
        foreach ($files as $key => $val) {
            $res = $this->upload($val);
            if (!$res['code']) {
                $this->delete($paths);
                return ['msg'=>'文件上传失败', 'code'=>0];
                break;
            }
            array_push($paths, $res['path']);
        }
        return ['msg'=>'文件上传成功', 'code'=>1, 'path'=>$paths];
    }

    /**
     * 删除文件
     * @param $data
     */
    public function delete($data)
    {
        if (!$data || count($data)<=0) {
            return false;
        }
        foreach ($data as $key => $val) {
            @unlink($this->root_path.'/'.$val);
        }
        return true;
    }

    /**
     * 创建目录
     * @param $dir
     * @return bool
     */
    public function createDir($dir)
    {
        if (!file_exists($dir) ){
            mkdir($dir,0777,true);
            return true;
        }
        return true;
    }
}