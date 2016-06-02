<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace admin\modules\post\components\widgets;

use yii\base\Widget;
/**
 * Description of CategoriesWidget
 *
 * @author Huy
 */
class CategoriesWidget extends Widget {

    public function init() {
        parent::init();
    }

    public function run() {
        return $this->render('_categories');
    }
}
