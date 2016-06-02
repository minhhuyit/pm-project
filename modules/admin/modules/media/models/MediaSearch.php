<?php
namespace admin\modules\media\models;

use yii\base\Model;

/**
 * PostSearch Model for search
 *
 * @author ptu
 */
class MediaSearch extends Model {

    public $title;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title'], 'string'],
        ];
    }
    public function search($params) {

        $this->load($params);
        
        $dataProvider = \Yii::$app->adminModule->mediaService->getPostDataProvider($this);

        return $dataProvider;
    }

}
