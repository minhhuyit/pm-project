<?php

namespace admin\modules\setting\controllers;
;
use app\components\services\SettingService;
use app\components\OptionName;

class SettinggeneralController extends \admin\components\BaseAdminController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSave($site_title, $date_format, $time_format, $language)
    {
        $data = [
            OptionName::SITE_TITLE=>$site_title,
            OptionName::DATE_FORMAT=>$date_format,
            OptionName::TIME_FORMAT=>$time_format,
            OptionName::LANGUAGE=>$language
        ];
        $saveSetting = new SettingService;
        $saveSetting->saveSettings($data);
    }

    public function actionFormatdatetime($data)
    {
         return date($data);
    }
}
