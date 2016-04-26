<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%wxuser}}".
 *
 * @property integer $id
 * @property string $routerid
 * @property integer $uid
 * @property string $wxname
 * @property integer $wxtype
 * @property string $appid
 * @property string $appsecret
 * @property string $wxid
 * @property string $weixin
 * @property string $headerpic
 * @property string $token
 * @property string $pigsecret
 * @property string $province
 * @property string $city
 * @property string $qq
 * @property integer $wxfans
 * @property integer $typeid
 * @property string $typename
 * @property string $tongji
 * @property integer $allcardnum
 * @property integer $cardisok
 * @property integer $yetcardnum
 * @property integer $totalcardnum
 * @property string $createtime
 * @property string $tpltypeid
 * @property string $updatetime
 * @property string $tpltypename
 * @property string $tpllistid
 * @property string $tpllistname
 * @property string $tplcontentid
 * @property string $tplcontentname
 * @property string $shoptpltypeid
 * @property string $shoptpltypename
 * @property integer $transfer_customer_service
 * @property integer $color_id
 * @property integer $smsstatus
 * @property string $phone
 * @property string $smsuser
 * @property string $smspassword
 * @property integer $emailstatus
 * @property string $email
 * @property string $emailuser
 * @property string $emailpassword
 * @property integer $printstatus
 * @property string $member_code
 * @property string $feiyin_key
 * @property string $device_no
 * @property integer $agentid
 * @property integer $openphotoprint
 * @property integer $freephotocount
 * @property integer $oauth
 * @property string $aeskey
 * @property integer $encode
 * @property string $fuwuappid
 * @property integer $ifbiz
 */
class Wxuser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wxuser}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'wxname', 'wxid', 'weixin', 'headerpic', 'token', 'province', 'city', 'qq', 'wxfans', 'typeid', 'tongji', 'allcardnum', 'cardisok', 'yetcardnum', 'totalcardnum', 'createtime', 'updatetime', 'tpltypename', 'tpllistid', 'tpllistname', 'tplcontentid', 'tplcontentname', 'shoptpltypeid', 'shoptpltypename', 'color_id'], 'required'],
            [['uid', 'wxtype', 'wxfans', 'typeid', 'allcardnum', 'cardisok', 'yetcardnum', 'totalcardnum', 'transfer_customer_service', 'color_id', 'smsstatus', 'emailstatus', 'printstatus', 'agentid', 'openphotoprint', 'freephotocount', 'oauth', 'encode', 'ifbiz'], 'integer'],
            [['tongji'], 'string'],
            [['routerid', 'appid', 'appsecret', 'member_code', 'feiyin_key', 'fuwuappid'], 'string', 'max' => 50],
            [['wxname', 'city'], 'string', 'max' => 60],
            [['wxid', 'weixin', 'tpltypename', 'tpllistname', 'tplcontentname', 'shoptpltypename', 'phone', 'smsuser', 'smspassword', 'emailuser', 'emailpassword'], 'string', 'max' => 20],
            [['headerpic', 'token'], 'string', 'max' => 255],
            [['pigsecret'], 'string', 'max' => 150],
            [['province', 'device_no'], 'string', 'max' => 30],
            [['qq'], 'string', 'max' => 25],
            [['typename'], 'string', 'max' => 90],
            [['createtime', 'updatetime'], 'string', 'max' => 13],
            [['tpltypeid'], 'string', 'max' => 10],
            [['tpllistid', 'tplcontentid', 'shoptpltypeid'], 'string', 'max' => 2],
            [['email'], 'string', 'max' => 100],
            [['aeskey'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'routerid' => 'Routerid',
            'uid' => 'Uid',
            'wxname' => '公众号名称',
            'wxtype' => 'Wxtype',
            'appid' => 'Appid',
            'appsecret' => 'Appsecret',
            'wxid' => '公众号原始ID',
            'weixin' => '微信号',
            'headerpic' => '头像地址',
            'token' => 'Token',
            'pigsecret' => 'Pigsecret',
            'province' => '省',
            'city' => '市',
            'qq' => '公众号邮箱',
            'wxfans' => '微信粉丝',
            'typeid' => '分类ID',
            'typename' => '分类名',
            'tongji' => 'Tongji',
            'allcardnum' => 'Allcardnum',
            'cardisok' => 'Cardisok',
            'yetcardnum' => 'Yetcardnum',
            'totalcardnum' => 'Totalcardnum',
            'createtime' => 'Createtime',
            'tpltypeid' => 'Tpltypeid',
            'updatetime' => 'Updatetime',
            'tpltypename' => '首页模版名',
            'tpllistid' => '列表模版ID',
            'tpllistname' => '列表模版名',
            'tplcontentid' => '内容模版ID',
            'tplcontentname' => '内容模版名',
            'shoptpltypeid' => '商城模板id',
            'shoptpltypename' => '商城模板',
            'transfer_customer_service' => 'Transfer Customer Service',
            'color_id' => 'Color ID',
            'smsstatus' => 'Smsstatus',
            'phone' => 'Phone',
            'smsuser' => 'Smsuser',
            'smspassword' => 'Smspassword',
            'emailstatus' => 'Emailstatus',
            'email' => 'Email',
            'emailuser' => 'Emailuser',
            'emailpassword' => 'Emailpassword',
            'printstatus' => 'Printstatus',
            'member_code' => 'Member Code',
            'feiyin_key' => 'Feiyin Key',
            'device_no' => 'Device No',
            'agentid' => 'Agentid',
            'openphotoprint' => 'Openphotoprint',
            'freephotocount' => 'Freephotocount',
            'oauth' => 'Oauth',
            'aeskey' => 'Aeskey',
            'encode' => 'Encode',
            'fuwuappid' => 'Fuwuappid',
            'ifbiz' => 'Ifbiz',
        ];
    }
}
