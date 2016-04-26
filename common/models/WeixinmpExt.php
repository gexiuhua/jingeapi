<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%weixinmp_ext}}".
 *
 * @property integer $id
 * @property integer $mpid
 * @property string $country
 * @property string $province
 * @property string $city
 * @property string $qq
 * @property integer $industryid
 * @property string $industryname
 * @property string $statistics
 * @property integer $totalvipcard
 * @property integer $usevipcard
 * @property integer $novipcard
 */
class WeixinmpExt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%weixinmp_ext}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mpid'], 'required'],
            [['mpid', 'industryid', 'totalvipcard', 'usevipcard', 'novipcard'], 'integer'],
            [['statistics'], 'string'],
            [['country', 'province', 'city', 'industryname'], 'string', 'max' => 30],
            [['qq'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mpid' => 'weixinmp id',
            'country' => '国家',
            'province' => '省',
            'city' => '市',
            'qq' => '行业',
            'industryid' => 'Industryid',
            'industryname' => '行业名称',
            'statistics' => '统计代码',
            'totalvipcard' => '会员卡总和',
            'usevipcard' => '在使用会员卡数量',
            'novipcard' => '还未使用VIP Card',
        ];
    }


}
