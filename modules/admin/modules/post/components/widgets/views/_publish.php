<?php
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $publishButton: Publish or Update */
?>

<style>
    #publish-container
    {
        border: 1px solid #e5e5e5;
        box-shadow: 0 1px 1px rgba(0,0,0,.04);
        background: #fff;

    }
    .publish-title
    {
        padding:6px;

        font-weight: bold;
        border-bottom: 1px solid #e5e5e5;
    }
    .post_status
    {
        margin-left:10px;
    }
    .visibility-container
    {
        margin-bottom:10px;
    }
    .status-container
    {
        margin-bottom:10px;
    }
    .post_visibility
    {
        margin-left:10px;
    }
    .post_publish-datetime
    {
        margin-left:10px;
    }
    .publish-content {
        padding-bottom: 20px;
    }

    #post_status_select
    {
        border: 1px solid #ddd;
        box-shadow: inset 0 1px 2px rgba(0,0,0,.07);
        height:25px;
    }
    .timestamp-wrap{
        margin-top:10px;
    }

    .timestamp-wrap input{
        border: 1px solid #ddd;
        width: 3.4em;
    }

    .timestamp-wrap select {
        border: 1px solid #ddd;
        width: 5.4em;
    }
    #aa {
        width: 3.4em;
    }
    #hh, #jj, #mn {
        width: 2em;
    }
    #aa, #hh, #jj, #mn {
        padding: 1px;
        font-size: 12px;
    }

    #publish-footer-container
    {
        border-top: 1px solid #ddd;
        background: #f5f5f5;
    }
    #publish-footer-content
    {
        padding-left:10px;
        padding-right:10px;
        padding-top:15px;
        padding-bottom: 15px;
    }
    .delete-post{
        color: #a00;
        text-decoration: none;
        padding:5px;
        margin-top:10px;
        font-size:.9em;
    }
    .delete-post:hover {
        color: red;
        text-decoration: none;
    }
</style>


<script>

    $(document).ready(function () {

        $("#expand_status").click(function () {
            $("#post-status-container").show("fast");
        });

        $("#colapse_status").click(function () {
            $("#post-status-container").hide("fast");
        });

        $("#expand_visibility").click(function () {
            $("#post-visibility-container").show("fast");
            if ($("#public-select-radio").prop("checked"))
            {
                $("#post-stick-checkbox").css('display', '');
            } else if ($("#protected-select-radio").prop("checked"))
            {
                $("#post-password-input").css('display', '');
            }
        });

        $("#colapse_visibility").click(function () {
            $("#post-stick-checkbox").hide("fast");
            $("#post-password-input").hide("fast");
            $("#post-visibility-container").hide("fast");
        });

        $("#expand_publish-datetime").click(function () {
            $("#post-publish-datetime-container").show("fast");
        });

        $("#colapse_publish-datetime").click(function () {
            $("#post-publish-datetime-container").hide("fast");
        });

        $("#save-post-status").click(function () {
            $("#hidden_post_status").val($("#post_status_select").val());
            $("#post_status_label").text($("#post_status_select option:selected").text());
            $("#post-status-container").hide("fast");
        });

        $("#save-post-visibility").click(function () {
            $("#post_visibility_label").text($("#post_visibility_select input[type='radio']:checked").val());
            $("#post-stick-checkbox").hide("fast");
            $("#post-password-input").hide("fast");
            $("#post-visibility-container").hide("fast");

        });

        $("#save-post-publish-datetime").click(function () {
            $(".post_publish-datetime").text('Schedule for: ');
            $("#post_publish-datetime_label").text($("#mm").val() + ' ' + $("#jj").val() + ', ' + $("#aa").val() + ' @ ' + $("#hh").val() + ':' + $("#mn").val());
            $("#post-publish-datetime-container").hide("fast");
        });

        $("#publish-post-button").click(function () {
            $("#post-status").val($("#hidden_post_status").val());
            $("#publish-post-form").submit();
        });


        $("#public-select-radio").change(function () {
            $("#post-stick-checkbox").show("fast");
            $("#post-password-input").hide("fast");
        });

        $("#protected-select-radio").change(function () {
            $("#post-stick-checkbox").hide("fast");
            $("#post-password-input").show("fast");
        });

        $("#private-select-radio").change(function () {
            $("#post-stick-checkbox").hide("fast");
            $("#post-password-input").hide("fast");
        });

    });

</script>


