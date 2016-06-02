
<link rel="stylesheet" href="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/css/load-styles.css" type="text/css" media="all">
<?php
/* @var $this yii\web\View */

require_once __DIR__ . '/../../components/ThemeComponent.php';
?>


<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">


<style>
    .hide-search {
        display: none;
    }
    .theme-name{
        padding-bottom: 30px !important;
    }

    .theme-version
    {
        color: #999;
        font-size: 13px;
        font-weight: 400;
    }

    .button-secondary, .button-primary{
        margin-top: -7px !important;
    }

    #wpwrap {
        background-color: #fff !important;
    }

    .wrap {
        margin:0px !important;
        margin-top:20px !important;
        background-color: white;
    }

</style>


<?php
$this->title = 'Manage Themes';
$this->params['breadcrumbs'][] = $this->title;


$theme_list = Yii::$app->theme->getAllAvailableThemes();
?>

<script>

    function toggleDetail(id)
    {
        var theme_list = <?php echo json_encode($theme_list); ?>;
        var theme_count = <?php echo count($theme_list); ?>;
        var base_url = <?php echo json_encode(Yii::$app->getUrlManager()->getBaseUrl()); ?>

        for (i = 0; i < theme_count; i++) {
            if (id == theme_list[i]['name']) {
                $("#modal-title").text(theme_list[i]['name']);
                $("#theme-name").text(theme_list[i]['name']);
                $("#theme-version").text(theme_list[i]['version']);
                $("#theme-author").text(theme_list[i]['author']);
                $("#theme-description").text(theme_list[i]['description']);
                $("#theme-screenshot").attr("src", base_url + "/../content/themes/" + theme_list[i]['name'] + "/screenshot.png");
                break;
            }
        }

        $("#myModal").modal();
    }

</script>


<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <h4 id="modal-title">Theme Title</h4>
            </div>
            <div class="modal-body">

                <div class="theme-wrap">

                    <div class="theme-about">
                        <div class="theme-screenshots">

                            <div class="screenshot"><img id='theme-screenshot' src="" width=560px height=300px alt=""></div>

                        </div>

                        <div class="theme-info">

                            <h2><span id="theme-name">Theme Name </span><span class="theme-version">&nbsp;&nbsp;&nbsp;version:<span id="theme-version"> 1.0</span></span></h2>                               <b>Author: </b><span id="theme-author">By <a href="https://wordpress.org/">the WordPress team</a></span>

                            <br/><br/><b>Description: </b><span id="theme-description">Theme Description</span>

                        </div>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


<body class="wp-core-ui">

    <div id="wpwrap">

        <div id="wpcontent">

            <div id="wpbody" role="main">

                <div id="wpbody-content" aria-label="Nội dung chính" tabindex="0">

                    <div class="content-wrap">
                        <h1>Giao diện		<span class="title-count theme-count"><?= count($theme_list) ?></span></h1>

                        <div class="theme-browser rendered">
                            <div class="themes">

                                <?php
                                for ($i = 0; $i < count($theme_list); $i++) {

                                    if ($theme_list[$i]['isActive']) {
                                        ?>

                                        <div class="theme active" tabindex="0">

                                            <div class="theme-screenshot">
                                                <img src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/../content/themes/<?= $theme_list[$i]['name'] ?>/screenshot.png" alt="">
                                            </div>

                                            <span class="more-details" onclick="toggleDetail(this.id);" id="<?= $theme_list[$i]['name'] ?>">Theme Details</span>
                                            <div class="theme-author"><?= $theme_list[$i]['author'] ?> </div>

                                            <h2 class="theme-name" id="twentyfifteen-name">
                                                <span>Kích hoạt:</span> <?= $theme_list[$i]['name'] ?> 		
                                            </h2>

                                            <div class="theme-actions">
                                                <a class="button button-primary customize load-customize hide-if-no-customize" href="#">Tùy chỉnh</a>
                                            </div>

                                        </div>

                                        <?php
                                    } else {
                                        ?>

                                        <div class="theme" tabindex="0">

                                            <div class="theme-screenshot">
                                                <img src="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/../content/themes/<?= $theme_list[$i]['name'] ?>/screenshot.png" alt="">
                                            </div>

                                            <span class="more-details" onclick="toggleDetail(this.id);"  id="<?= $theme_list[$i]['name'] ?>">Theme Details</span>
                                            <div class="theme-author"><?= $theme_list[$i]['author'] ?></div>

                                            <h2 class="theme-name" id="twentyfourteen-name"><?= $theme_list[$i]['name'] ?> 	</h2>


                                            <div class="theme-actions">
                                                <a class="button button-secondary activate" href="#">Kích hoạt</a>
                                                <a class="button button-primary load-customize hide-if-no-customize" href="#">Xem trước</a>
                                            </div>

                                        </div>

                                        <?php
                                    }
                                }
                                ?>
                             

                                <div class="theme add-new-theme">
                                    <a href="#">
                                        <div class="theme-screenshot"><span></span>
                                        </div>
                                        <h2 class="theme-name">Thêm giao diện mới</h2>
                                    </a>
                                </div>


                            </div>
                            <br class="clear">
                        </div>
                        <div class="theme-overlay"></div>

                    </div>
                    <!-- .wrap -->


                    <div class="clear"></div>
                </div>
                <!-- wpbody-content -->
                <div class="clear"></div>
            </div>
            <!-- wpbody -->
            <div class="clear"></div>
        </div>
        <!-- wpcontent -->


        <div class="clear"></div>
    </div>
    <!-- wpwrap -->


</body>
