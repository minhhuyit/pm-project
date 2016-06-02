<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .summary{
        text-align: right;
    }
    .bulk_action{
        position: absolute;
    }
</style>
<div class="post-index">

    <div class="row">
        <div class="col-xs-6 col-md-10" style="min-width: 330px">
            <div class="row">
                <div class="col-xs-3 col-md-3" style="width: 170px">
                    <?=Html::a('<i class="fa fa-fw fa-th-list"></i>',['','view'=>'grid'],['class'=>'btn btn-success'])?>
                    <?=Html::a( '<i class="fa fa-fw fa-th-large"></i>',['','view'=>'list'],['class'=>'btn btn-success'])?>
                    <?=Html::a('<i class="fa fa-fw fa-plus"></i>', ['create'], ['class' => 'btn btn-success']) ?>
                </div>
                <div class="col-xs-4 col-md-3" style="min-width: 160px">
                    <?php $form = ActiveForm::begin([
                        'action'=>'media/bulk',
                    ]); ?>

                    <div class="form-group input-group">

                        <select class="form-control" id="bulk_option" class="form-control">
                            <option value="0" selected="selected"><?php echo Yii::t('user', 'Bulk Actions')?></option>
                            <option value="1"><?php echo Yii::t('user', 'Delete')?></option>
                        </select>
                        <span class="input-group-btn">
                            <button type="submit" id="bulk" class="btn btn-success"><?php echo Yii::t('user', 'Apply')?></button>
                            <input name="keylist" id="idcheck" type="hidden"/>
                        </span>
                    </div>


                    <?php ActiveForm::end(); ?>
                </div>
            </div>

        </div>



        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
     </div>

    <?php if ($dataProvider->totalCount == 0) {?>
        <br>
    <?php }?>
    <?php if($view=='grid'){
        echo Yii::$app->controller->renderPartial('gridview',['dataProvider'=>$dataProvider]);}
    else{
        echo Yii::$app->controller->renderPartial('listview',['dataProvider' => $dataProvider]);}?>
</div>
<script type="text/javascript">
    $(function () {
        $('#bulk').click(function () {
            var keys = $('#gridview-media').yiiGridView('getSelectedRows');
            var key_option = $('#bulk_option option:selected').val();
            if (key_option == 1) {
                $('#idcheck').val(keys);
            }

        });
    });
</script>
