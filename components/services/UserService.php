<?php

namespace app\components\services;
use Yii;
use app\models\Usermeta;
use yii\db\Query;
use app\components\KeyConstant;

/**
 * UserService
 *
 * @author ptu
 */
class UserService extends BaseService {
    /**
     * Get meta option
     * @param int $userId user id
     * @param string $name meta key
     * @param bool $checkCache Should check data from cache first, default false
     * @return mix option value, null if not exist
     */
    public function getMeta($userId, $name, $checkCache=false)
    {
        if($checkCache){
            $cacheValue=  $this->getUserMetaFromCache($userId, $name);
        }else{
            $cacheValue=false;
        }
        if($cacheValue===FALSE){
            $meta= Usermeta::find()
                        ->where(['user_id'=>$userId, 'meta_key'=>$name])
                        ->one();
            if(!$meta){
                return null;
            }else{
                $value=unserialize($meta->meta_value);
                if($checkCache){
                    $this->cacheOption($userId, $name, $value);
                }
                return $value;                 
            }
        }else{
            return $cacheValue;
        }
    }
    
    /**
     * Set and save meta data
     * @param int $userId user id
     * @param string $name meta key
     * @param mix $value meta value, must be serializable
     * @param bool $shouldCache should cache meta data
     */
    public function setMeta($userId, $name, $value, $shoudCache=false)
    {
        $meta= Usermeta::find()
                    ->where(['user_id'=>$userId, 'meta_key'=>$name])
                    ->one();
        if(!$meta){
            $meta=new Usermeta();
            $meta->meta_key=$name;      
            $meta->user_id=$userId;
        }
        
        $meta->meta_value=  serialize($value);
        $meta->save(false);
        if($shoudCache){
            $this->cacheOption($userId, $name, $value);        
        }
    }
    
    /**
     * Load all meta datas of user and cache loaded datas
     * Call this function to preload all meta datas to memory
     * 
     * @param int $userId user id
     */
    public function loadMetas($userId)
    {
        $datas=(new Query())
                ->select(['meta_key', 'meta_value'])
                ->from('usermeta')
                ->where(['user_id'=>$userId])
                ->all();
        $result=[];
        foreach($datas as $item){
            $result[$item['meta_key']]=  unserialize($item['meta_value']);
        }
        $this->cacheAllUserOptions($userId, $result);
    }
    
    /**
     * Get all user meta datas
     * @param int $userId user id
     * @param bool $checkCache check in cache or not, 
     * if true then datas will be load from memory cache, false then load from database.
     * If you pass $checkCache=true then you must call loadMetas() before somewhere
     * 
     * @return array array of meta_key=>meta_value
     */
    public function getMetas($userId, $checkCache=false)
    {
        if(!$checkCache){
            $this->loadMetas($userId);
        }
        
        $cacheKey='user_metas';
        $options= Yii::$app->memoryCache->get($cacheKey);
        return $options[$userId];
    }
    
    /**
     * Get all user roles
     * 
     * @return array User roles
     */
    public function getDefinedUserRoles()
    {
        return \Yii::$app->cms->getData(KeyConstant::USER_ROLES);
    }
    
    /**
     * Save user with it's meta datas
     * 
     * @param \app\models\User $userModel
     * @param array $metas array of meta_key=>meta_value
     * 
     * @return bool 
     */
    public function saveUserData($userModel, $metas)
    {
        if($userModel->save()){
            foreach($metas as $metaKey=>$metaValue){
                $this->setMeta($userModel->id, $metaKey, $metaValue);
            }
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Get user role
     * 
     * @param int $userId user id, if empty then get current login user id
     * @return string user role
     */
    public function getUserRole($userId='')
    {
        if($userId===''){
            $userId=  \Yii::$app->user->id;
        }
        
        return $this->getMeta($userId, 'role');
    }    

    /**
     * Get meta data from memory cache
     * @param int $userId user id
     * @param string $name user meta key
     * @return mix value or FALSE if not exist
     */
    private function getUserMetaFromCache($userId, $name)
    {
        $cacheKey='user_metas';
        $options= Yii::$app->memoryCache->get($cacheKey);
        if($options===FALSE){
            return FALSE;
        }
        
        if(!isset($options[$userId])){
            return FALSE;
        }
        
        return isset($options[$userId][$name])?$options[$userId][$name]:FALSE;
    }
    
    /**
     * Save meta data to cache
     * @param int $userId user id
     * @param string $name
     * @param mix $value
     */
    private function cacheOption($userId, $name, $value)
    {
        $cacheKey='user_metas';
        $options= Yii::$app->memoryCache->get($cacheKey);
        if($options===FALSE){
            $options=[];
        }
        
        if(!isset($options[$userId])){
            $options[$userId]=[];
        }
        
        $options[$userId][$name]=$value;
        \Yii::$app->memoryCache->set($cacheKey, $options);
    }
    
    /**
     * Cache all meta datas of user
     * 
     * @param int $userId user id
     * @param array $datas array meta_key=>meta_value
     */
    private function cacheAllUserOptions($userId, $datas)
    {
        $cacheKey='user_metas';
        $options= Yii::$app->memoryCache->get($cacheKey);
        if($options===FALSE){
            $options=[];
        }
        
        $options[$userId]=$datas;
        \Yii::$app->memoryCache->set($cacheKey, $options);
    }
    /**
     * Create data for Display Name dropdown
     * 
     * @param $model 
     * @return array $datas array list Display Name of user
     */
    public function getDisplayName($model)
    {
        $data[$model->display_name] = $model->display_name;
        $data[$model->username] = $model->username;
        $first_name = $this->getMeta($model->id,'first_name');
        $last_name = $this->getMeta($model->id,'last_name');
        
        if(isset($first_name)){
            $data[$first_name] = $first_name;
        }
        
        if(isset($last_name)){
            $data[$last_name] = $last_name;
        }
        
        if(isset($first_name) && isset($last_name)){
            $data[$first_name.' '.$last_name] = $first_name.' '.$last_name;
            $data[$last_name.' '.$first_name] = $last_name.' '.$first_name;
        }
        return $data;
    }
}
