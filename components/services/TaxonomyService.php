<?php

namespace app\components\services;

use yii\helpers\ArrayHelper;

/**
 * TaxonomyService taxonomy and term service
 *
 * @author ptu
 */
class TaxonomyService extends BaseService {
    
    /**
     * Taxonomy data
     * @var array 
     */
    private $taxonomyData=[];
    
    private $taxonomyToPostType=[];
    
    /**
     * 
     * @param string $taxonomy taxonomy name
     * @param string $postType post type of taxonomy
     * @param array $options, include:
     * - labels: array, include:
     *      - main: main label, display in admin menu
     *      - add_title: head title in add form
     *      - edit_title: head title in edit form
     * - hierarchicalSupport: bool, default false
     * - positionInMenu: int, position in admin menu, default 1
     */
    public function registerTaxonomy($taxonomy, $postType, $options=[])
    {
        if(!isset($this->taxonomyData[$postType])){
            $this->taxonomyData[$postType]=[];
        }
        
        $dedaultOptions=[
            'labels'=>[
                'main'=>  \Yii::t('cms', 'Taxonomy'),
                'add_title'=>  \Yii::t('cms', 'Add Taxonomy'),
                'edit_title'=>  \Yii::t('cms', 'Edit Taxonomy')
            ],
            'hierarchicalSupport'=>false,
            'positionInMenu'=>1
        ];
        
        $taxonomyOptions=  ArrayHelper::merge($dedaultOptions, $options);
        $this->taxonomyData[$postType][$taxonomy]=$taxonomyOptions;
        $this->taxonomyToPostType[$taxonomy]=$postType;
    }
    
    public function getTaxonomyData()
    {
        return $this->taxonomyData;
    }
    
    /**
     * Get information option's taxonomy
     * @param type $taxonomy
     * @return array option
     */
    public function getTaxonomyOption($taxonomy){
        $postType=  $this->getPostTypeOfTaxonomy($taxonomy);
        if($postType){
            return $this->taxonomyData[$postType][$taxonomy];
        }
        
        return null;
    }
    /**
     * Check if a post type has taxanomy defined for it
     * 
     * @param string $postType post type
     * @return bool
     */
    public function hasTaxonomyOfPostType($postType)
    {
        return isset($this->taxonomyData[$postType]) 
                && count($this->taxonomyData[$postType]) > 0;
    }
    
    /**
     * Get taxonomies defined for the post type.
     * Note that you must check if the post type has taxonomies before by call hasTaxonomyOfPostType()
     * 
     * @param string $postType
     * @return array taxonomy datas of the post type
     */
    public function getTaxonomiesOfPostType($postType)
    {
        return $this->taxonomyData[$postType];
    }
    
    /**
     * Check if taxonomy has defined
     * 
     * @param string $taxonomy 
     * @return bool
     */
    public function hasTaxonomy($taxonomy)
    {
        return isset($this->taxonomyToPostType[$taxonomy]);
    }
    
    /**
     * Get post type of defined taxonomy.
     * Note that you should check if taxonomy has been defined in system by call hasTaxonomy
     * 
     * @param string $taxonomy
     * @return string post type
     */
    public function getPostTypeOfTaxonomy($taxonomy)
    {
        return $this->taxonomyToPostType[$taxonomy];
    }
    
    /**
     * Check if taxonomy support hierarchical
     * 
     * @param string $taxonomy
     * @return boolean
     */
    public function isTaxonomySupportHierarchical($taxonomy)
    {
        $postType=  $this->getPostTypeOfTaxonomy($taxonomy);
        
        if($postType){
            $data=  $this->taxonomyData[$postType][$taxonomy];
            return isset($data['hierarchicalSupport']) && $data['hierarchicalSupport'];
        }
        
        return false;
    }
    
    /**
     * List all term of taxonomy with hierarchical struct
     * 
     * @param string $taxonomy
     * @return array
     */
    public function listTermsOfTaxonomy($taxonomy)
    {
        $sql='select term.*, tt.description, tt.parent, tt.count from term '
                . 'inner join term_taxonomy tt on term.id=tt.term_id '
                . 'where tt.taxonomy=:taxonomy';
        $data=  \Yii::$app->db
                ->createCommand($sql, [':taxonomy'=>$taxonomy])
                ->queryAll();
        
        $idToItem=[];        
        foreach($data as $i=>$item){
            $idToItem[$item['id']]=&$data[$i];
        }
        
        $results=[];
        foreach($data as $i=>$item){
            if($item['parent']){
                $parent=&$idToItem[$item['parent']];
                if(!isset($parent['childs'])){
                    $parent['childs']=[];                    
                }
                $parent['childs'][]=&$data[$i];
            }else{
                $results[]=&$data[$i];
            }
        }
                
        return $results;
    }
}
