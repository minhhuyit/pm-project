<?php

namespace admin\modules\post\components;

use admin\components\services\BaseAdminService;
use app\models\Post;
use Yii;
use yii\data\SqlDataProvider;
use yii\web\Controller;

/**
 * PostService post data service
 *
 * @author ptu
 */
class PostService extends BaseAdminService {

    /**
     * 
     * @param \admin\modules\post\models\PostSearch $postSearch
     * @return \yii\data\BaseDataProvider a dataprovider
     */
    public function getPostDataProvider($postSearch) {

        $condition = '1=1';

        $params = array();

        if ($postSearch->title) {
            $condition.=" and title like :title";
            $params[':title'] = '%' . $postSearch->title . '%';
        }

        if ($postSearch->username) {
            $condition.=" and username like :username";
            $params[':username'] = '%' . $postSearch->username . '%';
        }

        $condition.=' and type = :type';
        $condition.=' and status != :status';

        $params[':type'] = $postSearch->postType;
        $params[':status'] = 'trash';

        $sql = "select post.id, title, username, post.created_date as created_date"
                . " from post join user on user.id = post.author"
                . " where $condition";

        $count = Yii::$app->db->createCommand('select count(*) from (' . $sql . ') as posts', $params)->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'params' => $params,
            'totalCount' => $count,
            'key' => 'id',
            'sort' => [
                'attributes' => ['title']
            ],
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        return $dataProvider;
    }

    /**
     * Render all registered meta box
     *
     * @param $postType post type
     * @param Controller $controller the current controller
     * @param Post $post the post model
     * @param string $position Position of meta box, normal or side, default 'normal'
     */
    public function renderCustomMetaBoxs($postType, $controller, $post, $position='normal')
    {
        $metaBoxData= \Yii::$app->post->getFormMetaBoxData($postType);
        foreach ($metaBoxData as $name=>$metaBox) {
            if($metaBox['options']['position']===$position) {
                $renderCallback = $metaBox['renderCallback'];
                if ($renderCallback) {
                    $this->renderAMetaBox(
                        $name,
                        $metaBox['label'],
                        $renderCallback,
                        $controller, $post);
                }
            }
        }
    }

    /**
     * Called by renderCustomMetaBoxs
     *
     * @param $renderFunc
     * @param Controller $controller
     * @param Post $post
     */
    private function renderAMetaBox($name, $label, $renderFunc, $controller, $post)
    {
        echo '<div>';
        echo $renderFunc($controller, $post);
        echo '</div>';
    }
}
