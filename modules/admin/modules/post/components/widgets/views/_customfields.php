<?php ?>


<script>
    $(function () {
        var metaindex = 0;
        var metakey = '';

        $('#newmeta-submit').click(function () {


            if (($('#metakeyinput').is(":visible") && $('#metakeyinput').val() != '')
                    || ($('#metakeyselect').is(":visible") && $('#metakeyselect').val() != '#NONE#'))
            {

                if ($('#metakeyselect').is(":visible"))
                {
                    metakey = $('#metakeyselect').val();
                } else if ($('#metakeyinput').is(":visible"))
                {
                    metakey = $('#metakeyinput').val();
                }

                $('#validate-response').hide('fast');

                metaindex++;

                $('#listmeta > tbody:last-child').append('<tr> \n\
            <td> \n\
                <input type="text" class="metakeyinput" id="metakey' + metaindex + '" name="metakeyinput" value="' + metakey + '"> \n\
                <button type="button" id="btn-metakey' + metaindex + '"  onclick="deleteMeta(this.id);" class="btn btn-default" style="padding:0px;margin-left:10px;margin-bottom:10px;width:70px;height:20px;font-size:.9em">Delete</button> \n\
            </td> \n\
            <td>\n\
                <textarea class="metavalue" id="metavalue' + metaindex + '" name="metavalue" rows="2" cols="25">' + $('#metavalue').val() + '</textarea>\n\
            </td>\n\
            </tr>');
            } else
            {
                $('#validate-response').show('fast');
            }

            if ($('#listmeta >tbody >tr').length > 0)
            {
                $('#listmeta').show('fast');
            }

        });
    })


    function deleteMeta(id)
    {
        $('#' + id).closest('tr').remove();

        if ($('#listmeta >tbody >tr').length == 0)
        {
            $('#listmeta').hide('fast');
        }
    }
</script>


<style>

    .custom-fields-container
    {
        margin-top:20px;
        margin-bottom:60px;
        border: 1px solid rgba(0,0,0,0.2);
        box-shadow: 0 1px 1px rgba(0,0,0,.04);
        background: #fff;
    }
    .custom-field-content
    {
        padding-top:10px;
        padding-left:10px;
    }
    .custom-field-footer
    {
        padding-left:10px;
    }

    #newmeta, #listmeta{
        margin: 0;
        width: 99%;
        border: 1px solid #dfdfdf;
        border-spacing: 0;
        background-color: #f9f9f9;
        margin-bottom:10px;
    }

    #newmeta thead, #listmeta thead{
        display: table-header-group;
        vertical-align: middle;
        border-color: inherit;
    }

    #newmeta thead th , #listmeta thead th {
        text-align: center;
        padding: 5px 8px 8px;
        background-color: #f1f1f1;
    }

    #metakeyselect, .metakeyinput{
        margin:10px;
        border: 1px solid #ddd;
        width:300px;
        box-shadow: inset 0 1px 2px rgba(0,0,0,.07);
        height: 25px;
    }

    .metavalue{
        margin:10px;
        border: 1px solid #ddd;
        width:450px;
        box-shadow: inset 0 1px 2px rgba(0,0,0,.07);
    }

    .custom-field-footer
    {
        margin:10px;
        font-size:0.9em;
    }
    .meta-error {
        border-left: 4px solid #fff;
        border-left-color: #dc3232;
        padding: 1px 12px;
        box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        font-size: .9em;
        padding-top:10px;
    }
    #validate-response
    {
        display:none;
        margin-bottom:20px;
    }
</style>

<div class="custom-fields-container">
    <div class="publish-title">
        Custom Fields
    </div>

    <div class="custom-field-content">

        <div id="validate-response"><div class="meta-error"><p>Please provide a custom field value.</p></div></div>

        <table id="listmeta" style="display:none">
            <thead>
                <tr>
                    <th class="left"><label for="metakeyselect">Name</label></th>
                    <th><label for="metavalue">Value</label></th>
                </tr>
            </thead>

            <tbody>
            </tbody>
        </table>

        <label style="padding:10px 10px 10px 0px;">Add New Custom Field:</label>



        <table id="newmeta">
            <thead>
                <tr>
                    <th class="left"><label for="metakeyselect">Name</label></th>
                    <th><label for="metavalue">Value</label></th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td id="newmetaleft" class="left">
                        <select id="metakeyselect" name="metakeyselect" style="display: inline-block;">
                            <option value="#NONE#">— Select —</option>
                            <option value="test_field1">test_field1</option>
                            <option value="test_field2">test_field2</option></select>
                        <input  type="text" style="display: none;" class="metakeyinput" id="metakeyinput" name="metakeyinput" value="">
                        <br/>
                        <a href="#postcustomstuff" style="margin-left:10px" onclick="jQuery('#metakeyinput, #metakeyselect, #enternew, #cancelnew').toggle();
                                    return false;">
                            <span id="enternew"  style="display: inline;">Enter new</span>
                            <span id="cancelnew" style="display: none;">Cancel</span></a>
                    </td>
                    <td><textarea class="metavalue" id="metavalue" name="metavalue" rows="2" cols="25"></textarea></td>
                </tr>

                <tr><td colspan="2">
                        <div class="submit">
                            <input type="submit" name="addmeta" id="newmeta-submit" class="btn btn-default" style="margin:10px;" value="Add Custom Field"></div>
            </tbody>
        </table>



    </div>
    <div class="custom-field-footer">
        Custom fields can be used to add extra metadata to a post that you can use in your theme.
    </div>
</div>