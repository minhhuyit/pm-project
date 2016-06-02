<?php

namespace admin\modules\user;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'admin\modules\user\controllers';

    public function init()
    {
        $this->setLayoutPath( \Yii::getAlias('@app/module/admin/views/layouts/main '));
        parent::init();

        // custom initialization code goes here
    }
    }
