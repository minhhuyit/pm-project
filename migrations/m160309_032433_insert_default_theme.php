<?php

use yii\db\Migration;

class m160309_032433_insert_default_theme extends Migration
{
    public function up()
    {
        $this->insert('option', [
            'name'=>'cms_active_theme_name',
            'value'=>'s:7:"default"',
            'autoload'=>'yes'
        ]);
    }

    public function down()
    {
        echo "m160309_032433_insert_default_theme cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
