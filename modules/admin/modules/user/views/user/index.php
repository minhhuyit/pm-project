<style>
    .summary{
        text-align: right;
    }
    .bulk_action{
        position: absolute;
        /*clear: both;*/
    }
</style>
<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
<?php Pjax::begin();?>
    <div class="row">
        <div class="col-xs-6 col-md-10" style="min-width: 330px">
            <div class="row">
                <div class="col-xs-1 col-md-3" style="width: 80px">
                    <?=Html::a('<i class="fa fa-fw fa-plus"></i>', ['create'], ['class' => 'btn btn-success']) ?>
                </div>
                <div class="col-xs-4 col-md-3" style="min-width: 160px">
                    <?php $form = ActiveForm::begin([
                        'action'=>'user/bulk',
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
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id'=>'gridview-user',
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            [
                'attribute'=>'username',
                'format' => 'raw',
                'value'=>function ($data) {
                    return Html::a(Html::encode($data['username'])
                            ,Url::toRoute(['user/update','id'=> $data['id']])
                            ,['title'=>  Yii::t('cms', 'Edit')]);
                },
            ],
            [
                'attribute' => 'role',
                'value' => function($model) {
                        return Yii::$app->userService->getMeta($model["id"], 'role');
                },
            ],
            'email',
            'display_name',
            
        ],
    ]); ?>
<?php Pjax::end();?>

</div>
<script type="text/javascript">
    $(function(){
    $('#bulk').click(function(){
        var keys = $('#gridview-user').yiiGridView('getSelectedRows');
        var key_option = $('#bulk_option option:selected').val();
        if(key_option==1){
            $('#idcheck').val(keys);
        }
        
    });
    });
</script>
