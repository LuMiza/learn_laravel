<?php
/**
 * php操作FTP
 * User: Administrator
 * Date: 2018/9/19
 * Time: 16:36
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
     * 创建ftp链接 并登录  并且初始化属性值
     * FTP constructor.
     * @throws \Exception
     */
    public function __construct()
    {
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
        $path = config('remote.ftp.root_path') ? config('remote.ftp.root_path') : '';
        if (!$path) {
            throw new \Exception('root_path的值未设置');
        }
        $pos = strrpos($path,'/');
        if (!is_bool($pos) && (strlen($path) - 1) == $pos) {
            throw new \Exception('root_path的值末尾不要加  / ');
        }
        $this->root_path = $path;
        $path = config('remote.save_path') ? config('remote.save_path') : '';
        if ($path) {
            $pos = strpos($path,'/');
            if (!is_bool($pos) && $pos == 0) {
                throw new \Exception('save_path的值前不要加  / ');
            }
            $pos = strrpos($path,'/');
            if (!is_bool($pos) && (strlen($path) - 1) == $pos) {
                throw new \Exception('save_path的值末尾不要加  / ');
            }
        }
        $this->save_path = $this->root_path . '/' . $path;
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
                $temps = ftp_nlist($this->connect,$current_path);
                $flag = false;
                foreach ($temps as $tempVal) {
                    if ($val == $tempVal) {
                        $flag = true;
                        break;
                    }
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
        $catalog = '';
        foreach ($dir as $key => $val) {
            if ($key > 0) {
                $temps = ftp_nlist($this->connect,ftp_pwd($this->connect));
                $flag = false;
                foreach ($temps as $tempVal) {
                    if ($val == $tempVal) {
                        $flag = true;
                        break;
                    }
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
     * @param $file
     */
    public function upload($file)
    {
        $this->createDir($this->save_path );
        $this->cdDir('/webroot/thinkphp8');
        echo ftp_pwd($this->connect);
        exit;
        echo ftp_pwd($this->connect);
        dd(ftp_rawlist($this->connect,'/webroot'));
    }

    /**
     * 下载文件
     */
    public function download()
    {

    }
}