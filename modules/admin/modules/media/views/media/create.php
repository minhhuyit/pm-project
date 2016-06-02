<?php

use yii\helpers\Html;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = 'Create Post';
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
.upload_picture
    {
        padding: 2px 2px 2px 2px !important;
    }
</style>
    
<div class="post-create">

    

   <?php 
   echo FileInput::widget([
       'name' => 'file[]',
       'options' => ['multiple' => true, 'id' =>'file_upload'],
       'pluginOptions' => [
           'uploadUrl' => Yii::$app->adminModule->createAdminUrl(['media/create']),
         
           'maxFileCount' => 5
       ],
   ])
   ?>
</div>
<div id="contents" class="row show-grid upload_picture"></div>
<script>
$( document ).ready(function() {
$("#file_upload").fileinput({
}).on('filepreupload', function() {
}).on('fileuploaded', function(event, data) {
  //  alert(data.response.id);
  //  $( "#contents" ).load(data.response.id);
    $.ajax({ type: "GET",   
     url: data.response.id,   
     success : function(text)
     {
         $( "#contents" ).append(text);
     }
});
});
});
</script>
