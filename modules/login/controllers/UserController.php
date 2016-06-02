<?php

namespace app\modules\login\controllers;

use Yii;
use app\modules\login\models\LoginForm;
use app\modules\login\models\ResetPasswordForm;

class UserController extends \yii\web\Controller {

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionLogin() {

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    public function actionResetPassword() {
        $model = new ResetPasswordForm();

        if ($model->load(Yii::$app->request->post()) && !$model->resetPassword()) {
            return $this->goBack();
        }

        return $this->render('reset-password', [
                    'model' => $model,
        ]);
    }

}
