<?php

namespace admin\modules\theme\controllers;

class ThemeController extends \admin\components\BaseAdminController
{
    public $enableCsrfValidation = false;
    
    public function actionIndex()
    {       
        return $this->render('index');
    }

}
