<style>
    .image{
        width: 500px;
    }
    .modal-content{
        width:600px ;
        text-align: center;

    }
</style>
<?php
    echo \yii\helpers\Html::img(\Yii::$app->adminModule->mediaService->createMediaUrl($model->excerpt),['class'=>'image']);
?>
    <br>
    <label><?php echo Yii::t('media',"File Name".":")?></label><?php echo $model->name?>
