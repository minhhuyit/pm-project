
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form col-lg-6">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?php if(!$model->isNewRecord){?>
        <?= $form->field($model, 'display_name')->dropDownList($display_name) ?>
    <?php }?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($profile, 'first_name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($profile, 'last_name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($profile, 'role')->dropDownList(Yii::$app->userService->getDefinedUserRoles()) ?>
    
    <?= $form->field($model, 'pass')->textInput(['maxlength' => true]) ?>
    
    <?php if(!$model->isNewRecord){?>
        <?= $form->field($model, 'new_pass')->textInput() ?>
    <?php }?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('user', 'Create') : Yii::t('user', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
