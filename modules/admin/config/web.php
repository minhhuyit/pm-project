<?php

$config= [
    'bootstrap' => ['cmsAdmin'],
    'modules'=>[
        'theme' =>  'admin\modules\theme\Module',
        'post' =>  'admin\modules\post\Module', 
        'user' => 'admin\modules\user\Module',
        'setting' => 'admin\modules\setting\Module',
        'media' => 'admin\modules\media\Module',
    ],
    'components' => [
        'cmsAdmin'=>[
            'class'=>'admin\components\CmsAdminComponent'
        ],
        'adminMenu'=>[
            'class'=>'admin\components\AdminMenuComponent'
        ],
        'postService'=>[
            'class'=>'admin\modules\post\components\PostService'
        ],
        'mediaService'=>[
            'class'=>'admin\modules\media\components\MediaService'
        ],
        'userService'=>[
            'class'=>'admin\modules\user\components\UserService'
        ],
        'urlManager' => [
            'class'=>'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'admin/user/<action:\w*>'=>'admin/user/user/<action>',
                'admin/user' => 'admin/user/user',
                'admin/media/<action:\w*>'=>'admin/media/media/<action>',
                'admin/media' => 'admin/media/media',
                'admin/theme'=>'admin/theme/theme',
                'admin/post/taxonomy'=>'admin/post/taxonomy',
                'admin/post'=>'admin/post/post',
                'admin/post/<action:\w*>'=>'admin/post/post/<action>',
                'admin/setting'=>'admin/setting/setting',   
                'admin/settinggeneral'=>'admin/setting/settinggeneral',
                'admin/settingpermalink'=>'admin/setting/permalink'
            ],
        ],
    ],
    'params' => [
        
    ],
];

//merge with other modules's config if need

return $config;

