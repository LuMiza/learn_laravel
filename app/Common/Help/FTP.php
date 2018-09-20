<?php
/**
 * php操作FTP
 * User: Rumble
 * Date: 2018/9/19
 * Time: 16:36
 * 在调用的FTP类  在执行方法后一定要执行close 方法
 * delete   upload  download 方法内部未内嵌close方法
 * 因此在执行后要close来关闭ftp连接
 */

namespace App\Common\Help;

class FTP
{
    /**
     * FTP 连接
     * @var null
     */
    private $connect = null;

    /**
     * 文件存放的根目录【使用绝对地址】 比如：/webroot/www/
     * @var mixed|null|string
     */
    private $root_path = null;

    /**
     * 文件存放目录
     * @var string
     */
    private $save_path = '';

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

    /**
     * 创建ftp链接 并登录  并且初始化属性值
     * FTP constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $type = config('remote.allow_file');
        if (!$type || !is_array($type)) {
            throw new \Exception('未定义allow_file，允许上传的文件类型');
        }
        $this->max_size = config('remote.size')? config('remote.size'): 10;
        $this->allow_type = $type;
        $path = config('remote.ftp.root_path') ? config('remote.ftp.root_path') : '';
        if (!$path) {
            throw new \Exception('root_path的值未设置');
        }
        $pos = strrpos($path,'/');
        if (!is_bool($pos) && (strlen($path) - 1)==$pos) {
            throw new \Exception('root_path的值末尾不要加  / ');
        }
        $this->root_path = $path;
        $path = config('remote.save_path') ? config('remote.save_path') : '';
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
        $this->save_path =  $path;

        $this->connect = ftp_connect(config('remote.ftp.host'), config('remote.ftp.port'));
        if (!$this->connect) {
            throw new \Exception('建立连接失败');
        }
        $login = ftp_login($this->connect, config('remote.ftp.username'), config('remote.ftp.password'));
        if (!$login) {
            throw new \Exception('登录失败');
        }
        if (!ftp_pasv($this->connect,true)) {
            throw new \Exception('被动模式打开失败');
        }
    }

    /**
     * 返回ftp登录资源
     * @return null|resource
     */
    public function getConnect()
    {
        return $this->connect;
    }

    /**
     * 关闭一个 FTP 连接
     * @return bool
     */
    public function close()
    {
        ftp_close($this->connect);
        return true;
    }

    /**
     * 判断目录是否存在 ，不存在则创建
     * @param $dir
     * @return mixed
     * @throws \Exception
     */
    public function createDir($dir)
    {
        $arr = explode('/', $dir);
        $current_path = '';
        $floor = 0;
        foreach ($arr as $key => $val) {
            if ($key==0 && empty($val)) {
                $current_path .= '/';
            }
            if ($key>0) {
                $flag = false;
                if (in_array($val, ftp_nlist($this->connect,$current_path))) {
                    $flag = true;
                }
                $current_path .= $val . '/';
                if (!$flag) {
                    $floor ++;
                    if (!@ftp_mkdir($this->connect,$current_path)) {
                        throw new \Exception('目录创建失败');
                    }
                    ftp_chdir($this->connect, $current_path);
                }
            }
        }
        return $this;
    }

    /**
     * 获取文件存放的根目录
     * @return mixed|null|string
     */
    public function getRootPath()
    {
        return $this->root_path;
    }

    /**
     * 获取文件存放的目录
     * @return string
     */
    public function getSavePath()
    {
        return $this->save_path;
    }

    /**
     * 切换到对应目录下
     * @param $dirs   目录地址【绝对路径】
     * @return FTP
     * @throws \Exception
     */
    public function cdDir($dirs)
    {
        $current_str = ftp_pwd($this->connect);
        $dir_str = $dirs;
        $current = explode('/',$current_str);
        $dir = explode('/',$dir_str);
        if (strcmp($current_str, $dir_str) == 0) {
            return $this;
        }
        for ($i=0; $i<=count($current); $i++) {
            ftp_cdup($this->connect);
        }
        foreach ($dir as $key => $val) {
            if ($key > 0) {
                $flag = false;
                if (in_array($val, ftp_nlist($this->connect,ftp_pwd($this->connect)))) {
                    $flag = true;
                }
                if (!$flag) {
                    throw new \Exception('目录 ' .$val .' 不存在');
                }
                ftp_chdir($this->connect, $val);
            }
        }
        return $this;
    }

