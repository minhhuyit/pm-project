<?php

namespace admin\components;

/**
 * AdminMenuComponent component for admin menu
 *
 * @author ptu
 */
class AdminMenuComponent extends BaseAdminComponent {
    
    private $menuData=[];

    /**
     * generate admin menu datas
     */
    public function createMenuData()
    {
        //create default datas
        $this->createDefaultDatas();
        
        //create data for post types
        $this->createPostTypeMenuDatas();
        
        //sort menu
        $this->orderMenus();
    }

    public function getMenuData()
    {
        return $this->menuData;
    }
    
    /**
     * Get all post type that has property showOnMenu=true
     * 
     * @return array array of post type datas
     */
    private function getVisiblePostTypeData()
    {
        $postTypes=  \Yii::$app->post->getPostTypeData();
        $result=[];
        foreach($postTypes as $name=>$postType){
            if($postType['showOnMenu']){
                $result[$name]=$postType;
            }
        }
        
        return $result;
    }
    
    private function createDefaultDatas()
    {
        $this->menuData=[
            'media'=>[
                'label'=>  \Yii::t('admin', 'Media'),
                'url'=>'#',
                'items'=>[
                    'library'=>[
                        'label'=>  \Yii::t('admin', 'Library'),
                        'url'=>\Yii::$app->adminModule->createAdminUrl(['media/index']),
                        'order'=>1
                    ],
                    'new'=>[
                        'label'=>  \Yii::t('admin', 'Add New'),
                        'url'=>\Yii::$app->adminModule->createAdminUrl(['media/create']),
                        'order'=>2
                    ],
                ],
                'order'=>2
            ],
            'appearance'=>[
                'label'=>  \Yii::t('admin', 'Appearance'),
                'url'=>'#',
                'items'=>[
                    'themes'=>[
                        'label'=>  \Yii::t('admin', 'Themes'),
                        'url'=>\Yii::$app->adminModule->createAdminUrl(['theme']),
                        'order'=>1
                    ],
                ],
                'order'=>100
            ],
            'users'=>[
                'label'=>  \Yii::t('admin', 'Users'),
                'url'=>'#',
                'items'=>[
                    'list'=>[
                        'label'=>  \Yii::t('admin', 'All Users'),
                        'url'=>\Yii::$app->adminModule->createAdminUrl(['user/index']),
                        'order'=>1
                    ],
                    'add'=>[
                        'label'=>  \Yii::t('admin', 'Add New'),
                        'url'=>\Yii::$app->adminModule->createAdminUrl(['user/create']),
                        'order'=>2
                    ],
                    'profile'=>[
                        'label'=>  \Yii::t('admin', 'Your Profile'),
                        'url'=>\Yii::$app->adminModule->createAdminUrl(['user/update','id'=>\Yii::$app->user->id]),
                        'order'=>3
                    ]
                ],
                'order'=>200
            ],
            'settings'=>[
                'label'=>  \Yii::t('admin', 'Settings'),
                'url'=>'#',
                'items'=>[
                    'general'=>[
                        'label'=>  \Yii::t('admin', 'General'),
                        'url'=>'#',
                        'order'=>1
                    ],
                    'reading'=>[
                        'label'=>  \Yii::t('admin', 'Reading'),
                        'url'=>'#',
                        'order'=>1
                    ],
                ],
                'order'=>500
            ],            
        ];
    }
    
    private function createPostTypeMenuDatas()
    {
        $postTypes= $this->getVisiblePostTypeData();
        foreach ($postTypes as $name=>$postType){
            $labels=\Yii::$app->post->getPostTypeLabels($name);
            $menuItem=[
                'label'=>  $labels['main'],
                'url'=>'#',
                'items'=>[
                    'list'=>[
                        'label'=>$labels['list'],
                        'url'=>\Yii::$app->adminModule->createAdminUrl(['post', 'type'=>$name]),
                        'order'=>1
                    ],
                    'add'=>[
                        'label'=>  $labels['add'],
                        'url'=>\Yii::$app->adminModule->createAdminUrl(['post/create', 'type'=>$name]),
                        'order'=>2
                    ]
                ],
                'order'=>$postType['menuPosition']
            ];
            
            if(\Yii::$app->taxonomy->hasTaxonomyOfPostType($name)){
                foreach(\Yii::$app->taxonomy->getTaxonomiesOfPostType($name) as $name=>$taxonomy){                    
                    $menuItem['items'][$name]=[
                        'label'=> $taxonomy['labels']['main'],
                        'url'=>  \Yii::$app->adminModule->createAdminUrl(['post/taxonomy', 'type'=>$name]),
                        'order'=>3+$taxonomy['positionInMenu']
                    ];
                }
            }
            
            $this->menuData[$name]=$menuItem;
        }
    }
    
    private function orderMenus()
    {
        $sortByOrderFunc=function($item1, $item2){
            if($item1['order']==$item2['order']){
                if($item1['label']<=$item2['label']){
                    return -1;
                }else{
                    return 1;
                }
            }else{
                return $item1['order']<$item2['order']?-1:1;
            }
        };
        
        uasort($this->menuData, $sortByOrderFunc);
        foreach($this->menuData as &$itemDatas){
            if(isset($itemDatas['items'])){
                uasort($itemDatas['items'], $sortByOrderFunc);
            }
        }
    }
}
