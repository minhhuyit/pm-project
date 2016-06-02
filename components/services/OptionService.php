<?php


namespace app\components\services;

use Yii;
use app\models\Option;

/**
 * OptionService a service for option data
 *
 * @author ptu
 */
class OptionService extends BaseService {
    /**
     * Get an option
     * @param string $name option's name
     * @return mix option value, null if not exist
     */
    public function getOption($name)
    {
        $cacheValue=  $this->getFromCache($name);
        if($cacheValue===FALSE){
            $option=  Option::find()
                        ->where(['name'=>$name])
                        ->one();
            if(!$option){
                return null;
            }else{
                $value=unserialize($option->value);
                $this->cacheOption($name, $value);
                return $value;
            }
        }else{
            return $cacheValue;
        }
    }
    
    /**
     * Set and save option
     * @param string $name option's name
     * @param mix $value option's value, must be serializable
     */
    public function setOption($name, $value)
    {
        $option=  Option::find()
                    ->where(['name'=>$name])
                    ->one();
        if(!$option){
            $option=new Option();
            $option->name=$name;            
        }
        
        $option->value=  serialize($value);
        $option->save(false);
        $this->cacheOption($name, $value);        
    }
    
    /**
     * Get data from memory cache
     * @param string $name
     * @return mix value or FALSE if not exist
     */
    private function getFromCache($name)
    {
        $cacheKey='system_options';
        $options= Yii::$app->memoryCache->get($cacheKey);
        if($options===FALSE){
            return FALSE;
        }
        
        return isset($options[$name])?$options[$name]:FALSE;
    }
    
    /**
     * Save option to cache
     * @param string $name
     * @param mix $value
     */
    private function cacheOption($name, $value)
    {
        $cacheKey='system_options';
        $options= Yii::$app->memoryCache->get($cacheKey);
        if($options===FALSE){
            $options=[];
        }
        
        $options[$name]=$value;
        \Yii::$app->memoryCache->set($cacheKey, $options);
    }
}
