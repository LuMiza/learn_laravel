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
     * @var mixed|null|string
     */
    private $path = null;

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
        $this->path = config('remote.ftp.path') ? config('remote.ftp.path') : '/';
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
     * 判断文件或目录是否存在
     * @param $conn
     * @param $dir
     */
    private function isExist( $dir='')
    {
        $arr = explode('/', $this->path);
        $current_path = '/';
        foreach ($arr as $key => $val) {
            if ($key>0) {
                $temps = ftp_rawlist($this->connect,$current_path);
                $flag = false;
                foreach ($temps as $tempVal) {
                    if ($val == $tempVal) {
                        $flag = true;
                        break;
                    }
                }
                $current_path .= $val . '/';
                if (!$flag) {
                    ftp_mkdir($this->connect,$current_path);
                }
                echo $val;
                echo '<pre>';
                print_r( ftp_rawlist($this->connect,$current_path) );

            }
        }
        echo $current_path;
        dd($arr);
        dd(ftp_rawlist($this->connect,$this->path.'/webroot_bak'));
    }


    /**
     * 上传文件
     * @param $file
     */
    public function upload($file)
    {
        $this->isExist($this->connect);exit;
        ftp_chdir($conn,'/webroot');
        echo ftp_pwd($this->connect);
        dd(ftp_rawlist($this->connect,'/webroot'));
        dd(ftp_mkdir($this->connect, ftp_pwd($this->connect).'/rumble'));
//        dd(ftp_nlist($conn, ftp_pwd($conn)));
    }

    /**
     * 下载文件
     */
    public function download()
    {

    }
}