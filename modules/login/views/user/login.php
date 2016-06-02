<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Login */
/* @var $form ActiveForm */
$this->title = 'Login Panel';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id ="login-logo"><img src="http://co-mit.com/images/logo.png"></div>
<div id="user-login">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $module = Yii::$app->getModule('login');
    $loginType = $module->loginType;
    if ($loginType == 'email') : ?>    
        <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
    <?php elseif ($loginType == 'username'): ?>
        <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
    <?php endif ?>
    <?= $form->field($model, 'pass')->passwordInput() ?>
    <?= $form->field($model, 'rememberMe')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Login', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- user-login -->
<div id="lost-password"><a href="<?= Yii::$app->homeUrl ?>reset-password"><?= Yii::t('login', 'Lost your password?') ?></a></div>
