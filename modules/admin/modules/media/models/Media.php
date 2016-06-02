<?php
namespace admin\modules\media\models;

use yii\base\Model;

/**
 * Signup form
 */
class Media extends Model
{

    public $_attached_file;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['_attached_file', 'string'],
        ];
    }

}
