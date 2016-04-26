<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%weixinmp}}".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $mp_name
 * @property integer $mp_kind
 * @property string $appid
 * @property string $appsecret
 * @property string $mp_originid
 * @property string $wechat_id
 * @property string $headlogo
 * @property string $token
 * @property string $uniquekey
 * @property string $encoding_aes_key
 * @property integer $encode
 * @property integer $create_at
 * @property integer $update_at
 */
class Weixinmp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%weixinmp}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'mp_kind', 'encode', 'create_at', 'update_at'], 'integer'],
            [['mp_name'], 'string', 'max' => 60],
            [['appid', 'appsecret', 'encoding_aes_key'], 'string', 'max' => 50],
            [['mp_originid', 'wechat_id'], 'string', 'max' => 20],
            [['headlogo', 'uniquekey', 'token'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => '后台用户ID',
            'mp_name' => '公众号名称',
            'mp_kind' => '公众号类型',
            'appid' => 'Appid',
            'appsecret' => 'Appsecret',
            'mp_originid' => '公众号原始ID',
            'wechat_id' => '微信号',
            'headlogo' => '公众号头像',
            'uniquekey' => '微信公众号唯一标示',
            'token' => '消息加密Secret',
            'encoding_aes_key' => 'EncodingAESKey',
            'encode' => '是否加密',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
