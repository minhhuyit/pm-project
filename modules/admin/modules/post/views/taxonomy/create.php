<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $taxonomyOption array contain information of taxonomy (main, add_title, edit_title) */
/* @var $taxonomyType string type of taxonomy */
/* @var $termModel app\models\Term */
/* @var $termTaxonomyModel app\models\TermTaxonomy */

$this->title = $taxonomyOption['labels']['add_title'];
?>
<div class="term-taxonomy-create">

    <h4><?= Html::encode($this->title) ?></h4>
    <br>
    <?= $this->render('_form', [
        'termTaxonomyModel' => $termTaxonomyModel,
        'termModel' => $termModel,
        'taxonomyOption' => $taxonomyOption,
        'taxonomyType' => $taxonomyType,
    ]) ?>

</div>
