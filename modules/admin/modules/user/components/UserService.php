<?php
namespace admin\modules\user\components;

use admin\components\services\BaseAdminService;

/**
 * UserService user data service
 *
 * @author Thuy
 */
class UserService extends BaseAdminService {

    /**
     * Get all user data
     * @param userSearch $userSearch is condition search
     * @return SqlDataProvider $dataProvider
     */
    public function getUserDataProvider($userSearch) {

        $condition = ' WHERE username like :title OR email like :title OR display_name like :title';
        $sql_list_user = 'SELECT'
                            . ' user.id'
                            . ',username'
                            . ',email'
                            . ',display_name'
                        . ' FROM user '
                        . $condition
                        ;
        $search_value ='%'.$userSearch->username.'%';
        $count = \Yii::$app->db->createCommand(
               'SELECT COUNT(*)'
               . ' FROM user'
               . $condition,[':title' => $search_value]
             )->queryScalar();

        $dataProvider = new \yii\data\SqlDataProvider([
            'sql' => $sql_list_user,
            'params' => [':title' => $search_value],
            'totalCount' => $count,
            'key'        => 'id',
            'sort' => [
                'attributes' => [
                    'title',
                    'author',
                    'status',
                ],
            ],
        ]);
        return $dataProvider;
    }
}
