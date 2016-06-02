<?php

use yii\widgets\ActiveForm;
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="col-xs-5 col-md-2">
        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
        ]); ?>
        <?= $form->field($model,'username')->textInput(['placeholder' => 'Search'])->label(false) ?>
        <?php ActiveForm::end(); ?>

    </div>
