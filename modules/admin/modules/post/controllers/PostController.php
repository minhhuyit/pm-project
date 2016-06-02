<?php

namespace admin\modules\post\controllers;

use Yii;
use app\models\Post;
use \admin\modules\post\models\PostSearch;
use yii\web\NotFoundHttpException;
use admin\components\BaseAdminController;
use app\components\EventName;
use app\components\events\PostEvent;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends BaseAdminController {

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $postType = Yii::$app->getRequest()->getQueryParam('type');

        if (!$postType) {
            $postType = 'post';
        }

        $model = new Post();

        if ($model->load(Yii::$app->request->post())) {
            if ($this->savePostData($model)) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
                    'model' => $model,
                    'postType' => $postType
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($this->savePostData($model)) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
                    'model' => $model,
                    'postType' => $model->type
        ]);
    }

    private function savePostData($model) {
        $model->validate();

        $event = new PostEvent();
        $event->postModel = $model;
        Yii::$app->eventBus->trigger(EventName::VALIDATE_POST, $event);

        if (!$model->hasErrors()) {
            $model->save(false);

            $event = new PostEvent();
            $event->postModel = $model;
            Yii::$app->eventBus->trigger(EventName::SAVED_POST, $event);

            return true;
        } else {
            $this->setErrorFlash($model);
        }

        return false;
    }

    private function setErrorFlash($model) {
        $error = $model->getErrors();
        foreach ($error as $key => $errormsg) {
            if ($key != 'name') {
                \Yii::$app->getSession()->setFlash($key, $errormsg[0]);
            }
        }
    }

    public function actionDeletebulk() {
        if ($_POST['keylist']) {
            $list = $_POST['keylist'];
            $listId = explode(',', $list);
            foreach ($listId as $id) {
                $this->actionDelete($id);
            }
        }
    }

    public function actionBulk() {
        $this->actionDeletebulk();
        $this->redirect(['index']);
    }

    public function actionTrash($id) {
        $model = $this->findModel($id);
        if ($model) {
            $model->status = 'trash';
            $model->save(false);
        }
        $this->redirect(['index']);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Post::findOne($id)) !== null) {

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
