<?php
namespace app\widgets\admin;

use yii\bootstrap\Widget;
use yii\helpers\Html;
use \yii\bootstrap\Dropdown;

class CmsDropdown extends Dropdown
{
    /**
     * @var boolean using set layout for sub nav
     */
    public $enableLayout = false;
    
    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        if ($this->submenuOptions === null) {
            // copying of [[options]] kept for BC
            // @todo separate [[submenuOptions]] from [[options]] completely before 2.1 release
            $this->submenuOptions = $this->options;
            unset($this->submenuOptions['id']);
        }
        Widget::init();
        if($this->enableLayout)
        {
            Html::addCssClass($this->options, ['widget' => '']);
        }else{
            Html::addCssClass($this->options, ['widget' => 'dropdown-menu']);
        }
    
    }
    
}