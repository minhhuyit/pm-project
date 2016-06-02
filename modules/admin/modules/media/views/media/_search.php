<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-xs-5 col-md-2">

    <?php $view = isset($_GET["view"])?$_GET["view"]:'grid';?>
    <?php $form = ActiveForm::begin([
        'action' => ['index',['view' =>$view]],
        'method' => 'get',
    ]); ?>
    <?= $form->field($model, 'title')->textInput(['placeholder' => 'Search'])->label(false) ?>
    <?php ActiveForm::end(); ?>

</div>
