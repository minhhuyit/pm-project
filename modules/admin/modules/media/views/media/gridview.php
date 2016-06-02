<?php

use yii\helpers\Html;
use yii\grid\GridView;
?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'id'=>'gridview-media',
    'columns' => [
        ['class' => 'yii\grid\CheckboxColumn'],
        [
            'attribute' => 'title',
            'format' => 'html',
            'label' => 'File',
            'value' =>  function($data) {
                $img = \Yii::$app->adminModule->mediaService->getDisplayImage(unserialize($data['picture']));
                return "<span class='media-icon'>"
                .Html::img(\Yii::$app->adminModule->mediaService->createMediaUrl($img)
                    ,['height' => '50px', 'width' => '38px'])
                ."</span>"
                ."<span>".$data['title']."</span>"
                ."<br><span>".$data['name']."</span>"
                    ;
            },
        ],
        'author',
        'status',
        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>
