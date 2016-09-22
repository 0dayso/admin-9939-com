<?php
namespace librarys\helpers\utils;

use librarys\helpers\utils\String;

class Utils {
    
    public static function String(){
        return new String();
    }

    /**
     * 结果数据
     *
     * @param Integer $code    状态码
     * @param String $message  数据信息Tag
     * @param mixed $data            数据
     *
     */
    public static function result($code, $message = null, $data = null) {
        return array(
            'code' => $code,
            'message' => $message,
            'data' => $data
        );
    }


    /**
     * 获取不重复随机数
     * @param Integer $min                最小值
     * @param Integer $max                  最大值
     * @param Integer | String $prefix    前缀
     */
    public static function randNum($min = 10000, $max = 999999, $prefix = 0) {
        $tmpNum = $orderNum = array();
        $len = strlen($max);
        $tMin = $oMin = $min;
        $oMax = $max;
        for ($tMin; $tMin <= $max; ++$tMin) {
            $tmpNum[$tMin] = $tMin;
        }
        for ($oMin; $oMin <= $max; ++$oMin) {
            $randNum = mt_rand($oMin, $oMax);
            $rands = sprintf("%0" . $len . "d", $tmpNum[$randNum]);
            $orderNum[$rands] = $prefix;
            --$oMax;
        }
        return $orderNum;
    }

    
    /**
     * 
     * 获取随机数
     *
     * @param int
     * @return string
     */
    public static function randomKeys($length) {
        $str = '';
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;
        for ($i = 0; $i < $length; $i++) {
            $str.=$strPol[rand(0, $max)]; //rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }
        return $str;
    }
    
    /**
     * 截取字符串（1个汉字长度计为1；1个字母长度计为0.5）
     */
    public static function cutString($sourcestr, $cutlength, $addpoint = 1) {
        $returnstr = '';
        $i = 0;
        $n = 0;
        $str_length = strlen($sourcestr); //字符串的字节数
        while (($n < $cutlength) and ( $i <= $str_length)) {
            $temp_str = substr($sourcestr, $i, 1);
            $ascnum = Ord($temp_str); //得到字符串中第$i位字符的ascii码
            if ($ascnum >= 224) {    //如果ASCII位高与224，
                $returnstr = $returnstr . substr($sourcestr, $i, 3); //根据UTF-8编码规范，将3个连续的字符计为单个字符
                $i = $i + 3;            //实际Byte计为3
                $n++;            //字串长度计1
            } elseif ($ascnum >= 192) { //如果ASCII位高与192，
                $returnstr = $returnstr . substr($sourcestr, $i, 2); //根据UTF-8编码规范，将2个连续的字符计为单个字符
                $i = $i + 2;            //实际Byte计为2
                $n++;            //字串长度计1
            } elseif ($ascnum >= 65 && $ascnum <= 90) { //如果是大写字母，
                $returnstr = $returnstr . substr($sourcestr, $i, 1);
                $i = $i + 1;            //实际的Byte数仍计1个
                $n++;            //但考虑整体美观，大写字母计成一个高位字符
            } else {                //其他情况下，包括小写字母和半角标点符号，
                $returnstr = $returnstr . substr($sourcestr, $i, 1);
                $i = $i + 1;            //实际的Byte数计1个
                $n = $n + 0.5;        //小写字母和半角标点等与半个高位字符宽...
            }
        }
        if ($str_length > $i && $addpoint) {
            $returnstr = $returnstr . "..."; //超过长度时在尾处加上省略号
        }
        return $returnstr;
    }

    public static function removehtml($html) {
        return preg_replace("'(<(/)?(\S*?)?[^>]*>)'i", "", $html);
    }

    public static function percentage($data, $format = '%.2f%%') {
        if (is_numeric($data)) {
            $percent_data = floatval($data);
            return sprintf($format, $percent_data * 100);
        }
        return $data;
    }
    
    /*
     * 判断是不是移动端访问
     * 
     */
    public static function ismobile() {
        $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';
        $mobile_browser = 0;
        if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom|blackberry|googlebot-mobile|iemobile|opera mobile|palmos|webos|ucbrowser|qqbrowser)/i', strtolower($_SERVER['HTTP_USER_AGENT'])))
            $mobile_browser++;
        if ((isset($_SERVER['HTTP_ACCEPT'])) and ( strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') !== false))
            $mobile_browser++;
        if (isset($_SERVER['HTTP_X_WAP_PROFILE']))
            $mobile_browser++;
        if (isset($_SERVER['HTTP_PROFILE']))
            $mobile_browser++;
        
        $user_agents =$_SERVER['HTTP_USER_AGENT'];
        $mobile_ua = strtolower(substr($user_agents, 0, 4));
        
        $mobile_agents = array(
            'w3c ', 'acs-', 'alav', 'alca', 'amoi', 'audi', 'avan', 'benq', 'bird', 'blac',
            'blaz', 'brew', 'cell', 'cldc', 'cmd-', 'dang', 'doco', 'eric', 'hipt', 'inno',
            'ipaq', 'java', 'jigs', 'kddi', 'keji', 'leno', 'lg-c', 'lg-d', 'lg-g', 'lge-',
            'maui', 'maxo', 'midp', 'mits', 'mmef', 'mobi', 'mot-', 'moto', 'mwbp', 'nec-',
            'newt', 'noki', 'oper', 'palm', 'pana', 'pant', 'phil', 'play', 'port', 'prox',
            'qwap', 'sage', 'sams', 'sany', 'sch-', 'sec-', 'send', 'seri', 'sgh-', 'shar',
            'sie-', 'siem', 'smal', 'smar', 'sony', 'sph-', 'symb', 't-mo', 'teli', 'tim-',
            'tosh', 'tsm-', 'upg1', 'upsi', 'vk-v', 'voda', 'wap-', 'wapa', 'wapi', 'wapp',
            'wapr', 'webc', 'winw', 'winw', 'xda', 'xda-'
        );
        
        if (in_array($mobile_ua, $mobile_agents))
            $mobile_browser++;
        if (strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false)
            $mobile_browser++;
        // Pre-final check to reset everything if the user is on Windows  
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows') !== false)
            $mobile_browser = 0;
        // But WP7 is also Windows, with a slightly different characteristic  
        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false)
            $mobile_browser++;
        
        return $mobile_browser>0;
    }


}
