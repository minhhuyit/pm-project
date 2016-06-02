<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'language'=>require(__DIR__ . '/lang.php'),
    'bootstrap' => ['log', 'cms'],
    'modules' => [
        'admin' =>  'app\modules\admin\Module',   
        'login' => [
            'class' => 'app\modules\login\Module',
            'userClass' => '\app\models\User',
            'loginType' => 'email',
        ],
    ],
    'components' => [
        'request' => [
            'enableCookieValidation' => true,
            'enableCsrfValidation' => true,
            'cookieValidationKey' => ' ', 
        ],
        'memoryCache'=>[
            'class'=>'app\components\services\MemoryCacheService',
        ],
        'optionService'=>[
            'class'=>'app\components\services\OptionService',
        ],
        'settingService'=>[
            'class'=>'app\components\services\SettingService',
        ],
        'userService'=>[
            'class'=>'app\components\services\UserService',
        ],
        'postService'=>[
            'class'=>'app\components\services\PostService',
        ],
        'cms'=>[
            'class'=>'app\components\CmsComponent',
        ],
        'theme'=>[
            'class'=>'app\components\ThemeComponent',
        ],
        'post'=>[
            'class'=>'app\components\services\PostService'
        ],
        'taxonomy'=>[
            'class'=>'app\components\services\TaxonomyService'
        ],
        'eventBus'=>[
            'class'=>'app\components\EvenBusComponent'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'multilevelDropDown' => [
            'class' => 'app\components\MultilevelDropDownComponent',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl'=>['/login']
        ],
        'errorHandler' => [
            'errorAction' => 'main/error',
        ],
        'mailer' => require(__DIR__ . '/mail.php'),     
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        
        'i18n' => [
            'translations' => [
                'cms*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'cms' => 'cms.php',
                    ],
                ],
            ],
        ],
        
    ],
    'params' => $params,
];

$config=array_merge_recursive($config, require_once (__DIR__ . '/../modules/login/config/config.php'));

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
