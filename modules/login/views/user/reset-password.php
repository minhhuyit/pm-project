<script src="http://code.jquery.com/jquery.js"></script>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Login */
/* @var $form ActiveForm */
$this->title = 'Reset password';
$this->params['breadcrumbs'][] = $this->title;
?>


<?php if (Yii::$app->session->getFlash('status') == 'success'): ?>
    <script>
        $(function () {
            $('#myModal').modal('show');
        })
    </script>
<?php endif; ?>

<div id ="login-logo"><img src="http://co-mit.com/images/logo.png"></div>
<div id="user-login">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Reset password', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- user-login -->

<div class="container">
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><?= Yii::t('login', 'Notice') ?></h4>
                </div>
                <div class="modal-body">
                    <p><?= Yii::t('login', 'Your password has been sent to your email, please check your inbox!') ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="location.href = '<?= Yii::$app->homeUrl ?>login';" >Go back to login page</button>
                </div>
            </div>
        </div>
    </div>
</div>




