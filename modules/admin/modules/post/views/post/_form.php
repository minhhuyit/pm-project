<?php

use yii\widgets\ActiveForm;
use admin\modules\post\components\widgets\CustomFieldsWidget;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\modules\admin\modules\post\models\PostSearch */
/* @var $postType: post or page */
?>

<div class="post-form">

    <?php
    $form = ActiveForm::begin([
                'action' => (Yii::$app->controller->action->id == 'create' ? 'create' : 'update?id=' . $_GET['id'] ),
                'enableClientValidation' => false,
                'options' => [
                'id' => 'publish-post-form'
                ]
    ]);
    ?>

    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />

    <div class="form-group field-post-title" style="margin-bottom:50px;">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'id' => 'post-title', 'placeholder' => "Enter title here"])->label(false) ?>
    </div>


    <button type="button" id="insert-media-button" class="btn btn-info" style="margin-bottom:10px;padding:5px;"><span class="glyphicon glyphicon-film" style="color: #fff;"></span> Add Media</button>

    <div class="form-group field-post-content required">
        <?= $form->field($model, 'content')->textArea(['maxlength' => true, 'id' => 'post-content', ' rows' => "15"])->label(false) ?>
    </div>


    <!--  Hidden fields !-->

    <div style="display:none;">

        <div class="form-group field-post-excerpt" style="margin-bottom:50px;">
            <?= $form->field($model, 'excerpt')->textInput(['maxlength' => true, 'id' => 'post-excerpt', 'value' => 'test excerpt']) ?>
        </div>

        <div class="form-group field-post-author">
            <?= $form->field($model, 'author')->textInput(['maxlength' => true, 'id' => 'post-author', 'value' => '1']) ?>
        </div>

        <div class="form-group field-post-name">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'id' => 'post-name', 'value' => '']) ?>
        </div>

        <div class="form-group field-post-status">
            <?= $form->field($model, 'status')->textInput(['maxlength' => true, 'id' => 'post-status', 'value' => 'publish']) ?>
        </div>

        <div class="form-group field-post-type">
            <?= $form->field($model, 'type')->textInput(['maxlength' => true, 'id' => 'post-type', 'value' => $postType]) ?>
        </div>

        <div class="form-group field-post-mime_type">
            <?= $form->field($model, 'mime_type')->textInput(['maxlength' => true, 'id' => 'post-mime_type', 'value' => 'test mime type']) ?>
        </div>

        <div class="form-group field-post-parent">
            <?= $form->field($model, 'parent')->textInput(['maxlength' => true, 'id' => 'post-parent', 'value' => '0']) ?>
        </div>

        <div class="form-group field-post-created_date">
            <?= $form->field($model, 'created_date')->textInput(['maxlength' => true, 'id' => 'post-created_date', 'value' => '2016-03-02 00:00:00']) ?>
        </div>

        <div class="form-group field-post-modified_date">
            <?= $form->field($model, 'modified_date')->textInput(['maxlength' => true, 'id' => 'post-modified_date', 'value' => '2016-03-02 00:00:00']) ?>
        </div>

    </div>

    <!--  Hidden fields !-->

    <div class="form-group">
    </div>

    <?php \Yii::$app->adminModule->postService->renderCustomMetaBoxs(
            $postType, \Yii::$app->controller, $model)
    ?>

    <?php ActiveForm::end(); ?>

    <?= CustomFieldsWidget::widget() ?>


</div>


