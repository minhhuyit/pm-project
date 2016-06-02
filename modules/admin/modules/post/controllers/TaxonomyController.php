<?php

namespace admin\modules\post\controllers;

use Yii;
use app\models\TermTaxonomy;
use app\models\Term;
use app\modules\admin\modules\post\models\TaxonomySearch;
use admin\components\BaseAdminController;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaxonomyController implements the CRUD actions for TermTaxonomy model.
 */
class TaxonomyController extends BaseAdminController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all TermTaxonomy models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaxonomySearch();

        $dataProvider = (new TaxonomySearch)->searchAllTermAndTermTaxonomyByType(Yii::$app->request->queryParams['type']);

        $taxonomyType = Yii::$app->request->queryParams['type'];
        $taxonomyOption = Yii::$app->taxonomy->getTaxonomyOption($taxonomyType);

        //Model for create
        $termTaxonomyModel = new TermTaxonomy();
        $termModel = new Term();


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'taxonomyOption' => $taxonomyOption,
            'taxonomyType' => $taxonomyType,
            'termTaxonomyModel' => $termTaxonomyModel,
            'termModel' => $termModel,
        ]);
    }

    /**
     * Displays a single TermTaxonomy model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     *
     * Creates a new TermTaxonomy model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $termModel = new Term();
        $termTaxonomyModel = new TermTaxonomy();
        //Type of taxonomy: category, tag
        $taxonomyType = Yii::$app->request->queryParams['type'];

        if ($termModel->load(Yii::$app->request->post())
                && $termTaxonomyModel->load(Yii::$app->request->post())) {

            //Save Term
            $termModel->save();

            //Check exits
            if($this->checkExistTag($termModel->name, $termModel->slug)){

            }
            //Save TermTaxonomy
            $termTaxonomyModel->term_id = $termModel->id;
            $termTaxonomyModel->taxonomy = $taxonomyType;
            //Set default for parent and count if empty
            if($termTaxonomyModel->parent == null || $termTaxonomyModel->parent == ""){
                $termTaxonomyModel->parent = 0;
            }
            if($termTaxonomyModel->count == null || $termTaxonomyModel->count == ""){
                $termTaxonomyModel->count = 0;
            }

            $termTaxonomyModel->save();

            return 1;
        } else {
            return $this->renderAjax('create', [
                'termModel' => $termModel,
                'termTaxonomyModel' => $termTaxonomyModel,
            ]);
        }
    }

    /**
     * Updates an existing TermTaxonomy model.
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

    /**
     * Deletes an existing TermTaxonomy model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TermTaxonomy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return TermTaxonomy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TermTaxonomy::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Check exits of tab by name and slug
     * @param $name
     * @param $slug
     * @return bool
     */
    private function checkExistTag($name, $slug){
        $exists = Term::find()->where(['name' => $name])->andWhere(['slug' => $slug])->exists();
        return $exists;
    }
}
