<?php
/**
 * @Desc    EntranceController.php--Proudly Use PHPStorm IDE
 * @Author  Monge.Ge
 * @Time    2015-12-10 14:27
 * @Desc    微信公众平台入口
 */
namespace app\controllers;

use common\tool\Lang;
use Yii;
use common\tool\Code;
use common\tool\Tool;

class HomeController extends BaseController{

    private $_data;
    private $_token;
    private $_unique;//
    //

    public $enableCsrfValidation    = false;//禁用Csrf验证,不然微信端POST请求无法将数据传输过来

    public function actionIndex()
    {
        //检查SimpleXMLElement是否存在
        if (!class_exists('SimpleXMLElement'))
            return Tool::reJson(null, 'SimpleXMLElement Not Exist!', Code::FAIL);

        $this->_unique = htmlspecialchars(Yii::$app->request->params['unique']);

        if(!preg_match("/^[0-9a-zA-Z]{3,42}$/",$this->_unique))
            return Tool::reJson(null, Lang::L_ILLEGAL_TOKEN , Code::ILLEGAL_TOKEN);



    }



}