<div id="publish-container">
    <div class="publish-title">Publish</div>
    <div class="publish-content">
        <div class="btn-panel">
            <button type="button" class="btn btn-default" style="padding:5px;margin:10px;">Save Draft</button>

            <button type="button" class="btn btn-default" style="padding:5px;margin:10px;float:right;">Preview</button>
        </div>

        <div class="status-container">
            <span class="post_status"><span class="glyphicon glyphicon-flash" style="color: #82878c;"></span> Status: </span >&nbsp;<span id="post_status_label" style="font-weight:bold;"><?php if ($publishButton == 'Publish') echo 'Publish'; ?></span>&nbsp;&nbsp;<a id="expand_status">Edit</a>
            <div id="post-status-container" style="margin-left:10px;display:none;">
                <input type="hidden" name="hidden_post_status" id="hidden_post_status" value="<?php if ($publishButton == 'Publish') echo 'publish'; ?>">
                <select name="post_status" id="post_status_select">
                    <option value="pending">Pending Review</option>
                    <option value="publish">Publish</option>
                    <option selected="selected" value="draft">Draft</option>
                </select>
                <button type="button" id="save-post-status" class="btn btn-default" style="padding:2px;margin:10px;">OK</button>
                <a id="colapse_status">Cancel</a>
            </div>
        </div>

        <!--

        <div class="visibility-container">
            <span class="post_visibility "><span class="glyphicon glyphicon-eye-open" style="color: #82878c;"></span> Visibility: </span >&nbsp;<span id="post_visibility_label" style="font-weight:bold;">Public</span>&nbsp;&nbsp;<a id="expand_visibility">Edit</a>
            <div id="post-visibility-container" style="margin-left:10px;display:none;">
                <input type="hidden" name="hidden_post_visibility" id="hidden_post_visibility" value="Public">

                <div id="post_visibility_select" class="btn-group">
                    <input type="radio" id="public-select-radio" name="visibility-select" value="Public" checked > Public<br/>
                    <div id="post-stick-checkbox" style="margin-left:15px;display:none;">
                        <input id="post-stick" type="checkbox" value=""> Stick this post to the front page
                    </div>
                    <input type="radio" id="protected-select-radio" name="visibility-select" value="Protected" > Password protected<br/>
                    <div id="post-password-input" style="margin-left:15px;display:none;">
                        <input id="post-password" type="text" value="">
                    </div>
                    <input type="radio" id="private-select-radio" name="visibility-select" value="Private" > Private<br/>
                </div>

                <div class="ok-cancel">
                    <button type="button" id="save-post-visibility" class="btn btn-default" style="margin:10px;">OK</button>
                    <a id="colapse_visibility">Cancel</a>
                </div>
            </div>
        </div>

        <div class="publish-datetime-container">
            <span class="post_publish-datetime"><span class="glyphicon glyphicon-calendar" style="color: #82878c;"></span> Publish: </span >&nbsp;<span id="post_publish-datetime_label" style="font-weight:bold;">immediately</span>&nbsp;&nbsp;<a id="expand_publish-datetime">Edit</a>
            <div id="post-publish-datetime-container" style="margin-left:10px;display:none;">
                <input type="hidden" name="hidden_post_publish-datetime" id="hidden_post_publish-datetime" value="Immediately">

                <div class="timestamp-wrap">
                    <select id="mm" name="mm">
                        <option value="Jan" data-text="Jan">01-Jan</option>
                        <option value="Feb" data-text="Feb">02-Feb</option>
                        <option value="Mar" data-text="Mar" selected="selected">03-Mar</option>
                        <option value="Apr" data-text="Apr">04-Apr</option>
                        <option value="May" data-text="May">05-May</option>
                        <option value="Jun" data-text="Jun">06-Jun</option>
                        <option value="Jul" data-text="Jul">07-Jul</option>
                        <option value="Aug" data-text="Aug">08-Aug</option>
                        <option value="Sep" data-text="Sep">09-Sep</option>
                        <option value="Oct" data-text="Oct">10-Oct</option>
                        <option value="Nov" data-text="Nov">11-Nov</option>
                        <option value="Dec" data-text="Dec">12-Dec</option>
                    </select>
                    <input type="text" id="jj" name="jj" value="02" size="2" maxlength="2" autocomplete="off">,
                    <input type="text" id="aa" name="aa" value="2016" size="4" maxlength="4" autocomplete="off">@
                    <input type="text" id="hh" name="hh" value="08" size="2" maxlength="2" autocomplete="off">:
                    <input type="text" id="mn" name="mn" value="48" size="2" maxlength="2" autocomplete="off">
                </div>
        

                <div class="ok-cancel">
                    <button type="button" id="save-post-publish-datetime" class="btn btn-default" style="margin:10px;">OK</button>
                    <a id="colapse_publish-datetime">Cancel</a>
                </div>
            </div>
        </div>
        !-->

    </div>

    <div id="publish-footer-container">
        <div id="publish-footer-content">
            <?php
            $form = ActiveForm::begin([
                        'action' => 'trash?id='.$model->id,
            ]);
            ?>
            <button class="delete-post" type="submit" id="delete-post" style="background:none!important;border:none;<?php if ($publishButton == 'Publish') echo 'color:gray;'; ?>" <?php if ($publishButton == 'Publish') echo 'disabled'; ?>>Move to Trash</button>
            <?php ActiveForm::end(); ?>
            <button type="button" id="publish-post-button" class="btn btn-primary" style="float:right;margin-top:-35px;"><?= $publishButton ?></button>

        </div>
    </div>

</div>