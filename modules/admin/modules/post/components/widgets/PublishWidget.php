<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace admin\modules\post\components\widgets;

use yii\base\Widget;

/**
 * Description of PublishWidget
 *
 * @author Huy
 */
class PublishWidget extends Widget {

    public $publishButton;
    public $model;

    public function init() {
        parent::init();
    }

    public function run() {
        return $this->render('_publish', ['publishButton' => $this->publishButton, 'model' => $this->model]);
    }

}

?>