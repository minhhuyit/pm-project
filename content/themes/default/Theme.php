<?php
namespace theme;

/**
 * Created by Cominit.
 * User: ptu
 * Date: 3/9/16
 * Time: 8:42 AM
 */

use app\components\BaseTheme;
use app\models\Post;
use yii\web\Controller;

/**
 * Each theme must have class Theme that extend from BaseTheme.
 * Namespace must be 'theme' and all class under the theme must have namespace 'theme' too.
 * This class have responsibility to init theme, attach hoods...
 */
class Theme extends BaseTheme
{

    /**
     * Setup for theme
     *
     */
    protected function setup()
    {
        //test register post form meta box
        \Yii::$app->post->registerFormMetaBox('test', 'This is test', 'post', [$this, 'renderTestMetaBox']);
    }

    /**
     * @param Controller $controller
     * @param Post $post
     * @return mixed
     */
    public function renderTestMetaBox($controller, $post)
    {
        //should render form inputs
        //return $controller->renderFile($this->getViewPath('metabox/test'), ['post'=>$post]);
    }
}