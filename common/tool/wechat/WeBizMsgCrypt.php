<?php
/**
 * @Desc    WeBizMsgCrypt.php--Proudly Use PHPStorm IDE
 * @Author  Monge.Ge
 * @Time    2015-12-14 15:02
 * @Desc    微信接口消息加密解密
 */

namespace common\tool\wechat;



//错误代码类
class ErrorCode{

    CONST   OK                          = 0;
    CONST   ValidateSignatureError      = -40001;
    CONST   ParseXmlError               = -40002;
    CONST   ComputeSignatureError       = -40003;
    CONST   IllegalAesKey               = -40004;
    CONST   ValidateAppidError          = -40005;
    CONST   EncryptAESError             = -40006;
    CONST   DecryptAESError             = -40007;
    CONST   IllegalBuffer               = -40008;
    CONST   EncodeBase64Error           = -40009;
    CONST   DecodeBase64Error           = -40010;
    CONST   GenReturnXmlError           = -40011;
}


//提供基于PKCS7算法的加解密接口.
class PKCS7Encoder{

    CONST   BLOCK_SIZE                  = 32;

    //补齐明文字符串
    public function encode($text){
        $block_size                     = intval(self::BLOCK_SIZE);
        $text_length                    = strlen($text);
        $amount_to_pad                  = $block_size - ($text_length % $block_size);//计算需要填充的位数
        if ($amount_to_pad == 0) {
            $amount_to_pad              = $block_size;
        }
        $pad_chr                        = chr($amount_to_pad);//获得补位所用的字符
        $tmp                            = "";
        for ($index = 0; $index < $amount_to_pad; $index++) {
            $tmp                        .= $pad_chr;
        }
        return $text . $tmp;
    }

    //删除填充补位后的明文
    public function decode($text){
        $pad                            = ord(substr($text, -1));
        if ($pad < 1 || $pad > 32) {
            $pad                        = 0;
        }
        return substr($text, 0, (strlen($text) - $pad));
    }

    //
}


class Prpcrypt{

    public $key;

    //构造函数
    public function __construct($k){
        $this->key                      = base64_decode($k . "=");
    }

    /**
     * 对明文进行加密
     * @param string $text 需要加密的明文
     * @return string 加密后的密文
     */
    public function encrypt($text, $appid){
        try {
            $random                     = Tool::randStr(16);//获得16位随机字符串，填充到明文之前
            $text                       = $random . pack("N", strlen($text)) . $text . $appid;
            // 网络字节序
            $size                       = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
            $module                     = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            $iv                         = substr($this->key, 0, 16);
            //使用自定义的填充方式对明文进行补位填充
            $pkc_encoder                = new PKCS7Encoder();
            $text                       = $pkc_encoder->encode($text);
            mcrypt_generic_init($module, $this->key, $iv);
            $encrypted                  = mcrypt_generic($module, $text);//加密
            mcrypt_generic_deinit($module);
            mcrypt_module_close($module);
            //print(base64_encode($encrypted));
            return array(ErrorCode::OK, base64_encode($encrypted));//使用BASE64对加密后的字符串进行编码

        } catch (\Exception $e) {
            print $e;
            return array(ErrorCode::EncryptAESError, null);
        }
    }

    /**
     * 对密文进行解密
     * @param string $encrypted 需要解密的密文
     * @return string 解密得到的明文
     */
    public function decrypt($encrypted, $appid){

        try {
            $ciphertext_dec             = base64_decode($encrypted);//使用BASE64对需要解密的字符串进行解码
            $module                     = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            $iv                         = substr($this->key, 0, 16);
            mcrypt_generic_init($module, $this->key, $iv);

            $decrypted                  = mdecrypt_generic($module, $ciphertext_dec);//解密
            mcrypt_generic_deinit($module);
            mcrypt_module_close($module);
        } catch (\Exception $e) {
            return array(ErrorCode::DecryptAESError, null);
        }

        try {
            $pkc_encoder                = new PKCS7Encoder();//去除补位字符
            $result                     = $pkc_encoder->decode($decrypted);

            if (strlen($result) < 16){//去除16位随机字符串,网络字节序和AppId
                return "";
            }
            $content                    = substr($result, 16, strlen($result));
            $len_list                   = unpack("N", substr($content, 0, 4));
            $xml_len                    = $len_list[1];
            $xml_content                = substr($content, 4, $xml_len);
            $from_appid                 = substr($content, $xml_len + 4);
        }catch (\Exception $e){
            print $e;
            return array(ErrorCode::IllegalBuffer, null);
        }
        if ($from_appid != $appid){
            return array(ErrorCode::ValidateAppidError, null);
        }
        return array(0, $xml_content);
    }
}


class SHA1{

    /**
     * 用SHA1算法生成安全签名
     * @param string $token 票据
     * @param string $timestamp 时间戳
     * @param string $nonce 随机字符串
     * @param string $encrypt 密文消息
     */
    public function getSHA1($token, $timestamp, $nonce, $encrypt_msg){
        //排序
        try {
            $array                      = array($encrypt_msg, $token, $timestamp, $nonce);
            sort($array, SORT_STRING);
            $str                        = implode($array);
            return array(ErrorCode::OK, sha1($str));
        }catch (\Exception $e){
            print $e . "\n";
            return array(ErrorCode::ComputeSignatureError, null);
        }
    }
}

class XMLParse{

