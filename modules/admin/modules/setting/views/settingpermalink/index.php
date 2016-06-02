<link rel="stylesheet" href="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/css/load-styles.css" type="text/css" media="all">
<?php
use app\components\OptionName;
use app\components\services\SettingService;
use yii\helpers\Html;
?>

<?php
$settingService = new SettingService();
$post_permalink = $settingService->getPermalink();
$pageUrl = Yii::$app->getUrlManager()->getHostInfo().Yii::$app->getUrlManager()->getBaseUrl();
?>
<div class="wrap">
    <div class="alert alert-success fade in" style="display:none;">
        <strong><?= Yii::t('setting','Settings have been successfully saved')?></strong>
    </div>
    <h1>
        <?= Yii::t('setting','Permalink Settings' ) ?>
    </h1>
    <table class="form-table permalink-structure">
    <tbody id="permalink"><tr>
        <th><label><input name="selection" type="radio" value="" <?=($post_permalink == '') ? 'checked' : ''?> > <?= Yii::t('setting','Plain')?></label></th>
        <td><code><?= $pageUrl.'/?=123' ?></code></td>
    </tr>
    <tr>
        <th><label><input name="selection" type="radio" value="/%year%/%monthnum%/%day%/%postname%/" <?=($post_permalink == '/%year%/%monthnum%/%day%/%postname%/') ? 'checked' : ''?> > <?= Yii::t('setting','Day and name')?></label></th>
        <td><code><?= $pageUrl.'/'.date('Y') .'/'. date('m') .'/'. date('d').'/sample-post/'?></code></td>
    </tr>
    <tr>
        <th><label><input name="selection" type="radio" value="/%year%/%monthnum%/%postname%/" <?=($post_permalink == '/%year%/%monthnum%/%postname%/') ? 'checked' : ''?> > <?= Yii::t('setting','Month and name')?></label></th>
        <td><code> <?= $pageUrl.'/'.date('Y').'/'.date('m').'/sample-post/' ?> </code></td>
    </tr>
    <tr>
        <th><label><input name="selection" type="radio" value="/archives/%post_id%" <?=($post_permalink == '/archives/%post_id%') ? 'checked' : ''?> > <?= Yii::t('setting','Numeric')?></label></th>
        <td><code> <?= $pageUrl.'/archives/123' ?> </code></td>
    </tr>
    <tr>
        <th><label><input name="selection" type="radio" value="/%postname%/" <?=($post_permalink == '/%postname%/') ? 'checked' : ''?> > <?= Yii::t('setting','Post name')?></label></th>
        <td><code><?= $pageUrl.'/sample-post' ?> </code></td>
    </tr>
    <tr>
        <th>
            <label><input name="selection" id="custom_selection" type="radio" value="custom" <?=($post_permalink != '' &&$post_permalink != '/%year%/%monthnum%/%day%/%postname%/' && $post_permalink != '/%year%/%monthnum%/%postname%/' && $post_permalink != '/archives/%post_id%' && $post_permalink != '/%postname%/') ? 'checked' : ''?> >
                <?= Yii::t('setting','Custom Structure')?></label>
        </th>
        <td>
            <code><?= $pageUrl?></code>
            <input name="permalink_structure" id="permalink_structure" type="text" value="<?= $post_permalink?>" class="regular-text code">
        </td>
    </tr>
    </tbody></table>
    <button type="submit" name="submit" id="btnSave" class="btn btn-primary"><?= Yii::t('setting','Save Changes')?></button>
</div>
<script>
        $(function(){
            var post_permalink = '<?= $post_permalink?>';

            $('#permalink input:not("#custom_selection")').click(function(){
                permalink_format = $(this).val();
                $('#permalink_structure').val(permalink_format);
            });

            $('#btnSave').click(function(){
                post_permalink = $('#permalink_structure').val();
                $.ajax({
                    url:'save',
                    type:'GET',
                    data:{
                        post_permalink: post_permalink
                    },
                    success:function(){
                        $(".alert").show();
                        $(".alert").delay(1000).slideUp(100, function() {
                            $(this).hide();
                        });
                    }
                })
            });
        });
</script>