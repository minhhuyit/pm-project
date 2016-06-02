<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel app\modules\admin\modules\post\models\PostSearch */

$postTypeTitle = ucfirst($searchModel->postType) . 's';

$this->title = $postTypeTitle;
//$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .summary{
        display:none;
    }
    .create-post-button
    {
        padding:5px;
    }
    .subsubsub {
        list-style: none;
        margin: 8px 0 0;
        padding: 0;
        font-size: 13px;
        color: #666;
        margin-top:30px;
        margin-bottom:10px;

    }

    .subsubsub li {
        display: inline-block;
        margin: 0;
        padding: 0;
        white-space: nowrap;
    }

    p.search-box {
        float: right;
        margin-top:-50px;
    }

    #search-submit
    {
        padding:5px;
    }
    #post-search-input{
        border: 1px solid #ddd;
        box-shadow: inset 0 1px 2px rgba(0,0,0,.07);
        height:30px;
    }
</style>


<div class="post-index">
    <h1><?= Html::encode($this->title) ?>  <?= Html::a('Add new', \Yii::$app->adminModule->createAdminUrl(['post']) . '/create?type=' . $searchModel['postType'], ['class' => 'btn btn-success create-post-button']) ?></h1>

    <ul class="subsubsub">
        <li class="all">All <span class="count">(<?= count($dataProvider) ?>)</span> |</li>
        <li class="publish">Published <span class="count">(<?= count($dataProvider) ?>)</span></a></li>
    </ul>

    <p class="search-box">
        <input type="search" id="post-search-input" name="s" value="">
        <input type="submit" id="search-submit" class="btn btn-danger" value="Search <?= $postTypeTitle ?>">
    </p>

    <?php Pjax::begin(); ?>

    <?php
    $form = ActiveForm::begin([
                'action' => 'post/bulk',
    ]);
    ?>
    <div id ="bulk-form">
        <select class="form-control" id="bulk_option" style="width: 200px;display: inline">
            <option value="0" selected="selected"><?php echo Yii::t('cms', 'Bulk Actions') ?></option>
            <option value="1"><?php echo Yii::t('cms', 'Delete') ?></option>
        </select>
        <input name="keylist" id="idcheck" type="hidden"/>
        <button type="submit" id="bulk" class="btn btn-info"><?php echo Yii::t('cms', 'Apply') ?></button>
    </div>
    <?php ActiveForm::end(); ?>
    <br/>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'gridview-post',
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn',
                'contentOptions' => ['style' => 'width: 10px;']
            ],
            [
                'attribute' => 'title',
            ],
            [
                'label' => 'Author',
                'attribute' => 'username',
                'contentOptions' => ['style' => 'width: 300px;']
            ],
            [
                'label' => 'Date',
                'value' => function ($searchModel) {
                    return 'Published ' . date('Y/m/d', strtotime($searchModel['created_date']));
                },
                'contentOptions' => ['style' => 'width: 100px;']
            ],
            ['class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width: 100px;'],
                'template' => '{view} {update} {trash}  {delete}',
                'buttons' => [
                    'trash' => function ($url) {
                        return Html::a(
                                        '<span class="glyphicon glyphicon-remove-sign"></span>', $url, [
                                    'title' => 'Trash',
                                    'data-pjax' => '0',
                                    'aria-label' => "Trash",
                                        ]
                        );
                    },
                        ],
                    ]
                ],
            ]);
            ?>


            <?php
            $form = ActiveForm::begin([
                        'action' => 'post/bulk',
            ]);
            ?>
            <div id ="bulk-form" style="margin-bottom:50px;">
                <select class="form-control" id="bulk_option2" style="width: 200px;display: inline">
                    <option value="0" selected="selected"><?php echo Yii::t('cms', 'Bulk Actions') ?></option>
                    <option value="1"><?php echo Yii::t('cms', 'Delete') ?></option>
                </select>
                <input name="keylist" id="idcheck2" type="hidden"/>
                <button type="submit" id="bulk2" class="btn btn-info"><?php echo Yii::t('cms', 'Apply') ?></button>
            </div>
            <?php ActiveForm::end(); ?>

            <?php Pjax::end(); ?>

    <script type="text/javascript">
        $(function () {
            $('#bulk').click(function () {
                var keys = $('#gridview-post').yiiGridView('getSelectedRows');
                var key_option = $('#bulk_option option:selected').val();
                if (key_option == 1) {
                    $('#idcheck').val(keys);
                }

            });
            $('#bulk2').click(function () {
                var keys = $('#gridview-post').yiiGridView('getSelectedRows');
                var key_option = $('#bulk_option2 option:selected').val();
                if (key_option == 1) {
                    $('#idcheck2').val(keys);
                }

            });
        });
    </script>

</div>
