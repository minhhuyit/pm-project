<?php
namespace admin\components;

use app\components\EventName;

/**
 * CmsAdminComponent Main component for admin module
 *
 * @author ptu
 */
class CmsAdminComponent extends BaseAdminComponent {
    
    public function init() {
        parent::init();
        
        //create admin menu data
        \Yii::$app->adminModule->adminMenu->createMenuData();
        
        
        //trigger event
        \Yii::$app->eventBus->trigger(EventName::INIT_ADMIN);
    }
}
