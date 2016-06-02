<?php


namespace app\components;

/**
 * EvenBusComponent Application bus event service
 *
 * @author ptu
 */
class EvenBusComponent extends BaseComponent {
    public function trigger($name, \yii\base\Event $event = null) 
    {
        parent::trigger($name, $event);
    }
    
    public function addHandler($name, $handler, $data=null, $append=true)
    {
        $this->on($name, $handler, $data, $append);
    }
}
