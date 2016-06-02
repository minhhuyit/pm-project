<?php

namespace app\components\services;

/**
 * MemoryCacheService cache data in RAM,
 * used for cache frequently accessed datas, such as app options
 *
 * @author ptu
 */
class MemoryCacheService {
    private $data=[];
    
    public function set($key, $value)
    {
        $this->data[$key]=$value;
    }
    
    /**
     * Retrieve value
     * @param string $key
     * @return mix value of key or FALSE if not exist
     */
    public function get($key)
    {
        return isset($this->data[$key])?$this->data[$key]:false;
    }
}
