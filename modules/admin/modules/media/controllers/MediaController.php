<?php

namespace admin\modules\media\controllers;

use admin\components\BaseAdminController;
use app\models\Post;
use admin\modules\media\models\MediaSearch;
use Yii;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * MediaController implements the CRUD actions for Post model.
 */
class MediaController extends BaseAdminController
{


    /**
     * Lists all Post models.
     * @param string $view
     * @return mixed
     */
    public function actionIndex($view='grid')
    {
        $searchModel = new MediaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'view'=>$view,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * Displays a single Post model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderPartial('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    /**
     * Displays a single Post model.
     * @param string $id
     * @return mixed
     */
    public function actionUpload($id)
    {
        return $this->renderAjax('upload', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->request->post()) {

            Yii::$app->adminModule->mediaService->uploadMedia();

        } else {
            return $this->render('create');
        }

    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
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

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Exception
     */

    public function actionDelete($id)
    {
        $post = $this->findModel($id);
        Yii::$app->adminModule->mediaService->deleteMedia($post);
        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
