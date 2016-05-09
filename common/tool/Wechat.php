<?php
/**
 * @Desc    Wechat.php--Proudly Use PHPStorm IDE
 * @Author  Monge.Ge
 * @Time    2015-12-10 9:46
 * @Desc    微信接口
 */

namespace common\tool;

use app\models\Officials;
use common\tool\wechat\WeBizMsgCrypt;
use Yii;
use yii\helpers\Json;


class Wechat{

    private $_token;
    private $_data;

    public function __construct($token,$official=NULL)
    {
        $this->authorize($token);
        if(Yii::$app->request->isGet)
            exit(Yii::$app->get('echostr'));
        else{
            $this->_token = $token;
            $encode = isset($official['encode'])?$official['encode']:0;//消息编码方式

            $xml = file_get_contents("php://input");
            if(in_array($encode,[Officials::ENCODE_BOTH,Officials::ENCODE_YES]))
                $this->_data = $this->decodeMsg($xml);
            else{
                $xml = new \SimpleXMLElement($xml);
                $xml || exit;
                foreach($xml as $key=>$value)
                    $this->_data[$key] = $value;
            }
        }
    }


    /**
     *
     */
    public function encodeMsg($sRespData)
    {
        $sReqTimeStamp = time();
        $sReqNonce     = $_GET['nonce'];
        $encryptMsg    = "";
        $pc        = new WeBizMsgCrypt($this->pigsecret, $this->wxuser['aeskey'], $this->wxuser['appid']);
        $sRespData = str_replace('<?xml version="1.0"?>', '', $sRespData);
        $errCode   = $pc->encryptMsg($sRespData, $sReqTimeStamp, $sReqNonce, $encryptMsg);
        if ($errCode == 0) {
            return $encryptMsg;
        } else {
            return $errCode;
        }
    }
    public function decodeMsg($msg)
    {
        $sReqMsgSig    = $_GET['msg_signature'];
        $sReqTimeStamp = $_GET['timestamp'];
        $sReqNonce     = $_GET['nonce'];
        $sReqData      = $msg;
        $sMsg          = "";
        $pc            = new WXBizMsgCrypt($this->pigsecret, $this->wxuser['aeskey'], $this->wxuser['appid']);
        $errCode       = $pc->decryptMsg($sReqMsgSig, $sReqTimeStamp, $sReqNonce, $sReqData, $sMsg);
        if ($errCode == 0) {
            $data = array();
            $xml  = new SimpleXMLElement($sMsg);
            $xml || exit;
            foreach ($xml as $key => $value) {
                $data[$key] = strval($value);
            }
            return $data;
        } else {
            return $errCode;
        }
    }



    /**
     * @param $token
     * @return bool
     */
    private function authorize($token){

        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];

        $tempArr = [
            $token,$timestamp,$nonce
        ];

        sort($tempArr,SORT_STRING);
        $tempStr = implode($tempArr);
        $tempStr = sha1($tempStr);
        if(trim($tempStr) == trim($signature))
            return true;
        else
            return false;
    }

}