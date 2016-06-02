<?php

namespace admin\controllers;

use yii\web\Controller;

class DefaultController extends \admin\components\BaseAdminController
{
    public function actionIndex()
    {
        //var_dump(\Yii::$app->adminModule->adminMenu->getMenuData());
        return $this->render('index');
    }
}
