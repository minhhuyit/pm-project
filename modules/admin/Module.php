<?php

namespace app\modules\admin;

use admin\components\AdminMenuComponent;
use admin\components\CmsAdminComponent;
use admin\modules\post\components\PostService;
use yii\helpers\Url;

/**
 * @property CmsAdminComponent $cmsAdmin main cms admin component
 * @property AdminMenuComponent $adminMenu component manage admin menu
 * @property PostService $postService Post data service
 */
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'admin\controllers';
    /**
     *
     * @var array bootstrap components 
     */
    public $bootstrap=[];

    public function init()
    {
        $this->layout='main';
        parent::init();
            
        \Yii::setAlias('@admin', '@app/modules/admin');
        \Yii::configure($this, require(__DIR__ . '/config/web.php'));    
        
        //config message source for admin
        $this->configMessageSource();
        
        //config message source for each sub-module
        $this->configSubmoduleMessageSource();
        
        //use this instead of call direct $this->bootstrapComponents() so admin's components can use admin's instance correctly
        $this->on(static::EVENT_BEFORE_ACTION, [$this, 'bootstrapComponents']);
    }
    
    public function bootstrapComponents()
    {
        foreach($this->bootstrap as $bootstrapComp){
            $this->$bootstrapComp;
        }
    }
    
    /**
     * 
     * @param array $relativeRoutes params like Url::to(), but route must be relative to admin
     * @return string url
     */
    public function createAdminUrl($relativeRoutes)
    {
        $relativeRoutes[0]="/admin/{$relativeRoutes[0]}";
        return Url::to($relativeRoutes);
    }
        
    private function configMessageSource()
    {
        \Yii::$app->i18n->translations["admin*"]=[
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => "@app/modules/admin/messages",
            'fileMap' => [
                "admin" => 'message.php',
            ],
        ];
    }
    
    /**
     * Each sub module must have messages folder and file message source must be name 'message.php'
     */
    private function configSubmoduleMessageSource()
    {
        foreach($this->modules as $moduleName=>$_){
            \Yii::$app->i18n->translations["$moduleName*"]=[
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => "@admin/modules/$moduleName/messages",
                'fileMap' => [
                    "$moduleName" => 'message.php',
                ],
            ];
        }
    }
}
