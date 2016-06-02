<?php
namespace app\widgets\admin;

use Yii;
use yii\helpers\ArrayHelper;

use yii\bootstrap\Widget;
use yii\helpers\Html;
use \yii\bootstrap\NavBar;

class CmsNavBar extends NavBar
{
    /**
     * @var array the items of the right menu.
     */
    public $items = [];
    
    /**
     * @var array the HTML attributes of the right menu.
     */
    public $rightOptions = [];
    
    /**
     * @var array the HTML attributes of the right submenu.
     */
    public $dropDownOptions = [];
    
    /**
     * Initializes the widget.
     */
    public function init()
    {
        Widget::init();
        $this->clientOptions = false;
        if (empty($this->options['class'])) {
            Html::addCssClass($this->options, ['navbar', 'navbar-default']);
        } else {
            Html::addCssClass($this->options, ['widget' => 'navbar']);
        }
        if (empty($this->options['role'])) {
            $this->options['role'] = 'navigation';
        }
        $options = $this->options;
        $tag = ArrayHelper::remove($options, 'tag', 'nav');
        echo Html::beginTag($tag, $options);
        echo Html::beginTag('div', ['class' => 'navbar-header']);
        if (!isset($this->containerOptions['id'])) {
            $this->containerOptions['id'] = "{$this->options['id']}-collapse";
        }
        echo $this->renderToggleButton();
        if ($this->brandLabel !== false) {
            Html::addCssClass($this->brandOptions, ['widget' => 'navbar-brand']);
            echo Html::a($this->brandLabel, $this->brandUrl === false ? Yii::$app->homeUrl : $this->brandUrl, $this->brandOptions);
        }
        echo Html::endTag('div');
        echo $this->renderNav($this->items, $this->rightOptions, true);
        if ($this->renderInnerContainer) {
            if (!isset($this->innerContainerOptions['class'])) {
                Html::addCssClass($this->innerContainerOptions, 'container');
            }
            echo Html::beginTag('div', $this->innerContainerOptions);
        }
        Html::addCssClass($this->containerOptions, ['collapse' => 'collapse', 'widget' => 'navbar-collapse']);
        $options = $this->containerOptions;
        $tag = ArrayHelper::remove($options, 'tag', 'div');
        echo Html::beginTag($tag, $options);
    }
    
    
    /**
     * Render Nav
     * @param Array $items items using for display subnav
     * @param Array  $parentItem attribute HTML of items
     * @param boolean $enableLayout allow using layout.
     */
    protected function renderNav($items, $parentItem, $enableLayout)
    {
        return CmsNav::widget([
                'encodeLabels' => false, //allows you to use html in labels
                'activateParents' => true,
                'options' => $parentItem,
                'dropDownOptions' => $this->dropDownOptions,
                'encodeLabels' => false,
                'enableLayout' => $enableLayout,
                'items' => $items,
                ]);
    }
}