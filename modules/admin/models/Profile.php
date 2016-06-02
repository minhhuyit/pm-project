<?php
namespace admin\models;

use yii\base\Model;

/**
 * Signup form
 */
class Profile extends Model
{
    
    public $first_name;
    public $last_name;
    public $role;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role'], 'string'],
            [['role'], 'required'],
            ['first_name', 'string', 'max' => 100],
            ['last_name', 'string', 'max' => 100],
        ];
    }

}
