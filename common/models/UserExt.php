<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%user_ext}}".
 *
 * @property integer $id
 * @property integer $message_count
 * @property integer $diy_count
 * @property integer $activity_count
 * @property integer $vipcard_count
 * @property integer $connect_count
 * @property integer $attach_size
 * @property integer $create_at
 * @property integer $update_at
 */
class UserExt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_ext}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_count', 'diy_count', 'activity_count', 'vipcard_count', 'connect_count', 'attach_size', 'create_at', 'update_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message_count' => '短信使用次数数量',
            'diy_count' => 'Diy Count',
            'activity_count' => 'Activity Count',
            'vipcard_count' => 'Vipcard Count',
            'connect_count' => 'Connect Count',
            'attach_size' => '附件大小',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
