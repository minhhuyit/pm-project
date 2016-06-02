<?php ?>
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
    .nav-tabs
    {
        margin:10px;

    }
    .tab-content
    {
        margin-left:10px;
        margin-top:-10px;
        margin-right: 10px;
        padding-left:20px;
        padding-top:10px;
        border: 1px solid #ddd;
        border-width: 0 1px 1px; /* Removes the top border */
    }
    #all-categories
    {
        padding-bottom:10px;
    }
    #post_category_select, #new_post_category{
        width: 90%;
        height: 25px;
        margin-top: 10px;
    }
</style>

<script>
    $(document).ready(function () {
        $("#expand_categories").click(function () {
            if ($("#post-category-container").is(":visible"))
                $("#post-category-container").hide("fast");
            else
                $("#post-category-container").show("fast");
        });
    });

</script>



<div id="publish-container">
    <div class="publish-title">Categories</div>
    <div class="publish-content">

        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#all-categories">All categories</a></li>
            <li><a data-toggle="tab" href="#most-used">Most Used</a></li>
        </ul>

        <div class="tab-content">
            <div id="all-categories" class="tab-pane fade in active">
                <div class="category">
                    <?php
//                    array_walk_recursive(Yii::$app->taxonomy->listTermsOfTaxonomy('category'), function($item, $key) {
//                        if ($key == 'name') {
//                            echo "<input type=\"checkbox\" value=\"$item\"> $item<br/>";
//                        }
//                    });
                    ?>
                </div>
            </div>
            <div id="most-used" class="tab-pane fade">

            </div>
        </div>

        <div style="margin-left:10px;margin-top:10px;">
            <a id="expand_categories">+ Add New Category</a>
        </div>
        <div id="post-category-container" style="margin-left:10px;display:none;">
            <input type="text" name="new_post_category" id="new_post_category">
            <input type="hidden" name="hidden_post_category" id="hidden_post_category" value="">
            <select name="post_category" id="post_category_select">                
                <option selected="selected" value="Draft">— Parent Category —</option>
                <?php
//                array_walk_recursive(Yii::$app->taxonomy->listTermsOfTaxonomy('category'), function($item, $key) {
//                    if ($key == 'name') {
//                        echo "<option value=\"$item\">$item</option>";
//                    }
//                });
                ?>
            </select>
            <button type="button" class="btn btn-default" style="padding:5px;margin-top:20px;">Add New Category</button>

        </div>



    </div>

</div>