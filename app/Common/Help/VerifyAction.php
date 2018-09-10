<?php
namespace App\Common\Help;
/**
 * 验证类
 */
class VerifyAction{
    /*
     * 是否为空值
     */  
    public static function isEmpty($str)
    {
        $str = trim($str);    
        return !empty($str) ? true : false;
    }
    /*
     * 验证浮点数
     * $flag   true=>正负浮点数皆可验证       false=>仅能验证正浮点数
     * */
    public static function isFloat($param,$flag=true)
    {
    	if($flag)
    	{
    		return ( preg_match('/^(-?\d+)(\.\d+)?$/',$param)==0 )? false : true ; 
    	}
    	if(!$flag)
    	{
    		return ( preg_match('/^\d+(\.\d+)?$/',$param)==0 )? false : true ;
    	}
    }
    /*
     * 验证数据自增id
     * */
    public static function isId($param)
    {
    	return ( preg_match('/^[1-9]+\d*$/',$param)==0 ) ? false : true ;
    }
    /*
     * 验证正整数包括0
     */
    public static function isInt($param)
    {
    	return (preg_match('/^(0|[1-9]+\d*)$/',$param)==0) ? false : true;
    }
    /*
     * 验证所有整数，包括0和正负数整数
     * */
    public static function isIntSigned($param)
    {
    	return ( preg_match('/^(0|[1-9][0-9]*|-[1-9][0-9]*)$/',$param)==0 )? false : true;
    }
    /*
     * 数字验证
     * param:$flag : int是否是整数，float是否是浮点型
     */      
    public static function isNum($str,$flag = 'float')
    {
        if(!self::isEmpty($str)) return false;
        if(strtolower($flag) == 'int')
        {
            return ((string)(int)$str === (string)$str) ? true : false;
        }
        else
        {
            return ((string)(float)$str === (string)$str) ? true : false;
        }
    } 
    /*
     * 名称匹配，如用户名，目录名等
     * @param:string $str 要匹配的字符串
     * @param:$chinese 是否支持中文,默认支持，如果是匹配文件名，建议关闭此项（false）
     * @param:$charset 编码（默认utf-8,支持gb2312）
     */  
    public static function isName($str,$chinese = true,$charset = 'utf-8')
    {
        if(!self::isEmpty($str)) return false;
        if($chinese)
        {
            $match = (strtolower($charset) == 'gb2312') ? "/^[".chr(0xa1)."-".chr(0xff)."A-Za-z0-9_-]+$/" : "/^[x{4e00}-x{9fa5}A-Za-z0-9_]+$/u";
        }
        else
        {
            $match = '/^[A-za-z0-9_-]+$/';
        }
        return preg_match($match,$str) ? true : false;
    }
    /*
     * 邮箱验证
     */      
    public static function isEmail($str)
    {
        if(!self::isEmpty($str)) return false;
        return preg_match('/([a-z0-9]*[-_\.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z]{2})?/i',$str) ? true : false;
    }
    
