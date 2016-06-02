<?php

namespace app\components\services;

use app\models\Postmeta;
use yii\helpers\ArrayHelper;
/**
 * PostService a service for post data
 *
 * @author ptu
 */
class PostService extends BaseService {

    /**
     * Contain all post types defined in system, struct:
     * [
     *      'postType'=>[
     *          //all post type config
     *      ]
     * ]
     * 
     * @var array 
     */
    private $postTypeData=[];

    /**
     * Form post's meta box data, struct:
     * [
     *      'postType'=>[
     *          'metaBoxName'=>[
     *              //all meta box config
     *          ]
     *      ]
     * ]
     * @var array
     */
    private $formMetaBoxData=[];

    /**
     * Contain highest order of meta box for each post type, struct:
     * [
     *      'postType'=>highest order value, default is 0
     * ]
     *
     * @var array
     */
    private $formMetaBoxHighestOrder=[];

    /**
     * Register new post type
     * 
     * @param string $postType
     * @param array $options options for post type, include:
     * - labels: array, include: 
     *      - main: Label of post type, default is Post,
     *      - add: Label for Add New menu, default is Add New
     *      - list: Label for list post menu, defaul is All Posts
     *      - add_title: Head label in add form, default is 'Add New Post'
     *      - edit_title: Head label in edit form, default is 'Edit Post'
     * - showOnMenu: bool, show on admin menu or not, default true
     * - menuPosition: int, position on admin menu, only used when showOnMenu=true, default 10 
     */
    public function registerPostType($postType, $options=[])
    {
        $defaultOptions=[
            'labels'=>[
                'main'=>  \Yii::t('cms', 'Post'),
                'add'=>  \Yii::t('cms', 'Add New'),
                'list'=>  \Yii::t('cms', 'All Posts'),
                'add_title'=>  \Yii::t('cms', 'Add New Post'),
                'edit_title'=>  \Yii::t('cms', 'Edit Post')
            ],
            'showOnMenu'=>true,
            'menuPosition'=>10
        ];
        
        $postOptions=ArrayHelper::merge($defaultOptions, $options);
        $this->postTypeData[$postType]=$postOptions;
    }
    
    public function getPostTypeData()
    {
        return $this->postTypeData;
    }
    
    /**
     * Check if have post type defined in system
     * 
     * @param string $postType post type
     * @return bool
     */
    public function hasDefinePostType($postType)
    {
        return isset($this->postTypeData[$postType]);
    }
    
    /**
     * Get config of a post type.
     * Note that you must check post type exist before by call hasDefinePostType()
     * 
     * @param string $postType post type
     * @return array
     */
    public function getPostType($postType)
    {
        return $this->postTypeData[$postType];
    }
    
    /**
     * Get post type's labels config
     * 
     * @param string $postType
     * @return array, include:
     *  - main: Label of post type, default is Post,
     *  - add: Label for Add New menu, default is Add New
     *  - list: Label for list post menu, defaul is All Posts
     *  - add_title: Head label in add form, default is 'Add New Post'
     *  - edit_title: Head label in edit form, default is 'Edit Post'
     */
    public function getPostTypeLabels($postType)
    {
        return $this->postTypeData[$postType]['labels'];
    }

    /**
     * Register a post form meta box, this meta box will be render when render post form
     *
     * @param string $name meta box name
     * @param string $label meta box label
     * @param string $postType meta box for which post type
     * @param callable $renderCallback the callback that will be called when render box, it has params:
     * - $controller : a current Controller object
     * - $post: a app\models\Post object
     * @param array $options array, include:
     * - position: string, 'normal' or 'side', default is normal
     * - order: order in post form, default will get the current highest order plus 1
     */
    public function registerFormMetaBox($name, $label, $postType, $renderCallback, $options=[])
    {
        $highestOrder=$this->getHighestOrderOfMetaBox($postType);
        $defaultOptions=[
            'position'=>'normal',
            'order'=>$highestOrder+1
        ];

        $boxOptions=ArrayHelper::merge($defaultOptions, $options);

        if(!isset($this->formMetaBoxData[$postType])){
            $this->formMetaBoxData[$postType]=[];
        }

        $this->formMetaBoxData[$postType][$name]=[
            'label'=>$label,
            'renderCallback'=>$renderCallback,
            'options'=>$boxOptions
        ];

        if($boxOptions['order']>$highestOrder){
            $this->formMetaBoxHighestOrder[$postType]=$boxOptions['order'];
        }
    }

