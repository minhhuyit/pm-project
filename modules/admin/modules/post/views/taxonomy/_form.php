<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Term;
use app\models\TermTaxonomy;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $taxonomyType string type of taxonomy */
/* @var $termModel app\models\Term */
/* @var $termTaxonomyModel app\models\TermTaxonomy */
/* @var $taxonomyOption array contain information of taxonomy (main, add_title, edit_title) */
?>

<div class="term-taxonomy-form">

    <?php $form = ActiveForm::begin([
        'action'=> 'taxonomy/create?type='.$taxonomyType,
        'id' => 'formCreateTaxonomy',
    ]); ?>

    <?= $form->field($termModel, 'name')->textInput(['maxlength' => true]) ?>
    <?= Yii::t('post', 'DES_NAME') ?>
    <p></p><br>
    
    <?= $form->field($termModel, 'slug')->textInput(['maxlength' => true]) ?>
    <?= Yii::t('post', 'DES_SLUG')?>
    <p></p><br>


    <?php if(Yii::$app->taxonomy->isTaxonomySupportHierarchical(Yii::$app->request->queryParams['type'])){
        Pjax::begin(['id' => 'selectedParentCategory']);
        $tuan = Yii::$app->taxonomy->listTermsOfTaxonomy('category');
        $cat = new Term();
        echo $form->field($termTaxonomyModel, 'parent')->dropDownList(

            Yii::$app->multilevelDropDown->makeDropDown(Term::find()->joinWith('parentTermOfCategory')->all(), '--',Term::className(), TermTaxonomy::className()),
            [
                'prompt'=>"Select",
            ]
        );
        echo Yii::t('post', 'DES_PARENT');
        echo '<p></p><br>';
        Pjax::end();
    }
    ?>

    <?= $form->field($termTaxonomyModel, 'description')->textarea(['rows' => 6]) ?>
    <?= Yii::t('post', 'DES_DESCRIPTION') ?>
    <p></p><br>

    <div class="form-group">
        <?= Html::submitButton($taxonomyOption['labels']['add_title'], ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$script = <<< JS
        $('form#formCreateTaxonomy').on('beforeSubmit', function(e)
        {
            var \$form = $(this);
            $.post(
                \$form.attr("action"),
                \$form.serialize()
            ).done(function(result){
                   if(result == 1)
                   {
                        $(\$form).trigger("reset");
                        //Reload gridview
                        $.pjax.reload({container: '#taxonomyGridId', async: false});
                        //Reload select parent category
                        $.pjax.reload({container: '#selectedParentCategory', async: false});
                   }
              }).fail(function()
              {
                console.log("Server error");
              });
             return false;
        });

JS;
$this->registerJs($script);
?>