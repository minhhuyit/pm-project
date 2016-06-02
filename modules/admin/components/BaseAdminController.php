<?php

namespace admin\components;

use yii\filters\AccessControl;
/**
 * BaseAdminController Base controller for all admin's controllers
 *
 * @author ptu
 */
class BaseAdminController extends \app\components\BaseController {
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                ],
            ]
        ];
    }
}
