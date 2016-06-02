<?php

namespace admin\modules\setting\controllers;
;
use app\components\services\SettingService;
use app\components\OptionName;

class SettingpermalinkController extends \admin\components\BaseAdminController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSave($post_permalink)
    {
        $data = [
            OptionName::POST_PERMALINK=>$post_permalink,
        ];
        $saveSetting = new SettingService;
        $saveSetting->saveSettings($data);
    }
}
