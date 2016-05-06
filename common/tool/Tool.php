<?php

namespace common\tool;
use Yii;

use yii\helpers\Json;
use yii\log\FileTarget;

class Tool{

    public static function reJson($data = null, $text = '', $code = null){
        $code === null and $code = Code::SUCCESS;
        $re = [
            'ret'  => (int)$code,
            'text' => $text,
        ];
        $data !== null and $re['data'] = $data;

        return $re;
    }


    /**
     * 浏览器友好的变量输出
     * @param mixed $var 变量
     * @param boolean $echo 是否输出 默认为True 如果为false 则返回输出字符串
     * @param string $label 标签 默认为空
     * @param boolean $strict 是否严谨 默认为true
     * @return void|string
     */
    public static function dump($var, $echo=true, $label=null, $strict=true) {
        $label = ($label === null) ? '' : rtrim($label) . ' ';
        if (!$strict) {
            if (ini_get('html_errors')) {
                $output = print_r($var, true);
                $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
            } else {
                $output = $label . print_r($var, true);
            }
        } else {
            ob_start();
            var_dump($var);
            $output = ob_get_clean();
            if (!extension_loaded('xdebug')) {
                $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
                $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
            }
        }
        if ($echo) {
            echo($output);
            return null;
        }else
            return $output;
    }

    /**
     *	@author Monge.Ge
     *	@desc 	断点调试
     *	@param *[.......]
     *	@return type AND data
     */
    public static function stop()
    {
        $arguments = func_get_args();	//参数集合
        call_user_func_array("var_dump", $arguments);
        die();
    }

    /**
     *	@author Monge.Ge
     *	@desc 	是否是数字
     *	@param str
     *	@return Bool
     */
    public static function isNumber($str) {
        return preg_match( '/^[0-9]+$/', $str );
    }


    /**
     *	@author Monge.Ge
     *	@desc 	是否是邮箱
     *	@param str
     *	@return Bool
     */
    public static function isEmail($str) {
        return preg_match( '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/', $str );
    }

    /**
     *	@author Monge.Ge
     *	@desc 	是否是电话，传真
     *	@param str
     *	@return Bool
     */
    public static function isTelephone($str) {
        return preg_match( '/^((\+?[0-9]{2,4}\-[0-9]{3,4}\-)|([0-9]{3,4}\-))?([0-9]{7,8})(\-[0-9]+)?$/', $str );
    }

    /**
     *	@author Monge.Ge
     *	@desc 	是否是手机号码
     *	@param str
     *	@return Bool
     */
    public static function isMobile($str) {
        return preg_match( '/^(13|15|18|14|17)\d{9}$/', $str );
    }

    /**
     *	@author Monge.Ge
     *	@desc 	是否是网址格式
     *	@param str
     *	@return Bool
     */
    public static function isUrl($str) {
        return preg_match( '/^(\w+:\/\/)?\w+(\.\w+)+.*$/' , $str );
    }

    /**
     *	@author Monge.Ge
     *	@desc 	是否是邮政编码
     *	@param str
     *	@return Bool
     */
    public static function isZipCode( $str ) {
        return preg_match( '/^[1-9]\d{5}$/', trim( $str ) );
    }

    /**
     *	@author Monge.Ge
     *	@desc 	是否是IP地址格式
     *	@param str
     *	@return Bool
     */
    public static function isIpAddress( $str ) {
        if ( ! preg_match( '#^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$#', $str ) ) {
            return false;
        }

        $ip_array = explode( '.', $str );

        //真实的ip地址每个数字不能大于255（0-255）
        return ( $ip_array[0] <= 255 && $ip_array[1] <= 255 && $ip_array[2] <= 255 && $ip_array[3] <= 255 ) ? true : false;
    }

    /**
     *	@author Monge.Ge
     *	@desc 	是否是身份证(中国)
     *	@param str
     *	@return Bool
     */
    public static function isIdCard( $str ) {
        $str = trim( $str );

        if ( preg_match( "/^([0-9]{15}|[0-9]{17}[0-9a-z])$/i", $str ) )
            return true;
        else
            return false;
    }

