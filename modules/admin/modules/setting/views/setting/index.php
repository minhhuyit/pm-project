<link rel="stylesheet" href="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/css/load-styles.css" type="text/css" media="all">
<?php
use app\components\OptionName;
use app\components\services\SettingService;
use yii\helpers\Html;
?>

<?php 
    $settingService = new SettingService();
    $type = $settingService->getFrontPageDisplayType();
    $numPostShow = $settingService->getNumPostsShow();
?>
<div class="wrap">
    <div class="alert alert-success fade in" style="display:none;">
        <strong><?= Yii::t('setting','Settings have been successfully saved')?></strong>
    </div>
    <h1>
        <?= Yii::t('setting','Reading Settings' ) ?>
    </h1>
    <table class="form-table">
        <tr>
            <th scope="row"><?= Yii::t('setting','Front page displays' )?></th>
            <td id="front-static-pages"><fieldset><legend class="screen-reader-text"><span><?= Yii::t('setting','Front page displays' )?></span></legend>
                    <?php echo Html::radioList('frontpage', $type, array('posts'=>Yii::t('setting','Your latest posts' ),'page'=>Yii::t('setting','A static page (select below)' )),array('id'=>'type','class'=>'tog','separator'=>'<br>'))?>
                 
            <ul>
                <li><label for="page_on_front"><?= Yii::t('setting','Front page')?> :<select name="page_on_front" id="page_on_front"  <?php echo $type == 'page'?'':'disabled="true"' ?>>
                    <option value="0">— <?= Yii::t('setting','Select' )?> —</option>
                </select>
                </label></li>
                    <li><label for="page_for_posts"><?= Yii::t('setting','Posts page')?> :<select name="page_for_posts" id="page_for_posts"  <?php echo $type == 'page'?'':'disabled="true"' ?>>
                    <option value="0">— <?= Yii::t('setting','Select' )?> —</option>
                </select>
                </label></li>
            </ul>
            </fieldset></td>
        </tr>
        
        <tr>
            <th scope="row"><label for="posts_per_page"><?= Yii::t('setting','Blog pages show at most')?></label></th> 
            <td>
            <input name="posts_per_page" type="number" step="1" min="1" id="posts_per_page" value="<?php echo $numPostShow ?>" class="small-text"><?= Yii::t('setting','posts')?></td>
        </tr>
    </table>
    <button type="submit" name="submit" id="btnSave" class="btn btn-primary"><?= Yii::t('setting','Save Changes')?></button>
</div>
<script>
    $(function(){ 
        var type = '<?php echo $type ?>'
        $('#type input').click(function(){
            type = $(this).val()
            if(type=='page'){
                $('#page_on_front').prop("disabled", false);
                $('#page_for_posts').prop("disabled", false);
            } else {
                $('#page_on_front').prop("disabled", true);
                $('#page_for_posts').prop("disabled", true);
            }
        })

        $('#btnSave').click(function(){
              var numPostsShow =  $('#posts_per_page').val();
            $.ajax({
                url:'save',
                type:'GET',
                data:{
                    type:type,
                    numPostsShow:numPostsShow
                },
                success:function(){
                    $(".alert").show();
                    $(".alert").delay(1000).slideUp(100, function() {
                        $(this).hide();
                    });
                }                
            })
        })
    });
</script>