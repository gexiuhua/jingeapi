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


class Wechat{

    public function __construct()
    {

    }

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