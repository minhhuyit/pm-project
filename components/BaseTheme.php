<?php
/**
 * Created by Cominit.
 * User: ptu
 * Date: 3/9/16
 * Time: 8:37 AM
 */

namespace app\components;


use yii\base\Component;

/**
 * Class BaseTheme Base theme class for all themes, new theme must extend this class
 * @package app\components
 */
abstract class BaseTheme extends Component
{
    public function init()
    {
        parent::init();

        $this->setup();
    }

    /**
     * Setup for theme
     *
     */
    protected abstract function setup();

    /**
     * Get view path of view of current theme
     *
     * @param $viewName
     * @return string view file path
     */
    protected function getViewPath($viewName)
    {
        return \Yii::getAlias("@theme/views/{$viewName}.php");
    }
}