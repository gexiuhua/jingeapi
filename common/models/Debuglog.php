<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%debuglog}}".
 *
 * @property integer $id
 * @property string $content
 * @property integer $timeline
 */
class Debuglog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%debuglog}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['timeline'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'timeline' => 'Timeline',
        ];
    }
}
