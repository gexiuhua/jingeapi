<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%qcloud_user}}".
 *
 * @property string $id
 * @property string $openid
 * @property string $token
 * @property string $mpname
 * @property string $mporiginalid
 * @property string $mpid
 */
class QcloudUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%qcloud_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['openid', 'token', 'mpname', 'mporiginalid', 'mpid'], 'required'],
            [['openid'], 'string', 'max' => 100],
            [['token'], 'string', 'max' => 255],
            [['mpname', 'mporiginalid', 'mpid'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'openid' => 'Openid',//用户唯一标示
            'token' => 'Token',//
            'mpname' => 'Mpname',
            'mporiginalid' => 'Mporiginalid',
            'mpid' => 'Mpid',
        ];
    }
}
