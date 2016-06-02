<?php

namespace admin\modules\user\controllers;

use admin\modules\user\models\UserSearch;
use Yii;
use app\models\User;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use admin\models\Profile;


/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends \admin\components\BaseAdminController
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $model->setScenario('create');
        $contentMail = 'Your new password: <b>' . $model->pass . '</b>';
        $profile = new Profile();
        if ($model->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post())) {
            
            $model->created_date = date(time());
            $model->display_name = $model->username;
            $model->pass = $model->generateHashPassword($model->pass);  
            
            if(Yii::$app->userService->saveUserData($model, $profile)){  
                
                Yii::$app->cms->sendmail($model->email,$contentMail,'@app/mail/layouts/html',"[Cominit CMS] Reset password");
               
                return $this->redirect(['index']);
            }
        } 
        else {
            return $this->render('create', [
                'model' => $model, 'profile' => $profile,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $profile = new Profile();
        $model = $this->findModel($id);
        $currentPassword=$model->pass;
        $model->pass='';
        $model->setScenario('update');
        
        if ($model->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post())) {  
            
            if($model->pass!='' && $model->generateHashPassword($model->pass)!=$currentPassword){
                $model->addError('pass','パスワードは正しくない');
            }
            else {
                if($model->pass==""){
                    $model->pass=$currentPassword;
                }
                else {
                    $model->pass=$model->generateHashPassword($model->new_pass);
                }
                if(Yii::$app->userService->saveUserData($model, $profile)){
                    
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            
        } else {
            
            $metas = Yii::$app->userService->getMetas($model->id);
            if($metas['first_name']){
                $profile->first_name = $metas['first_name'];
            }
            if($metas['last_name']){
                $profile->last_name = $metas['last_name'];
            }

            $profile->role = $metas['role'];  
        } 
        $display_name = Yii::$app->userService->getDisplayName($model); 
            return $this->render('update', [
                'model' => $model,
                'profile'=> $profile,
                'display_name'=>$display_name,
            ]);
        
    }
    public function actionDeletebulk() {
        if ($_POST['keylist']) {
            $list=$_POST['keylist'];
            $listId = explode( ',',$list );
            foreach ($listId as $id){
                $this->actionDelete($id);
            }
        }
    } 
    public function actionBulk(){
        $this->actionDeletebulk();
        $this->redirect(['index']);
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