    //手机号码验证
    public static function isMobile($str)
    {
        //$exp = "/^13[0-9]{1}[0-9]{8}$|15[012356789]{1}[0-9]{8}$|18[012356789]{1}[0-9]{8}$|14[57]{1}[0-9]$/";
        $exp = '/^1(3|4|5|7|8)\d{9}$/';
        if(preg_match($exp,$str))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    /*
     * 验证固话
    * $multiFlag   默认为false
    * 			true允许的电话格式为固话或手机，false允许的电话格式仅仅为固话
    * */
    public static function isTelephone($str,$multiFlag=false)
    {
    	if( !isset($multiFlag)  ||  !is_bool($multiFlag) ) return false;
    	if(!self::isEmpty($str))return false;
    	$rep='/^\d{3}-\d{8}$|^\d{4}-\d{7}$|^\d{4}-\d{8}$/';
    	
    	if(!$multiFlag)
    	{
    		if( preg_match($rep,trim($str)) )
    		{
    			return true;
    		}
    		else
    		{
    			return false;
    		}
    	}
    	else
    	{
    		if(self::isMobile(trim($str)))
    		{
    			return true;
    		}
    		else
    		{
    			if( preg_match($rep,trim($str)) )
    			{
    				return true;
    			}
    			else
    			{
    				return false;
    			}
    		}
    	}
    }
    /*
     * URL验证，纯网址格式，不支持IP验证
     */      
    public static function isUrl($str)
    {
        if(!self::isEmpty($str)) return false;
        return preg_match('#(http|https|ftp|ftps)://([w-]+.)+[w-]+(/[w-./?%&=]*)?#i',$str) ? true : false;
    }
    /*
     * 验证中文
     * @param:string $str 要匹配的字符串
     * @param:$charset 编码（默认utf-8,支持gb2312）
     */  
    public static function isChinese($str,$charset = 'utf-8')
    {
        if(!self::isEmpty($str)) return false;
        $match = (strtolower($charset) == 'gb2312') ? "/^[".chr(0xa1)."-".chr(0xff)."]+$/"
        : "/^[x{4e00}-x{9fa5}]+$/u";
        return preg_match($match,$str) ? true : false;       
    }
    /*
     * UTF-8验证
     */      
    public static function isUtf8($word)
    {
        if(!self::isEmpty($word)) return false;
        return (preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$word)
            == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$word)
            == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$word)
            == true) ? true : false;
    }
		/* #验证是否为指定语言,$value传递值;$minLen最小长度;$maxLen最长长度;$charset默认字符类别（en只能英文;cn只能汉字;alb数字;ALL不限制）
        #@param string $value
        #@param int $length
        #@return boolean
        */
    public static function isLanguage($value,$charset='all',$minLen=1,$maxLen=50)
    {
            if(!$value) return false;
            switch($charset)
            {
                case 'en':$match = '/^[a-zA-Z]{'.$minLen.','.$maxLen.'}$/iu';break;
                case 'cn':$match = '/^[\x{4e00}-\x{9fa5}]{'.$minLen.','.$maxLen.'}$/iu';break;
                case 'alb':$match = '/^[0-9]{'.$minLen.','.$maxLen.'}$/iu';break;
                case 'enalb':$match = '/^[a-zA-Z0-9]{'.$minLen.','.$maxLen.'}$/iu';break;
                case 'all':$match = '/^[a-zA-Z0-9\x{4e00}-\x{9fa5}]{'.$minLen.','.$maxLen.'}$/iu';break;
                //all限制为：只能是英文或者汉字或者数字的组合
            }
            return preg_match($match,$value);
        }
    /*
     * 验证长度
     * @param: string $str
     * @param: int $type(方式，默认min <= $str <= max)
     * @param: int $min,最小值;$max,最大值;
     * @param: string $charset 字符
    */
    public static function length($str,$type=3,$min=0,$max=0,$charset = 'utf-8')
    {
        if(!self::isEmpty($str)) return false;
        $len = mb_strlen($str,$charset);
        switch($type)
        {
            case 1: //只匹配最小值
                return ($len >= $min) ? true : false;
                break;
            case 2: //只匹配最大值
                return ($max >= $len) ? true : false;
                break;
            default: //min <= $str <= max
                return (($min <= $len) && ($len <= $max)) ? true : false;
        }
    }
    /*
     * 验证密码
     * @param string $value
     * @param int $length
     * @return boolean
     */
    public static function isPWD($value,$minLen=6,$maxLen=16)
    {
        $match='/^[\\~!@#$%^&*()-_=+|{}\[\],.?\/:;\'\"\d\w]{'.$minLen.','.$maxLen.'}$/';
        $v = trim($value);
        if(empty($v))
            return false;
        return preg_match($match,$v);
    } 
    
    /**
     * 验证是否是纯数字密码
     * @param string $value
     * @param number $minLen 最小密码长度
     * @param number $maxLen 最长密码长度
     * @return boolean
     * */
    public static function isNumPWD($value,$minLen=6,$maxLen=6){
        if( !isset($value) || !is_numeric($minLen) || !is_numeric($maxLen)){
            return false;
        }
        $match = '/^\d{'.$minLen.','.$maxLen.'}$/';
        return preg_match($match,$value);
    }
    /*
     * 验证用户名
     * @param string $value
     * @param int $length
     * @return boolean
     */
    public static function isUserName($value, $minLen=2, $maxLen=16, $charset='ALL')
    {
        if(empty($value))
            return false;
        switch($charset)
        {
            case 'EN': $match = '/^[_\w\d]{'.$minLen.','.$maxLen.'}$/iu';
                break;
            case 'CN':$match = '/^[_\x{4e00}-\x{9fa5}\d]{'.$minLen.','.$maxLen.'}$/iu';
                break;
            default:$match = '/^[_\w\d\x{4e00}-\x{9fa5}]{'.$minLen.','.$maxLen.'}$/iu';
        }
        return preg_match($match,$value);
    } 
    /*
     * 验证邮箱
     * @param string $value
     */  
    public static function checkZip($str)
    {
        if(strlen($str)!=6)
        {
            return false;
        }
        if(substr($str,0,1)==0)
        {
            return false;
        }
        return true;
    } 
    /*
     * 匹配日期
     * 格式为：YYYY-MM-DD
     * @param string $value
     */      
    public static function checkDate($str,$delimiter="-")
    {
        $dateArr = explode($delimiter, $str);
        if (is_numeric($dateArr[0]) && is_numeric($dateArr[1]) && is_numeric($dateArr[2])) 
        {
        if (($dateArr[0] >= 1000 && $dateArr[0] <= 10000) && ($dateArr[1] >= 0 && $dateArr[1] <= 12) && ($dateArr[2] >= 0 && $dateArr[2] <= 31))
            return true;
        else
            return false;
        }
        return false;
    }
    /*
     * 匹配时间
     * 格式：hh:ii:ss
     * @param string $value
     */      
    public static function checkTime($str,$delimiter=":")
    {
        $timeArr = explode($delimiter, $str);
        if (is_numeric($timeArr[0]) && is_numeric($timeArr[1]) && is_numeric($timeArr[2])) 
        {
        if (($timeArr[0] >= 0 && $timeArr[0] <= 23) && ($timeArr[1] >= 0 && $timeArr[1] <= 59) && ($timeArr[2] >= 0 && $timeArr[2] <= 59))
            return true;
        else
            return false;
        }
        return false;
    } 
    /**
     * 匹配时间
     * 格式：yy-mm-dd hh:ii:ss
     * @param string $str
     */ 
    public static function checkDatetime($str)
    {
        if( empty($str) )
        {
          return false;  
        }
        if(preg_match('/^\d{4}-\d{2}-\d{2}\s+\d{2}:\d{2}:\d{2}$/s',$str))
        {
            return true;
        }else{
            return false;
        }
    }
    
    /**
     * 验证银行卡号码
     * @param number $s 银行卡卡号
     * @return  boolean
     * 16-19 位卡号校验位采用 Luhm 校验方法计算：
     *  1，将未带校验位的 15 位卡号从右依次编号 1 到 15，位于奇数位号上的数字乘以 2
     *  2，将奇位乘积的个十位全部相加，再加上所有偶数位上的数字
     *  3，将加法和加上校验位能被 10 整除。
     * */
    public static function isBankCardNo($s) {
        if( empty(trim($s)) )
        {
            return false;
        }
        $s = intval($s);
        $n = 0;
        for ($i = strlen($s); $i >= 1; $i--) {
            $index=$i-1;
            //偶数位
            if ($i % 2==0) {
                $n += $s{$index};
            } else {//奇数位
                $t = $s{$index} * 2;
                if ($t > 9) {
                    $t = (int)($t/10)+ $t%10;
                }
                $n += $t;
            }
        }
        return ($n % 10) == 0;
    }
    
    /**
     * 验证身份证
     * @param string $vStr 身份证
     * @return boolean
     * */
    public static function isIdcard($vStr){
        $vCity = array(
            '11','12','13','14','15','21','22',
            '23','31','32','33','34','35','36',
            '37','41','42','43','44','45','46',
            '50','51','52','53','54','61','62',
            '63','64','65','71','81','82','91'
        );
        
        if (!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $vStr)) return false;
        
        if (!in_array(substr($vStr, 0, 2), $vCity)) return false;
        
        $vStr = preg_replace('/[xX]$/i', 'a', $vStr);
        $vLength = strlen($vStr);
        
        if ($vLength == 18)
        {
            $vBirthday = substr($vStr, 6, 4) . '-' . substr($vStr, 10, 2) . '-' . substr($vStr, 12, 2);
        } else {
            $vBirthday = '19' . substr($vStr, 6, 2) . '-' . substr($vStr, 8, 2) . '-' . substr($vStr, 10, 2);
        }
        
        if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday) return false;
        if ($vLength == 18)
        {
            $vSum = 0;
            
            for ($i = 17 ; $i >= 0 ; $i--)
            {
                $vSubStr = substr($vStr, 17 - $i, 1);
                $vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr , 11));
            }
            
            if($vSum % 11 != 1) return false;
        }
        
        return true;
    }
    
    /**
     * 验证一维数组中的所有元素是否全部是正整数
     * @param array $param 一维数组
     * @return boolean
     * */
    public static function isArrNum($param)
    {
        if( isset($param) && is_array($param) && (count($param)==count($param,1)) )
        {
           $i= 0;
           foreach($param as $keyOne=> $valOne)
           {
               if( !self::isInt($valOne) )
               {
                   return false;
               }
               $i++;
           }
           if( $i==count($param) && count($param)>0 )
           {
               return true;
           }
           return false;
        }
        return false;
    }
    
    /**
     * 验证是否是价格 [正整数，或浮点数（小数点1-2位）]
     * @param integer / float $param 价格
     * @param boolean $isFlag 默认false：正整数或正浮点数  true：判断正负整数或正负浮点数
     * @return boolean
     * */
    public static function isPrice($param,$isFlag=false){
        if( !isset($param) ){
            return false;
        }
        if(!$isFlag){
            return preg_match('/^(\d+\.[\d]{1,2})$|^(0|[1-9]+\d*)$/', $param) == 1 ? true : false;
        }else{
            return preg_match('/^(0|-?[1-9][0-9]*|-?\d+\.\d{1,2})$/',$param)  == 1 ? true : false;
        }
    }
    
}