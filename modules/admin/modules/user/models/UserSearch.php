<?php
namespace admin\modules\user\models;

use yii\base\Model;

/**
 * UserSearch Model for search
 *
 * @author Thuy
 */
class UserSearch extends Model {

    public $username;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['username'], 'string'],
        ];
    }


    public function search($params) {

        $this->load($params);
        
        $dataProvider = \Yii::$app->adminModule->userService->getUserDataProvider($this);

        return $dataProvider;
    }

}
