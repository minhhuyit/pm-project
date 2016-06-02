<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/main.css',
        'css/admin/sb-admin-2.css',
        'css/admin/metisMenu.min.css',
        'css/font-awesome.min.css',
    ];
    public $js = [
            'js/admin/metisMenu.min.js',
            'js/admin/sb-admin-2.js',
    ];
    public $depends = [
        'app\assets\CmsJqueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
