<?php

namespace app\components;

/**
 * EventName define event constants
 *
 * @author ptu
 */
class EventName {
    
    /**
     * Event trigger when validate post before save, $event->data=['userModel'=>$model]
     */
    const VALIDATE_POST='cms_validate_post';
    
    /**
     * Event trigger after post data has saved, $event->data=['userModel'=>$model]
     */
    const SAVED_POST='cms_save_post';
    
    /**
     * Event trigger when admin is inited
     */
    const INIT_ADMIN='cms_init_admin';
}
