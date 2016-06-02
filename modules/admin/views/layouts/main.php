<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AdminAsset;
use app\widgets\admin\CmsNavBar;
use app\widgets\admin\CmsNav;
use yii\widgets\Breadcrumbs;

AdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head()?>
</head>
<body>
<?php $this->beginBody()?>

<div id="wrapper">
    <!-- Navigation -->
    <?php
    CmsNavBar::begin([
        'brandLabel' => Yii::t('cms', 'Cominit\'s CMS'),
        'dropDownOptions'=>['class'=>'dropdown-menu'],
        'items' =>  [
                    Yii::$app->user->isGuest ? (
                        ['label' => 'Login', 'url' => ['/main/login']]
                        ):(
                            ['label' =>
                                    'Welcome to '.Yii::$app->user->identity->username.'!',
                                    'items' => [
                                            ['label' => '<i class="fa fa-user fa-fw"></i> Profile' ,'url' => ['/main/about' ],],
                                            ('<li class="divider"></li>'),
                                            ['label' => '<i class="fa fa-sign-out fa-fw"></i> Logout' ,'url' => ['/main/about' ],],
                                             
                                    ],
                            ]),
                    ],
        'rightOptions' => ['class' => 'nav navbar-top-links navbar-right'],
        'innerContainerOptions' => ['class' => 'navbar-default sidebar', 'role' => 'navigation'],
        'containerOptions' => [ 'class' => 'sidebar-nav navbar-collapse'],
        'options' => [
            'class' => 'navbar navbar-default navbar-static-top',
                'style'=>'margin-bottom: 0',
        ],
    ]);
    
    
    echo CmsNav::widget([
        'encodeLabels' => false, //allows you to use html in labels
        'activateParents' => true,
        'options' => ['class' => 'nav in', 'id' => 'side-menu'],
        'dropDownCaret' => '<span class="fa arrow"></span>' ,
        'dropDownOptions' => ['class'=>'nav nav-second-level'],
        'encodeLabels' => false,
        'enableLayout' => true,
        'items' => \Yii::$app->adminModule->adminMenu->getMenuData(),
        ]);
    CmsNavBar::end([
    ]);
     ?>
        <!-- /#page-wrapper -->

		<div id="page-wrapper">
			<div class="row">
                            <div class="col-lg-12">
				<br>
                                        <?= Breadcrumbs::widget([
                                            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                        ]) ?>
                                        <?= $content ?>
                                 
                            </div>
				<!-- /.col-lg-12 -->
			</div>
		</div>
		<footer class="footer">
			<div class="container">
				<p class="pull-left">&copy; My Company <?= date('Y') ?></p>

				<p class="pull-right"><?= Yii::powered() ?></p>
			</div>
		</footer>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