    /**
     * 提取出xml数据包中的加密消息
     * @param string $xmltext 待提取的xml字符串
     * @return string 提取出的加密消息字符串
     */
    public function extract($xmltext){
        try {
            $xml                        = new \DOMDocument();
            $xml->loadXML($xmltext);
            $array_e                    = $xml->getElementsByTagName('Encrypt');
            $array_a                    = $xml->getElementsByTagName('ToUserName');
            $encrypt                    = $array_e->item(0)->nodeValue;
            $tousername                 = $array_a->item(0)->nodeValue;
            return array(0, $encrypt, $tousername);
        } catch (\Exception $e) {
            print $e . "\n";
            return array(ErrorCode::ParseXmlError, null, null);
        }
    }

    /**
     * 生成xml消息
     * @param string $encrypt 加密后的消息密文
     * @param string $signature 安全签名
     * @param string $timestamp 时间戳
     * @param string $nonce 随机字符串
     */
    public function generate($encrypt, $signature, $timestamp, $nonce){
        $format = "<xml>
                    <Encrypt><![CDATA[%s]]></Encrypt>
                    <MsgSignature><![CDATA[%s]]></MsgSignature>
                    <TimeStamp>%s</TimeStamp>
                    <Nonce><![CDATA[%s]]></Nonce>
                   </xml>";
        return sprintf($format, $encrypt, $signature, $timestamp, $nonce);
    }
}

/**
 * 1.第三方回复加密消息给公众平台；
 * 2.第三方收到公众平台发送的消息，验证消息的安全性，并对消息进行解密。
 */
class WeBizMsgCrypt
{
    private $_token;
    private $_encodingAesKey;
    private $_appId;

    /**
     * 构造函数
     * @param $token string 公众平台上，开发者设置的token
     * @param $encodingAesKey string 公众平台上，开发者设置的EncodingAESKey
     * @param $appId string 公众平台的appId
     */
    public function __construct($token, $encodingAesKey, $appId){
        $this->_token               = $token;
        $this->_encodingAesKey      = $encodingAesKey;
        $this->_appId               = $appId;
    }

    /**
     * 将公众平台回复用户的消息加密打包.
     * <ol>
     *    <li>对要发送的消息进行AES-CBC加密</li>
     *    <li>生成安全签名</li>
     *    <li>将消息密文和安全签名打包成xml格式</li>
     * </ol>
     *
     * @param $replyMsg string 公众平台待回复用户的消息，xml格式的字符串
     * @param $timeStamp string 时间戳，可以自己生成，也可以用URL参数的timestamp
     * @param $nonce string 随机串，可以自己生成，也可以用URL参数的nonce
     * @param &$encryptMsg string 加密后的可以直接回复用户的密文，包括msg_signature, timestamp, nonce, encrypt的xml格式的字符串,
     *                      当return返回0时有效
     *
     * @return int 成功0，失败返回对应的错误码
     */
    public function encryptMsg($replyMsg, $timeStamp, $nonce, &$encryptMsg){
        $pc                         = new Prpcrypt($this->_encodingAesKey);
        $array                      = $pc->encrypt($replyMsg, $this->_appId);//加密
        $ret                        = $array[0];
        if ($ret != 0)              return $ret;
        if ($timeStamp == null)     $timeStamp = time();
        $encrypt                    = $array[1];
        $sha1                       = new SHA1();
        $array                      = $sha1->getSHA1($this->_token, $timeStamp, $nonce, $encrypt); //生成安全签名
        $ret                        = $array[0];
        if ($ret != 0)              return $ret;
        $signature                  = $array[1];
        $xmlparse                   = new XMLParse();//生成发送的xml
        $encryptMsg                 = $xmlparse->generate($encrypt, $signature, $timeStamp, $nonce);
        return ErrorCode::OK;
    }


    /**
     * 检验消息的真实性，并且获取解密后的明文.
     * <ol>
     *    <li>利用收到的密文生成安全签名，进行签名验证</li>
     *    <li>若验证通过，则提取xml中的加密消息</li>
     *    <li>对消息进行解密</li>
     * </ol>
     *
     * @param $msgSignature string 签名串，对应URL参数的msg_signature
     * @param $timestamp string 时间戳 对应URL参数的timestamp
     * @param $nonce string 随机串，对应URL参数的nonce
     * @param $postData string 密文，对应POST请求的数据
     * @param &$msg string 解密后的原文，当return返回0时有效
     *
     * @return int 成功0，失败返回对应的错误码
     */
    public function decryptMsg($msgSignature, $timestamp = null, $nonce, $postData, &$msg){
        if (strlen($this->_encodingAesKey) != 43) {
            return ErrorCode::IllegalAesKey;
        }
        $pc                         = new Prpcrypt($this->_encodingAesKey);
        $xmlparse                   = new XMLParse();
        $array                      = $xmlparse->extract($postData);//提取密文
        $ret                        = $array[0];

        if ($ret != 0)              return $ret;
        if ($timestamp == null)     $timestamp = time();
        $encrypt                    = $array[1];
        $touser_name                = $array[2];
        $sha1                       = new SHA1();
        $array                      = $sha1->getSHA1($this->_token, $timestamp, $nonce, $encrypt);//验证安全签名
        $ret                        = $array[0];
        if ($ret != 0)              return $ret;
        $signature                  = $array[1];
        if ($signature != $msgSignature) {
            return ErrorCode::ValidateSignatureError;
        }
        $result                     = $pc->decrypt($encrypt, $this->_appId);
        if ($result[0] != 0) {
            return $result[0];
        }
        $msg                        = $result[1];
        return ErrorCode::OK;
    }

}
