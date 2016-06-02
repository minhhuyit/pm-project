<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "option".
 *
 * @property string $id
 * @property string $name
 * @property string $value
 * @property string $autoload
 */
class Option extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['value'], 'string'],
            [['name'], 'string', 'max' => 200],
            [['autoload'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('cms', 'ID'),
            'name' => Yii::t('cms', 'Name'),
            'value' => Yii::t('cms', 'Value'),
            'autoload' => Yii::t('cms', 'Autoload'),
        ];
    }
}
