<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%userinfo}}".
 *
 * @property integer $id
 * @property string $portrait
 * @property integer $wallopen
 * @property integer $total_score
 * @property integer $total_score_bf
 * @property integer $expensetotal
 * @property string $token
 * @property string $wecha_id
 * @property string $wechaname
 * @property string $truename
 * @property string $tel
 * @property string $bornyear
 * @property string $bornmonth
 * @property string $bornday
 * @property string $qq
 * @property integer $sex
 * @property string $age
 * @property string $birthday
 * @property string $address
 * @property string $info
 * @property integer $sign_score
 * @property integer $expend_score
 * @property integer $continuous
 * @property integer $add_expend
 * @property integer $add_expend_time
 * @property integer $live_time
 * @property integer $getcardtime
 * @property double $balance
 * @property string $balance_bf
 * @property string $paypass
 */
class Userinfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%userinfo}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wallopen', 'total_score', 'total_score_bf', 'expensetotal', 'sex', 'sign_score', 'expend_score', 'continuous', 'add_expend', 'add_expend_time', 'live_time', 'getcardtime'], 'integer'],
            [['total_score_bf', 'token', 'wecha_id', 'wechaname', 'tel', 'sex', 'birthday', 'address', 'info', 'sign_score', 'expend_score', 'continuous', 'add_expend', 'add_expend_time', 'live_time', 'getcardtime', 'balance_bf'], 'required'],
            [['balance', 'balance_bf'], 'number'],
            [['portrait', 'info'], 'string', 'max' => 200],
            [['token', 'wecha_id', 'wechaname', 'truename'], 'string', 'max' => 60],
            [['tel', 'qq', 'birthday'], 'string', 'max' => 11],
            [['bornyear', 'bornmonth', 'bornday'], 'string', 'max' => 4],
            [['age'], 'string', 'max' => 3],
            [['address'], 'string', 'max' => 100],
            [['paypass'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'portrait' => 'Portrait',
            'wallopen' => 'Wallopen',
            'total_score' => 'Total Score',
            'total_score_bf' => 'Total Score Bf',
            'expensetotal' => 'Expensetotal',
            'token' => 'Token',
            'wecha_id' => 'Wecha ID',
            'wechaname' => 'Wechaname',
            'truename' => 'Truename',
            'tel' => 'Tel',
            'bornyear' => 'Bornyear',
            'bornmonth' => 'Bornmonth',
            'bornday' => 'Bornday',
            'qq' => 'Qq',
            'sex' => 'Sex',
            'age' => 'Age',
            'birthday' => 'Birthday',
            'address' => 'Address',
            'info' => 'Info',
            'sign_score' => 'Sign Score',
            'expend_score' => 'Expend Score',
            'continuous' => 'Continuous',
            'add_expend' => 'Add Expend',
            'add_expend_time' => 'Add Expend Time',
            'live_time' => 'Live Time',
            'getcardtime' => 'Getcardtime',
            'balance' => 'Balance',
            'balance_bf' => 'Balance Bf',
            'paypass' => 'Paypass',
        ];
    }
}
