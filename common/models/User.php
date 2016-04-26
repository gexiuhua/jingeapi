<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $telephone
 * @property string $password
 * @property string $email
 * @property integer $money
 * @property integer $spend_money
 * @property integer $vip_time
 * @property string $remark
 * @property integer $template
 * @property integer $status
 * @property string $create_ip
 * @property string $from_key
 * @property integer $create_at
 * @property integer $update_at
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['money', 'spend_money', 'vip_time', 'template', 'status', 'create_at', 'update_at'], 'integer'],
            [['username', 'email'], 'string', 'max' => 60],
            [['telephone'], 'string', 'max' => 12],
            [['password'], 'string', 'max' => 50],
            [['remark'], 'string', 'max' => 200],
            [['create_ip'], 'string', 'max' => 30],
            [['from_key'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'telephone' => 'Telephone',
            'password' => 'Password',
            'email' => 'Email',
            'money' => '账户金钱',
            'spend_money' => '使用掉的金钱',
            'vip_time' => 'vip结束时间',
            'remark' => '用户介绍备注',
            'template' => '后台使用模板',
            'status' => 'Status',
            'create_ip' => '创建时IP地址',
            'from_key' => '邀请码',
            'create_at' => '创建时间',
            'update_at' => '更新时间',
        ];
    }
}
