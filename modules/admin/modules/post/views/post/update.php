<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $postType: post or page */

$this->title = 'Update ' . $model->type . ': ' . ' ' . $model->title;

$errorValidate = Yii::$app->session->getAllFlashes();
$msgValidate = "";

if ($errorValidate) {

    foreach ($errorValidate as $key => $message) {
        $msgValidate.= $message . '<br/>';
        ?>
        <script>
            $(function () {
                $('#post-<?= $key ?>').css('border', '1px solid red');
            })
        </script>
        <?php
    }
    ?>
    <script>
        $(function () {
            $('#myModal').modal('show');
            setTimeout(function () {
                $("#myModal").modal('hide');
            }, 2000);
        })
    </script>
    <?php
}


//$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<script>

    $(document).ready(function () {
        $("#hidden_post_status").val('<?= $model->status ?>');
        $("#post_status_select").val('<?= $model->status ?>');
        $("#post_status_label").text($("#post_status_select option:selected").text());
    });

</script>


<script type="text/javascript" src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/js/post/tinymce/tinymce.min.js"></script>
<script>
        tinymce.init({
            selector: '#post-content',
            theme: 'modern',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools'
            ],
            toolbar1: 'insertfile undo redo | fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons',
        });
</script>


<style>
    .post-update
    {
        float:left;
        width:69%;
    }
    .option-column
    {

        float:right;
        width:28%;
    }
    a {
        cursor: pointer;
    }
    .option-widget{
        margin-bottom:30px;
    } 
    #option-panel-container
    {
        padding-top:65px;
    }
</style>

<div class="post-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <?php echo Yii::$app->controller->renderPartial('_form', array('model'=>$model, 'postType'=>$postType)); ?>

</div>

<div class="option-column">
    <?= Yii::$app->controller->renderPartial('_form_side_column', array('model'=>$model, 'postType'=>$postType)); ?>
</div>

<div class="container">
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header" style="background:red; color:white">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Alert</h4>
                </div>
                <div class="modal-body">
                    <p><?= $msgValidate ?></p>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
</div>


