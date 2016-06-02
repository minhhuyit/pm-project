<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .upload_edit{
        float: right;
        padding: 10px 10px 5px 5px;
    }
    .upload_picture
    {
        padding: 2px 2px 2px 2px;
    }
</style>
<div class="col-sm-12 upload_picture">
    <?php
        $image = \Yii::$app->post->getMeta($model->id,'_attached_file');
        $image = \Yii::$app->adminModule->mediaService->getDisplayImage($image);
        echo Html::img(\Yii::$app->adminModule->mediaService->createMediaUrl($image),
        ['height' => '50px']);

    ?>
    <span>
        <?=$model->name?>
    </span>
    <div class='upload_edit'>
     <?= Html::a('Edit', ['update', 'id' => $model->id], ['class' => '']) ?>
    </div>
</div>