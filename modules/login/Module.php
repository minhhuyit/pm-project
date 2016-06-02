<?php

namespace app\modules\login;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\login\controllers';
    public $userClass;
    public $loginType;

    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->configMessageSource();
    }
    
    private function configMessageSource()
    {
        \Yii::$app->i18n->translations["login*"]=[
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => "@app/modules/login/messages",
            //'sourceLanguage' => 'en-US',
            'fileMap' => [
                "login" => 'message.php',
            ],
        ];
    }
}
