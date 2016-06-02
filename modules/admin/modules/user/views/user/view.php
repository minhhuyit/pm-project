<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\components\services\UserService;
/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->display_name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'attributes' => [
            'id',
            'username',
            'email:email',
            'display_name',
            'active_key',
            'created_date',
        ],
    ]) ?>

</div>
