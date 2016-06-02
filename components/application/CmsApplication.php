<?php

namespace app\components\application;

/**
 * CmsApplication application for CMS
 *
 * @property \app\components\services\MemoryCacheService $memoryCache RAM cached
 * @property \app\components\services\OptionService $optionService Service for save and get options
 * @property \app\components\services\SettingService $settingService Service for save and get settings
 * @property \app\components\CmsComponent $cms CMS component
 * @property \app\components\ThemeComponent $theme Theme component
 * @property \app\components\EvenBusComponent $eventBus Application event bus
 * @property \app\components\services\UserService $userService User service
 * @property \app\modules\admin\Module $adminModule Admin module, this property only available in module admin
 * @property \app\components\services\PostService $post Post service
 * @property \app\components\services\TaxonomyService $taxonomy Taxonomy Service
 * @property \theme\Theme $loadedTheme Loaded theme
 * @property \app\components\MultilevelDropDownComponent $multilevelDropDown Theme component
 * 
 * @author ptu
 */
class CmsApplication extends \yii\web\Application {
    public function getAdminModule()
    {
        return $this->modules['admin'];
    }
}
