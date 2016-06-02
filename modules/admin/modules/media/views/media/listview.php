<style xmlns="http://www.w3.org/1999/html">
    .item{
        display: inline;
        width: 200px;
        height:200px;
    }
    .image-item{
        width: 100px;
        height:100px;
        padding: 10px 10px 10px 0px ;
    }
    }
</style>
<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\bootstrap\Modal;
?>
    <?=ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            $img = \Yii::$app->adminModule->mediaService->getDisplayImage(unserialize($model['picture']));
            return Html::a( Html::img(\Yii::$app->adminModule->mediaService->createMediaUrl($img),['class'=>'image-item'])
                ,'#', [
                'class' => 'activity-view-link',
                'title' => Yii::t('yii', 'View'),
                'data-toggle' => 'modal',
                'data-target' => '#activity-modal',
                'data-id' => $key,
                'data-pjax' => '0',

            ]);
        },
    ]) ?>

    <?php Modal::begin([
        'id' => 'activity-modal',
        'header' => '<h2>View image</h2>',

    ]); ?>

    <?php Modal::end(); ?>

    <script type="text/javascript">
        $('.activity-view-link').click(function() {
            var id = $(this).attr("data-id");
            $.get(
                "view",
                {
                    'id':id
                },
                function (data) {
                    $('.modal-body').html(data);
                    $('#activity-modal').modal();
                }
            );
        });
        $(function(){
            $('.pagination').before('<br>');
        })
    </script>
