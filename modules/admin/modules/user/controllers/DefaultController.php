<?php

namespace admin\modules\user\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        //echo \Yii::t('user', 'test');
        return $this->render('index');
    }
}
