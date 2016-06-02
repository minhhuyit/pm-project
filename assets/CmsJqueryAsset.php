<?php
namespace app\assets;
use yii\web\View;
use yii\web\AssetBundle;
/**
 * Description of CmsJqueryAsset
 *
 * @author Thuy
 */
class CmsJqueryAsset extends AssetBundle  {
    public $sourcePath = '@bower/jquery/dist';
    public $js = [
        'jquery.js',
    ];
    public $jsOptions = array(
         'position' => View::POS_HEAD // appear in the bottom of my page, but jquery is more down again
    ); 
}
