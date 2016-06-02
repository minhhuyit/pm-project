<?php

namespace admin\modules\post\models;

use yii\base\Model;

/**
 * PostSearch Model for search
 *
 * @author ptu
 */
class PostSearch extends Model {

    public $id;
    public $title;
    public $created_date;
    public $username;
    public $postType;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id'], 'integer'],
            [['title', 'created_date', 'username'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {

        if (!array_key_exists('type', $params)) {
            $this->postType = 'post';
        } else {
            $this->postType = $params['type'];
        }

        $this->load($params);

        return \Yii::$app->adminModule->postService->getPostDataProvider($this);
    }

}
