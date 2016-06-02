<?php

namespace admin\modules\setting\controllers;
;
use app\components\services\SettingService;
use app\components\OptionName;

class SettingController extends \admin\components\BaseAdminController
{
    public function actionIndex()
    {       
        return $this->render('index');
    }
    
    public function actionSave($type,$numPostsShow)
    {
        $data = [
            OptionName::FRONT_PAGE_DISPLAY=>$type,
            OptionName::NUM_POSTS_SHOW=>$numPostsShow
        ];
        $saveSetting = new SettingService;
        $saveSetting->saveSettings($data);
    }        
}