    /**
     *	@author Monge.Ge
     *	@desc 	随机长度字符串
     *	@param str
     *	@return Bool
     */
    public static function randStr($len,$numeric = false) {
        $chars = array(
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
            "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
            "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
            "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
            "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",
            "3", "4", "5", "6", "7", "8", "9"
        );

        if($numeric){
            $chars = ["0", "1", "2","3", "4", "5", "6", "7", "8", "9"];
        }

        $charsLen = count($chars) - 1;
        shuffle($chars);
        $output = "";
        for ($i=0; $i<$len; $i++) {
            $output .= $chars[mt_rand(0, $charsLen)];
        }
        return $output;
    }

    /**
     *	@author Monge.Ge
     *	@desc 	获取当前URL
     *	@param NULL
     *	@return str
     */
    public static function urlThis() {
        if(!empty($_SERVER["REQUEST_URI"])) {
            $scrtName = $_SERVER["REQUEST_URI"];
            $nowurl = $scrtName;
        } else {
            $scrtName = $_SERVER["PHP_SELF"];
            $nowurl = empty($_SERVER["QUERY_STRING"]) ? $scrtName : $scrtName."?".$_SERVER["QUERY_STRING"];
        }
        return 'http://'.$_SERVER['HTTP_HOST'].$nowurl;
    }

