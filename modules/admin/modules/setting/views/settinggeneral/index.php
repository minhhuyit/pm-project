<link rel="stylesheet" href="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/css/load-styles.css" type="text/css" media="all">
<?php
use app\components\OptionName;
use app\components\services\SettingService;
use yii\helpers\Html;
?>

<?php
$settingService = new SettingService();
$site_title = $settingService->getSiteTitle();
$date_format = $settingService->getDateFormat();
$time_format = $settingService->getTimeFormat();
$language = $settingService->getLanguage();
?>
<div class="wrap">
    <div class="alert alert-success fade in" style="display:none;">
        <strong><?= Yii::t('setting','Settings have been successfully saved')?></strong>
    </div>
    <h1>
        <?= Yii::t('setting','General Settings' ) ?>
    </h1>
    <table class="form-table">
        <tr>
            <th scope="row"><?= Yii::t('setting','Site Title' )?></th>
            <td>
                <input name="site_title" type="text" id="site_title" value="<?= $site_title ?>" class="regular-text">
            </td>
        </tr>

        <tr>
            <th scope="row">Date Format</th>
            <td>
                <fieldset id="date_format"><legend class="screen-reader-text"><span><?=Yii::t('setting','Date Format')?></span></legend>
                    <label title="F j, Y"><input type="radio" name="date_format" value="F j, Y" <?=($date_format == 'F j, Y') ? 'checked' : '' ?> > <?= date('F j, Y')?></label><br>
                    <label title="Y-m-d"><input type="radio" name="date_format" value="Y-m-d" <?=($date_format == 'Y-m-d') ? 'checked' : '' ?> > <?= date('Y-m-d')?> </label><br>
                    <label title="m/d/Y"><input type="radio" name="date_format" value="m/d/Y" <?=($date_format == 'm/d/Y') ? 'checked' : '' ?> > <?= date('m/d/Y')?> </label><br>
                    <label title="d/m/Y"><input type="radio" name="date_format" value="d/m/Y" <?=($date_format == 'd/m/Y') ? 'checked' : '' ?> > <?= date('d/m/Y') ?></label><br>
                    <label><input type="radio" name="date_format" id="date_format_custom_radio" value="custom" <?=($date_format != 'F j, Y' && $date_format != 'Y-m-d' && $date_format != 'm/d/Y' && $date_format != 'd/m/Y') ? 'checked' : '' ?> > <?=Yii::t('setting','Custom')?>:</label>
                    <input type="text" style="width: 75px;" name="date_format_custom" id="date_format_custom" value="<?= $date_format ?>" class="small-text"><span class="date"> <?= date($date_format)?> </span>
                </fieldset>
            </td>
        </tr>

        <tr>
            <th scope="row"><?= Yii::t('setting','Time Format')?></th>
            <td>
                <fieldset id="time_format"><legend class="screen-reader-text"></legend>
                    <label title="g:i a"><input type="radio" name="time_format" value="g:i a" <?=($time_format == 'g:i a') ? 'checked' : '' ?> > <?= date('g:i a') ?> </label><br>
                    <label title="g:i A"><input type="radio" name="time_format" value="g:i A" <?=($time_format == 'g:i A') ? 'checked' : '' ?> > <?= date('g:i A')?> </label><br>
                    <label title="H:i"><input type="radio" name="time_format" value="H:i" <?=($time_format == 'H:i') ? 'checked' : '' ?> > <?= date('H:i')?> </label><br>
                    <label><input type="radio" name="time_format" id="time_format_custom_radio" value="custom" <?=($time_format !== 'g:i a' && $time_format !== 'g:i A' && $time_format !== 'H:i') ? 'checked' : '' ?> > <?= Yii::t('setting','Custom')?>:</label>
                    <input type="text" name="time_format_custom" id="time_format_custom" value="<?= $time_format ?>" class="small-text"><span class="time"> <?= date($time_format)?> </span>
                </fieldset>
            </td>
        </tr>

        <tr>
            <th width="33%" scope="row"><label for="language"><?= Yii::t('setting','Site Language')?></label></th>
            <td>
                <select name="language" id="language">
                        <option value="english" lang="en" <?php if($language == 'english') echo 'selected'?>><?= Yii::t('setting','English (United States)')?></option>
                        <option value="japan" lang="ja" <?php if($language == 'japan') echo 'selected'?>><?= Yii::t('setting','Japanese')?></option>
                </select>		
            </td>
        </tr>
    </table>
    <button type="submit" name="submit" id="btnSave" class="btn btn-primary"><?= Yii::t('setting','Save Changes')?></button>
</div>
<script>
    $(function(){
        var site_title = '<?= $site_title?>';
        var date_format = '<?= $date_format?>';
        var time_format = '<?= $time_format?>';
        var language = '<?= $language?>';

        $('#site_title').change(function(){
            site_title = $('#site_title').val();
        });

        $('#date_format input:not("#date_format_custom")').click(function(){
            date_format = $(this).val();
            if(date_format == 'custom'){
                date_format = $('#date_format_custom').val();
            } else {
                $('#date_format_custom_radio').removeClass('checked');
            }
            $('#date_format_custom').val(date_format);
            getDateTime(date_format,'date');
        });

        $('#time_format input:not("#time_format_custom")').click(function(){
            time_format = $(this).val();
            if(time_format == 'custom'){
                time_format = $('#time_format_custom').val();
            }else{
                $('#time_format_custom_radio').removeClass('checked');
            }
            $('#time_format_custom').val(time_format);
            getDateTime(time_format,'time');
        });

        $('#time_format_custom').change(function(){
            var time = $(this).val();
            getDateTime(time,'time');
            time_format = $(this).val();
        });

        $('#date_format_custom').change(function(){
            var date = $(this).val();
            getDateTime(date,'date');
            date_format = $(this).val();
        });

        $('#language').change(function() {
            language = $('#language option:selected').val();
        });

        $('#btnSave').click(function(){
            $.ajax({
                url:'save',
                type:'GET',
                data:{
                    site_title: site_title,
                    date_format: date_format,
                    time_format: time_format,
                    language: language
                },
                success:function(){
                    $(".alert").show();
                    $(".alert").delay(1000).slideUp(100, function() {
                        $(this).hide();
                    });
                }
            })
        });

        function getDateTime(type, show){
            $.ajax({
                url:'formatdatetime',
                type:'GET',
                data:{
                    data: type
                },
                success:function(result){
                    $('.' + show).html(result);
                }
            })
        }
    });
</script>