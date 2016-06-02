<?php

namespace app\components;

use app\components\BaseComponent;

/**
 * CmsComponent main cms application
 *
 * @author ptu
 */
class CmsComponent extends BaseComponent {
    /**
     *
     * @var array global cms datas 
     */
    private $cmsDatas=[];
    
    public function init() {
        parent::init();
        
        //define cms's alias
        $this->defineAliases();
        
        //load admin url configs
        $this->loadAdminConfigUrl();
        
        //set cms user's default roles
        $this->setDefaultUserRoles();
        
        //define post types default
        $this->defineDefaultPostTypes();
        
        //define default taxonomy
        $this->defineDefaultTaxonomy();

        //load active theme
        $this->loadActiveTheme();
    }
    
    /**
     * Set cms global data
     * 
     * @param string $name
     * @param mix $value
     */
    public function setData($name, $value)
    {
        $this->cmsDatas[$name]=$value;
    }

    /**
     * Get cms global data
     * 
     * @param string $name
     * @return mix return data of name or FALSE if name not exist in global data
     */
    public function getData($name)
    {
        return isset($this->cmsDatas[$name])?$this->cmsDatas[$name]:FALSE;
    }

    /**
     * Main of CMS, call to start application and all magics
     */
    public function main()
    {
        $this->parseRequest();
        $this->query();
        $this->loadTheme();
    }
    
    /**
     * Parse request params and repair for query data
     */
    public function parseRequest()
    {
        
    }
    
    public function query()
    {
        
    }
    
    public function loadTheme()
    {
        
    }
    
    public function sendmail($email,$content,$layout,$subject){
        \Yii::$app->mailer->compose(['html' => $layout,], ['content' => $content])
                ->setFrom(\Yii::$app->params["fromEmail"])
                ->setTo($email)
                ->setSubject($subject)
                ->send();
    }
    
    private function setDefaultUserRoles()
    {
        $userRolesKey=  KeyConstant::USER_ROLES;
        $this->setData($userRolesKey, [
            'subscriber'=>\Yii::t('cms', 'Subscriber'),
            'contributer'=>  \Yii::t('cms', 'Constributer'),
            'editor'=>  \Yii::t('cms', 'Editor'),
            'administrator'=>  \Yii::t('cms', 'Administrator')
        ]);
    }
    
    private function loadAdminConfigUrl()
    {
        $configs=  require_once (\Yii::getAlias('@app/modules/admin/config/web.php'));
        $rules=$configs['components']['urlManager']['rules'];
        \Yii::$app->urlManager->addRules($rules);  
    }
    
    /**
     * Define cms's aliases
     */
    private function defineAliases()
    {
        \Yii::setAlias('@plugins', '@app/content/plugins');
        \Yii::setAlias('@themes', '@app/content/themes');
        \Yii::setAlias('@uploads', '@webroot/uploads');
    }
    
    private function defineDefaultPostTypes()
    {
        //register post
        \Yii::$app->post->registerPostType('post', [
            'menuPosition'=>1
        ]);
        
        //register media type
        \Yii::$app->post->registerPostType('media', [
            'showOnMenu'=>false
        ]);
        
        //register page
        \Yii::$app->post->registerPostType('page', [
            'labels'=>[
                'main'=>  \Yii::t('cms', 'Pages'),
                'add'=>  \Yii::t('cms', 'Add New'),
                'list'=>  \Yii::t('cms', 'All Pages'),
                'add_title'=>  \Yii::t('cms', 'Add New Page'),
                'edit_title'=>  \Yii::t('cms', 'Edit Page')
            ],
            'menuPosition'=>3
        ]);
    }
    
    private function defineDefaultTaxonomy()
    {
        //register category of post
        \Yii::$app->taxonomy->registerTaxonomy('category', 'post', [
            'labels'=>[
                'main'=>  \Yii::t('cms', 'Categories'),
                'add_title'=>  \Yii::t('cms', 'Add New Category'),
                'edit_title'=>  \Yii::t('cms', 'Edit Category')
            ],
            'hierarchicalSupport'=>true,
            'positionInMenu'=>1
        ]);
        
        //register tag of post
        \Yii::$app->taxonomy->registerTaxonomy('tag', 'post', [
            'labels'=>[
                'main'=>  \Yii::t('cms', 'Tags'),
                'add_title'=>  \Yii::t('cms', 'Add New Tag'),
                'edit_title'=>  \Yii::t('cms', 'Edit Tag')
            ],
            'hierarchicalSupport'=>false,
            'positionInMenu'=>2
        ]);
    }

    private function loadActiveTheme()
    {
        \Yii::$app->theme->loadTheme();
    }


}
