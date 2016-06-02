<?php
namespace app\widgets\admin;

use yii\helpers\ArrayHelper;
use \yii\bootstrap\Nav;
class CmsNav extends Nav
{
    /**
     * @var boolean using set layout for sub nav
     */
    public $enableLayout = false;
    
    /**
     * @var array contain option using set layout for sub nav
     */
    public $dropDownOptions = [];
    /**
     * Renders the given items as a dropdown.
     * This method is called to create sub-menus.
     * @param array $items the given items. Please refer to [[Dropdown::items]] for the array structure.
     * @param array $parentItem the parent item information. Please refer to [[items]] for the structure of this array.
     * @return string the rendering result.
     * @since 2.0.1
     */
    protected function renderDropdown($items, $parentItem)
    {
        return CmsDropdown::widget([
                'options' => $this->dropDownOptions,
                'items' => $items,
                'encodeLabels' => $this->encodeLabels,
                'clientOptions' => false,
                'enableLayout' => $this->enableLayout,// overide;
                'view' => $this->getView(),
        ]);
    }
    
}