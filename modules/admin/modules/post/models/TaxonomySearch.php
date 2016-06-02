<?php

namespace app\modules\admin\modules\post\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TermTaxonomy;

/**
 * TaxonomySearch represents the model behind the search form about `app\models\TermTaxonomy`.
 */
class TaxonomySearch extends TermTaxonomy
{
    public $globalSearch;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'term_id', 'parent', 'count'], 'integer'],
            [['globalSearch', 'taxonomy', 'description'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'globalSearch' => Yii::t('cms', ''),
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TermTaxonomy::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

//        $query->andFilterWhere([
//            'id' => $this->id,
//            'term_id' => $this->term_id,
//            'parent' => $this->parent,
//            'count' => $this->count,
//        ]);

        $query->andFilterWhere(['like', 'taxonomy', $this->globalSearch])
            ->andFilterWhere(['like', 'description', $this->globalSearch]);

        return $dataProvider;
    }
    
    /**
     * Find all Term and TermTaxonomy tables
     * @param  $params
     * @return ActiveDataProvider
     */
    public function searchAllTermAndTermTaxonomyByType($params){
        $query = TermTaxonomy::find();
       
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
       
        $query->joinWith('termsTermTaxonomy');

        $taxonomyType = $params;

        $query->andFilterWhere(['like', 'taxonomy', $taxonomyType])->orderBy('term_id desc');

        return $dataProvider;
    }
}