    /**
     * 上传文件
     * @param $file 文件地址
     * @return mixed
     * @throws \Exception
     */
    public function upload($file)
    {
        $infos = pathinfo($file);
        if (!isset($infos['extension'])) {
            return ['msg'=>$file .' 不是一个文件路径', 'code'=>0];
        }
        $file_size = round(filesize(base_path('Aimage/1.jpg'))/1024/1024, 2);
        if ($file_size > $this->max_size) {
            return ['msg'=>'上传的文件大小最多只能'.$this->max_size.'M', 'code'=>0];
        }
        if (!$this->save_path) {
            $relative_path = date('Y', time()) . '/' . date('m', time()) . '/' .date('d', time());
        } else {
            $relative_path = $this->save_path .'/' .date('Y', time()) . '/' . date('m', time()) . '/' .date('d', time());
        }
        $fileName = date('YmdHis',time()) .'_'. mt_rand(1, 9999) .'.' .$infos['extension'];
        $this->createDir( $this->root_path .'/'.$relative_path );
        $this->cdDir($this->root_path .'/'.$relative_path);
        $result = @ftp_put($this->connect,$fileName,$file,FTP_BINARY);
        if (!$result) {
            return ['msg'=>'文件上传失败', 'code'=>0];
        }
        return ['msg'=>'文件上传成功', 'code'=>1, 'path'=>$relative_path.'/'.$fileName];
    }

    /**
     * 删除文件
     * @param $file
     * @return array
     * @throws \Exception
     */
    public function delete($file)
    {
        //[方式一]  不论是否存在 直接执行删除
        if (@ftp_delete($this->connect,$this->root_path.'/'.$file)) {
            return ['msg'=>'文件删除成功', 'code'=>1];
        } else {
            return ['msg'=>'文件删除失败', 'code'=>0];
        }
        //[方式二]  以下会判断当前文件是否存在
        $infos = pathinfo($file);
        if (!isset($infos['extension'])) {
            return ['msg'=>$file .' 不是一个文件路径', 'code'=>0];
        }
        $pos = strpos($infos['dirname'],'/');
        if (!is_bool($pos) && $pos==0) {
            return ['msg'=>$file .'值前不要加  / ', 'code'=>0];
        }
        $this->cdDir($this->root_path .'/'. $infos['dirname']);
        if (in_array($infos['basename'], ftp_nlist($this->connect,ftp_pwd($this->connect)))) {
            if (@ftp_delete($this->connect,$infos['basename'])) {
                return ['msg'=>'文件删除成功', 'code'=>1];
            }
            return ['msg'=>'文件删除失败', 'code'=>0];
        }
        return ['msg'=>$file .'  不存在', 'code'=>0];
    }

    /**
     * 下载文件
     * @param $file 远程文件地址[相对地址]
     * @param $dir 存放的本地目录
     * @return array
     * @throws \Exception
     */
    public function download($file,$dir)
    {
        $infos = pathinfo($file);
        if (!isset($infos['extension'])) {
            return ['msg'=>$file .' 不是一个文件路径', 'code'=>0];
        }
        $pos = strpos($infos['dirname'],'/');
        if (!is_bool($pos) && $pos==0) {
            return ['msg'=>$file .'值前不要加  / ', 'code'=>0];
        }
        $this->cdDir($this->root_path .'/'. $infos['dirname']);
        if (!in_array($infos['basename'], ftp_nlist($this->connect,ftp_pwd($this->connect)))) {
            return ['msg'=>'文件不存在', 'code'=>0];
        }
        if (!file_exists($dir)) {
            mkdir($dir, 0777,true);
        }
        $pos = strrpos($dir,'/');
        if (!is_bool($pos) && (strlen($dir) - 1)==$pos) {
            $save = $dir . $infos['basename'];
        } else {
            $save = $dir .'/'. $infos['basename'];
        }
        if (@ftp_get($this->connect, $save, $infos['basename'], FTP_BINARY)) {
            return ['msg'=>'文件下载成功', 'code'=>1, 'path'=>$save];
        }
        return ['msg'=>'文件下载失败', 'code'=>0];
    }
}