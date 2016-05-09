<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%officials}}".
 *
 * @property integer $id
 * @property string $mp_name
 * @property integer $mp_type
 * @property string $app_id
 * @property string $app_secret
 * @property string $original_id
 * @property string $wechat_id
 * @property string $head_img
 * @property string $token
 * @property string $unique
 * @property integer $province
 * @property integer $city
 * @property integer $town
 * @property string $address
 * @property string $email
 * @property string $aes
 * @property integer $encode
 * @property integer $created_at
 * @property integer $updated_at
 */
class Officials extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%officials}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mp_name', 'app_id', 'app_secret', 'original_id', 'wechat_id', 'head_img', 'token', 'unique'], 'required'],
            [['mp_type', 'province', 'city', 'town', 'encode', 'created_at', 'updated_at'], 'integer'],
            [['mp_name', 'app_id', 'original_id', 'wechat_id'], 'string', 'max' => 40],
            [['app_secret', 'unique', 'email'], 'string', 'max' => 60],
            [['head_img'], 'string', 'max' => 255],
            [['token', 'address', 'aes'], 'string', 'max' => 100],
            [['unique'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mp_name' => '公众号名称',
            'mp_type' => '公众号类型 1 订阅号 2 服务号 3企业号',
            'app_id' => '公众号APPID',
            'app_secret' => '公众号secret',
            'original_id' => '公众号原始ID',
            'wechat_id' => '微信号',
            'head_img' => '公众号头像',
            'token' => '唯一TOKEN',
            'unique' => '唯一值',
            'province' => '省',
            'city' => '市区',
            'town' => 'Town',
            'address' => '详细地址 街道等',
            'email' => '公众号邮箱',
            'aes' => 'EncodingAESKey(消息加解密密钥)',
            'encode' => '消息加密方式 0 明文 1兼容模式 2安全模式',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }
}
