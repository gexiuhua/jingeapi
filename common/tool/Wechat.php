<?php
/**
 * @Desc    Wechat.php--Proudly Use PHPStorm IDE
 * @Author  Monge.Ge
 * @Time    2015-12-10 9:46
 * @Desc    微信接口
 */

namespace common\tool;

use Yii;
use yii\helpers\Json;
use common\tool\Tool;


class Wechat{
    private $_appkey;
    private $_appsecret;

    //
    public function __construct($appkey = '',$appsecret = ''){
        if(empty($appkey) || empty($appsecret)){
            $this->_appkey      = Yii::$app->params['weixin_appkey'];
            $this->_appsecret   = Yii::$app->params['weixin_appsecret'];
        }else{
            $this->_appkey      = $appkey;
            $this->_appsecret   = $appsecret;
        }
    }

    //获取全局Access Token
    public function getToken(){
        $uri                    = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->_appkey}&secret={$this->_appsecret}";
        $token_json             = Tool::curlRequest($uri);
        $token_obj              = Json::decode($token_json);
        if(isset($token_obj->errcode)){
            Tool::dump($token_obj->errmsg);
        }
        return $token_obj->access_token;
    }

    public function getAccessToken(){

    }



}