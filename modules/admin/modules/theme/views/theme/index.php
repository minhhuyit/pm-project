<link rel="stylesheet" href="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/css/load-styles.css" type="text/css" media="all">
<?php
/* @var $this yii\web\View */
require_once 'uploader.php';
require_once Yii::$app->basePath . '/components/ThemeComponent.php';
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

    #wpcontent {
        margin-left:0px;
    }

    #wrapper {
        overflow: hidden;
        background-color: #fff;
    }

    .input-file-container {
        position: relative;
        width: 225px;
    } 
    .js .input-file-trigger {
        display: block;
        padding: 14px 45px;
        background: #39D2B4;
        color: #fff;
        font-size: 1em;
        transition: all .4s;
        cursor: pointer;
    }
    .js .input-file {
        position: absolute;
        top: 0; left: 0;
        width: 225px;
        opacity: 0;
        padding: 14px 0;
        cursor: pointer;
    }
    .js .input-file:hover + .input-file-trigger,
    .js .input-file:focus + .input-file-trigger,
    .js .input-file-trigger:hover,
    .js .input-file-trigger:focus {
        background: #34495E;
        color: #39D2B4;
    }

    .file-return {
        margin: 0;
    }
    .file-return:not(:empty) {
        margin: 1em 0;
    }
    .js .file-return {
        font-style: italic;
        font-size: .9em;
        font-weight: bold;
    }
    .js .file-return:not(:empty):before {
        content: "Selected file: ";
        font-style: normal;
        font-weight: normal;
    }

    #upload-theme-form{
        color: #7F8C9A;
    }

    #upload-theme-form h1,  #upload-theme-form h2 {
        margin-bottom: 5px;
        font-weight: normal;
        text-align: center;
        color:#aaa;
    }

    #upload-theme-form h2 {
        margin: 5px 0 2em;
        color: #1ABC9C;
    }

    form {
        width: 225px;
        margin: 0 auto;
        text-align:center;
    }

    #upload-theme-form h2 + P {
        text-align: center;
    }

    .txtcenter {
        margin-top: 4em;
        font-size: .9em;
        text-align: center;
        color: #aaa;
    }
    .copy {
        margin-top: 2em;
    }

    .copy a {
        text-decoration: none;
        color: #1ABC9C;
    }

    #upload-theme-form
    {
        margin-top:20px;
    }

    #my-file{
        display: none;
    }

    .theme-screenshot
    {
        max-height: 230px;
    }

</style>


<script>
    $(function () {
        document.querySelector("html").classList.add('js');

        var fileInput = document.querySelector(".input-file"),
                button = document.querySelector(".input-file-trigger"),
                the_return = document.querySelector(".file-return");

        button.addEventListener("keydown", function (event) {
            if (event.keyCode == 13 || event.keyCode == 32) {
                fileInput.focus();
            }
        });
        button.addEventListener("click", function (event) {
            fileInput.focus();
            return false;
        });
        fileInput.addEventListener("change", function (event) {
            the_return.innerHTML = this.value;
            $("#upload-theme-form").submit();
        });
    });
</script>



<?php
if (isset($_GET['active'])) {
    Yii::$app->theme->setActiveThemeName($_GET['active']);
}

$this->title = 'Manage Themes';

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

    function activateTheme(themeName)
    {
        window.location.href = "<?= Yii::$app->getUrlManager()->getBaseUrl() ?>" + "/admin/theme?active=" + themeName;
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

                                            <h2 class="theme-name" id="theme-name">
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

                                            <h2 class="theme-name" id="theme-name"><?= $theme_list[$i]['name'] ?> 	</h2>


                                            <div class="theme-actions">
                                                <a class="button button-secondary activate" id="<?= $theme_list[$i]['name'] ?>" href="#" onclick="activateTheme(this.id);">Kích hoạt</a>
                                                <a class="button button-primary load-customize hide-if-no-customize" href="#">Xem trước</a>
                                            </div>

                                        </div>

                                        <?php
                                    }
                                }
                                ?>

                                <div class="theme add-new-theme" style="border: 5px dashed rgba(0,0,0,.1);">                                  
                                    <div class="theme-screenshot">

                                        <form id="upload-theme-form" enctype="multipart/form-data" method="post" action="">

                                            <div class="input-file-container">  
                                                <input class="input-file" id="my-file" type="file" name="zip_file">
                                                <label tabindex="0" for="my-file" class="input-file-trigger">Add a new theme...</label>
                                            </div>

                                            <p class="file-return"></p>
                                            <br/>
                                            <?php
                                            if (isset($message))
                                                echo "<p>$message</p>";
                                            $message = "";
                                            ?>

                                        </form>

                                    </div>
                                    <h2 class="theme-name" style="color:gray;font-weight: bold;">Thêm giao diện mới</h2>

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
