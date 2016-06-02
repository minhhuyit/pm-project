<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\modules\post\models\TaxonomySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $termModel app\models\Term */
/* @var $termTaxonomyModel app\models\TermTaxonomy */
/* @var $taxonomyType string type of taxonomy */
/* @var $taxonomyOption array contain information of taxonomy (main, add_title, edit_title) */
    
$this->title = $taxonomyOption['labels']['main'];
?>
<div class="term-taxonomy-index">

    <h1><?= Html::encode($this->title) ?></h1>
<!--    <div class="alert alert-danger" id="alertExistTaxonomy">-->
<!---->
<!--    </div>-->
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <?= $this->render('_search', ['model' => $searchModel])?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $this->render('create', [
                'termTaxonomyModel' => $termTaxonomyModel,
                'termModel' => $termModel,
                'taxonomyOption' => $taxonomyOption,
                'taxonomyType' => $taxonomyType,
            ])?>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-10">
                    <?php $form=ActiveForm::begin([
                        
                    ]);
                    ?>
                    <div id ="bulk-form-taxonomy">
                        <select class="form-control" id="bulk_option-taxonomy" style="width: 200px; display: inline">
                            <option value="0" selected="selected"><?php echo Yii::t('post', 'BULK_ACTION') ?></option>
                            <option value="1"><?php echo Yii::t('post', 'DELETE') ?></option>
                        </select>
                        <button type="submit" id="bulk-taxonomy" class="btn btn-default"><?php echo Yii::t('post', 'APPLY') ?></button>
                    </div>
                    <?php ActiveForm::end()?>
                </div>

            </div>
            <br>
            <?php Pjax::begin(['id'=>'taxonomyGridId']);?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                //No wrap-border
                'tableOptions' => ['class' => 'table'],
                'columns' => [
                    ['class' => 'yii\grid\CheckboxColumn'],
                    [
                        'attribute' => 'termsTermTaxonomy.name',
                        'value' => 'termsTermTaxonomy.name',
                    ],
                    'description:ntext',
                    [
                        'attribute' => 'termsTermTaxonomy.slug',
                        'value' => 'termsTermTaxonomy.slug',
                    ],
                    'count',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            <?php Pjax::end();?>
        </div>
    </div>
</div>
<?php