    /**
     * Get form meta box data of a post type
     *
     * @param string $postType the post type
     * @return array meta box data with order, include:
     * - name=>[
     *      label,
     *      renderCallback,
     *      options=>[
     *          position,
     *          order
     *      ]
     * ]
     */
    public function getFormMetaBoxData($postType)
    {
        $data=[];
        if(isset($this->formMetaBoxData[$postType])){
            $data=$this->formMetaBoxData[$postType];
        }

        if(count($data)>1){
            uasort($data, function($item1, $item2){
                if($item1['options']['order']<$item2['options']['order']){
                    return -1;
                }

                return 1;
            });
        }

        return $data;
    }

    /**
     * Get the current highest order of meta boxs of a post type.
     * Should call this function to assign the order value of registered form post's meta box
     *
     * @param string $postType
     * @return int the highest order
     */
    public function getHighestOrderOfMetaBox($postType)
    {
        if(!isset($this->formMetaBoxHighestOrder[$postType])){
            $this->formMetaBoxHighestOrder[$postType]=0;
        }

        return $this->formMetaBoxHighestOrder[$postType];
    }

    /**
     * @param $postModel
     * @param $metas
     * @return bool
     */
    public function savePostData($postModel, $metas)
    {
        if($postModel->save(false)){
            foreach($metas as $metaKey=>$metaValue){
                $this->setMeta($postModel->id, $metaKey, $metaValue);
            }
            return true;
        }

        return false;
    }

    /**
     * @param $postId
     * @param $name
     * @param $value
     * @param bool $shoudCache
     */
    public function setMeta($postId, $name, $value, $shoudCache=false)
    {
        $meta= Postmeta::find()
            ->where(['post_id'=>$postId, 'meta_key'=>$name])
            ->one();
        if(!$meta){
            $meta=new Postmeta();
            $meta->meta_key=$name;
            $meta->post_id=$postId;
        }

        $meta->meta_value=  serialize($value);
        $meta->save(false);
        if($shoudCache){
            $this->cacheOption($postId, $name, $value);
        }
    }

    private function cacheOption($postId, $name, $value)
    {
        $cacheKey='post_metas';
        $options= Yii::$app->memoryCache->get($cacheKey);
        if($options===FALSE){
            $options=[];
        }

        if(!isset($options[$postId])){
            $options[$postId]=[];
        }

        $options[$postId][$name]=$value;
        \Yii::$app->memoryCache->set($cacheKey, $options);
    }

    public function getMetas($postId, $checkCache=false)
    {
        if(!$checkCache){
            $this->loadMetas($postId);
        }

        $cacheKey='post_metas';
        $options= Yii::$app->memoryCache->get($cacheKey);
        return $options[$postId];
    }


    public function loadMetas($postId)
    {
        $datas=(new Query())
            ->select(['meta_key', 'meta_value'])
            ->from('postmeta')
            ->where(['post_id'=>$postId])
            ->all();
        $result=[];
        foreach($datas as $item){
            $result[$item['meta_key']]=  unserialize($item['meta_value']);
        }
        $this->cacheAllPostOptions($postId, $result);
    }

    private function cacheAllPostOptions($postId, $datas)
    {
        $cacheKey='post_metas';
        $options= Yii::$app->memoryCache->get($cacheKey);
        if($options===FALSE){
            $options=[];
        }

        $options[$postId]=$datas;
        \Yii::$app->memoryCache->set($cacheKey, $options);
    }

    public function getMeta($postId, $name, $checkCache=false)
    {
        if($checkCache){
            $cacheValue=  $this->getPostMetaFromCache($postId, $name);
        }else{
            $cacheValue=false;
        }
        if($cacheValue===FALSE){
            $meta= Postmeta::find()
                ->where(['post_id'=>$postId, 'meta_key'=>$name])
                ->one();
            if(!$meta){
                return null;
            }else{
                $value=unserialize($meta->meta_value);
                if($checkCache){
                    $this->cacheOption($postId, $name, $value);
                }
                return $value;
            }
        }else{
            return $cacheValue;
        }
    }

    private function getPostMetaFromCache($postId, $name)
    {
        $cacheKey='post_metas';
        $options= Yii::$app->memoryCache->get($cacheKey);
        if($options===FALSE){
            return FALSE;
        }

        if(!isset($options[$postId])){
            return FALSE;
        }

        return isset($options[$postId][$name])?$options[$postId][$name]:FALSE;
    }

}
