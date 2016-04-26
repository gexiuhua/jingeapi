<?php
/**
 * @Desc    WeJs.php--Proudly Use PHPStorm IDE
 * @Author  Monge.Ge
 * @Time    2015-12-17 10:46
 * @Desc    微信JS SDK
 */
namespace   common\tool;

use Yii;
use yii\helpers\Json;

class TicketObject{
    public $expires_time = 0;
    public $jsapi_ticket = null;
}

class AccessTokenObject{
    public $expires_time = 0;
    public $access_token = null;
}

class WeJs{

    private $_appkey;
    private $_appsecret;

    //构造函数
    public function __construct($appkey = '',$appsecret = ''){
        if(empty($appkey) || empty($appsecret)){
            $this->_appkey              = Yii::$app->params['weixin_appkey'];
            $this->_appsecret           = Yii::$app->params['weixin_appsecret'];
        }else{
            $this->_appkey              = $appkey;
            $this->_appsecret           = $appsecret;
        }
    }

    //获取数据包
    public function getSignaturePackage(){
        $jsapiTicket                    = $this->getJsApiTicket();
        if($jsapiTicket){
            // 注意 URL 一定要动态获取，不能 hardcode.
            $protocol                   = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $url                        = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $timestamp                  = time();
            $nonceStr                   = $this->createNonceStr();

            // 这里参数的顺序要按照 key 值 ASCII 码升序排序
            $string                     = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
            $signature                  = sha1($string);
            return [
                "appId" => $this->appId,
                "nonceStr" => $nonceStr,
                "timestamp" => $timestamp,
                "url" => $url,
                "signature" => $signature,
                "rawString" => $string
            ];
        }
        return null;
    }

    //
    public function createNonceStr($length = 16){
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }


    //获取JsApi Ticket
    public function getJsApiTicket(){
        //jsapi_ticket.json不存在,则新建
        if (!file_exists(Yii::$app->getBasePath() . '/runtime/jsapi_ticket.json')) {
            $fp                         = fopen(Yii::$app->getBasePath() . '/runtime/jsapi_ticket.json', 'w');
            fclose($fp);
            chmod(Yii::$app->getBasePath() . '/runtime/jsapi_ticket.json', 0777);//777权限
        }
        $data                           = json_decode(file_get_contents(Yii::$app->getBasePath() . '/runtime/jsapi_ticket.json'));
        $ticket                         = null;
        if($data && isset($data->jsapi_ticket)){
            if (isset($data->expires_time) && $data->expires_time < time() && isset($data->jsapi_ticket)) {
                $accessToken            = $this->getAccessToken();
                if($accessToken){
                    // 如果是企业号用以下 URL 获取 ticket
                    // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
                    $url                = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token={$accessToken}";
                    $res                = Json::decode(file_get_contents($url));
                    if (isset($res->ticket)){
                        $ticket         = $res->ticket;
                        if ($ticket){
                            $data->expires_time = time() + 7000;
                            $data->jsapi_ticket = $ticket;
                            $fp         = fopen(Yii::$app->getBasePath() . '/runtime/jsapi_ticket.json', "w");
                            fwrite($fp, json_encode($data));
                            fclose($fp);
                        }
                    }else{
                        Yii::warning(Json::encode($res) );
                    }
                }
            }else{
                $ticket                 = $data->jsapi_ticket;
            }
        }else{
            $accessToken                = $this->getAccessToken();
            if($accessToken){
                // 如果是企业号用以下 URL 获取 ticket
                // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
                $url                    = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token={$accessToken}";
                $res                    = Json::decode(file_get_contents($url));
                if (isset($res->ticket)){
                    $ticket = $res->ticket;
                    if ($ticket){
                        $data           = new TicketObject();
                        $data->expires_time = time() + 7000;
                        $data->jsapi_ticket = $ticket;
                        $fp             = fopen(Yii::$app->getBasePath() . '/runtime/jsapi_ticket.json', "w");
                        fwrite($fp, json_encode($data));
                        fclose($fp);
                    }
                }
                else{
                    Yii::warning( Json::encode($res) );
                }
            }
        }
    }

    public function getAccessToken(){
        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
        //Yii::warning(Yii::$app->getBasePath());
        if (!file_exists(Yii::$app->getBasePath() . '/runtime/access_token.json')) {
            $fp                         = fopen(Yii::$app->getBasePath() . '/runtime/access_token.json', 'w');
            fclose($fp);
            chmod( Yii::$app->getBasePath() . '/runtime/access_token.json', 0777 );
        }
        $data = json_decode(file_get_contents(Yii::$app->getBasePath() . '/runtime/access_token.json'));
        $access_token=null;
        if( $data ){
            if (isset($data->expires_time) && $data->expires_time < time() && isset($data->access_token)) {
                // 如果是企业号用以下URL获取access_token
                // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
                $url                    = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->_appkey}&secret={$this->_appsecret}";
                $res                    = Json::decode(file_get_contents($url));
                if(isset($res->access_token)){
                    $access_token       = $res->access_token;
                    if ($access_token){
                        $data->expires_time = time() + 7000;
                        $data->access_token = $access_token;
                        $fp = fopen(Yii::$app->getBasePath() . '/runtime/access_token.json', "w");
                        fwrite($fp, json_encode($data));
                        fclose($fp);
                    }
                }else{
                    Yii::warning( Json::encode($res) );
                }
            } else {
                $access_token = $data->access_token;
            }
        }
        else
        {
            // 如果是企业号用以下URL获取access_token
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
            $url                            = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->_appkey}&secret={$this->_appsecret}";
            $res                            = Json::decode(file_get_contents($url));
            if(isset($res->access_token)){
                $access_token               = $res->access_token;
                $data = null;
                if ($access_token){
                    $data = new AccessTokenObject();
                    $data->expires_time     = time() + 7000;
                    $data->access_token     = $access_token;
                    $fp = fopen(Yii::$app->getBasePath() . '/runtime/access_token.json', "w");
                    fwrite($fp, json_encode($data));
                    fclose($fp);
                }
            }else{
                Yii::warning( Json::encode($res) );
            }
        }
        return $access_token;
    }


}