<?php
/**
 * Created by Cominit.
 * User: ptu
 * Date: 3/9/16
 * Time: 4:35 PM
 */

use admin\modules\post\components\widgets\PublishWidget;
use admin\modules\post\components\widgets\CategoriesWidget;

/* @var $model app\modules\admin\modules\post\models\PostSearch */
/* @var $postType: post or page */
?>
<div id="option-panel-container">

        <div class="option-widget">
            <?= PublishWidget::widget(['publishButton' => 'Publish', 'model' => $model]) ?>
</div>

<?php \Yii::$app->adminModule->postService->renderCustomMetaBoxs(
        $postType, \Yii::$app->controller, $model, 'side');
?>

<div class="option-widget">
    <?= CategoriesWidget::widget() ?>
</div>

</div>