    /**
     *	@author Monge.Ge
     *	@desc 	CURL POST请求
     *	@param NULL
     *	@return str
     */
    public static function curlPost($remote_server,$post_string){

        $header[] = "Content-type: text/xml";//定义content-type为xml
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$remote_server);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_string);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, FALSE);//这里如果不设置会出现以下错误:SSL certificate problem, verify that the CA cert is OK. Details:
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, FALSE);//error:14090086:SSL routines:SSL3_GET_SERVER_CERTIFICATE:certificate verify failed
        curl_setopt($ch,CURLOPT_USERAGENT,"Monge.Ge's Curl Meta Data.");
        $data = curl_exec($ch);
        if(curl_errno($ch))
        {
            print(curl_error($ch));
        }
        curl_close($ch);
        return $data;
    }


    /**
     *	@author Monge.Ge
     *	@desc 	数据装换成XML格式
     *	@param 	NULL
     *	@return xml
     */
    public static function dataToXml($xml, $data, $item = 'item') {
        foreach ($data as $key => $value) {
            /* 指定默认的数字key */
            is_numeric($key) && $key = $item;
            /* 添加子元素 */
            if(is_array($value) || is_object($value)){
                $child = $xml->addChild($key);
                dataToXml($child, $value, $item);
            } else {
                if(is_numeric($value)){
                    $child = $xml->addChild($key, $value);
                } else {
                    $child = $xml->addChild($key);
                    $node  = dom_import_simplexml($child);
                    $node->appendChild($node->ownerDocument->createCDATASection($value));
                }
            }
        }
    }


    /**
     *	@author Monge.Ge
     *	@desc 	将手机号码转成 188****8888
     *	@param 	string
     *	@return str
     */
    function phoneFormat($tel){
        return substr_replace($tel,'****',3,4);
    }


    /**
     *	@author Monge.Ge
     *	@Desc 	格式化链接
     *	@param 	NULL
     *	@return str
     */
    function urlFormat($server,$params = NULL){
        $format_url		= $server;
        if(strpos($server,'?')){
            if(!empty($params)){
                $query_str	= http_build_query($params);
                $format_url = "{$server}&{$query_str}";
            }
        }else{
            if(!empty($params)){
                $query_str	= http_build_query($params);
                $format_url = "{$server}?{$query_str}";
            }
        }
        return $format_url;//
    }

    /**
     * @Desc   PHP CURL POST/GET 请求
     * @param  $url
     * @param  array $post_data
     * @param  string $cookie
     * @param  int $timeout
     * @author Monge.Ge
     * @return mixed|string
     */
    public static function curlRequest($url, $post_data = [], $cookie = '', $timeout = 10){
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        
        $requestIp = self::getRemoteIp();//IP
        $header = [
            'CLIENT-IP:' . $requestIp,
            'X-FORWARDED-FOR:' . $requestIp,
            'REMOTE-ADDR:' . $requestIp,
            'REMOTE-PORT:' . (isset($_SERVER['REMOTE_PORT']) ? $_SERVER['REMOTE_PORT'] : 0),
            'Content-Type:multipart/form-data;charset=utf-8'
        ];//设置CURL头信息

        curl_setopt( $curlHandle, CURLOPT_HEADER, 0 );
        curl_setopt( $curlHandle, CURLOPT_HTTPHEADER, $header );
        curl_setopt( $curlHandle, CURLOPT_FOLLOWLOCATION, 1 );
        curl_setopt( $curlHandle, CURLOPT_MAXREDIRS, 3 );

        if ($cookie != '') 
            curl_setopt($curlHandle, CURLOPT_COOKIE, $cookie);

        if( isset(Yii::$app->request->userAgent) ){
            curl_setopt( $curlHandle, CURLOPT_USERAGENT, Yii::$app->request->userAgent );
        }else{
            curl_setopt( $curlHandle, CURLOPT_USERAGENT, 'Changzhou Jinge Aliyun Server' );
        }
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 0);

        if(!empty($post_data)){
            //增加REMOTE PORT
            $post_data['remote_port'] = isset($_SERVER['REMOTE_PORT']) ? $_SERVER['REMOTE_PORT'] : 0;
            curl_setopt($curlHandle, CURLOPT_POST, count($post_data));
            curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($curlHandle, CURLOPT_TIMEOUT, $timeout);
        }

        if (substr($url, 0, 8) == "https://") {
            curl_setopt( $curlHandle , CURLOPT_SSL_VERIFYHOST, false );
            curl_setopt( $curlHandle , CURLOPT_SSL_VERIFYPEER, false );
        }

        $data = curl_exec($curlHandle);
        $status = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
        curl_close($curlHandle);
        if ($status != 200){
            return $status;
        }
        return $data;
    }

	
	/**
     * @Desc   获取客户端IP地址
     * @author Monge.Ge
     * @param  integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @param  boolean $adv 是否进行高级模式获取（有可能被伪装）
     * @return mixed
     */

    public static function getClientIp($type = 0,$adv=false) {
        $type       =  $type ? 1 : 0;
        static $ip  =   NULL;
        if ($ip !== NULL) return $ip[$type];
        if($adv){
            if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                $pos    =   array_search('unknown',$arr);
                if(false !== $pos) unset($arr[$pos]);
                $ip     =   trim($arr[0]);
            }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                $ip     =   $_SERVER['HTTP_CLIENT_IP'];
            }elseif (isset($_SERVER['REMOTE_ADDR'])) {
                $ip     =   $_SERVER['REMOTE_ADDR'];
            }
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $long = sprintf("%u",ip2long($ip));
        $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }

	/**
     * @Desc   获取请求的IP地址
     * @author Monge.Ge
     * @param  null
     * @return mixed
     */
    public static function getRemoteIp() {
        $ip = '';
        if(isset($_SERVER['REMOTE_ADDR'])){
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        else if (isset($_SERVER['HTTP_CDN_REAL_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CDN_REAL_IP'])){
            $ip = $_SERVER['HTTP_CDN_REAL_IP'];
        }
        else if (isset($_SERVER['HTTP_CDN_SRC_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CDN_SRC_IP'])){
            $ip = $_SERVER['HTTP_CDN_SRC_IP'];
        }
        elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        else if (isset($_SERVER['HTTP_X_REAL_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_X_REAL_IP'])){
            $ip = $_SERVER['HTTP_X_REAL_IP'];
        }
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)){
            foreach ($matches[0] AS $xip){
                if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip))
                {
                    $ip = $xip;
                    break;
                }
            }
        }
        return $ip;
    }

    //格式化返回
    public static function returnJson($data = null, $text = '', $code = null){
        $code === null and $code = Code::SUCCESS;
        $re = [
            'err_code'  => $code,
            'err_msg'   => $text,
        ];
        $data !== null and $re['data'] = $data;
        return $re;
    }

    //JSON_ENCODE
    public static function encodeReturnJson($data = null, $text = '', $code = null){
        return  Json::encode(self::returnJson($data, $text, $code));
    }

    //日志打印调试
    public static function log($message, $target = 'app.log'){
        if(is_array($message) or is_object($message)){
            $message = var_export($message, true);
        }
        $log = new FileTarget();
        $log->logFile = Yii::$app->getRuntimePath() . '/logs/'.$target;
        $log->messages[] = [
            $message,
            1,
            'application',
            time()
        ];
        $log->export();
    }
}