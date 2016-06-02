<?php

use yii\db\Migration;
use app\models\User;

class m160304_094041_add_default_admin_user extends Migration
{
    /*
    public function up()
    {
        
    }

    public function down()
    {
        echo "m160304_094041_add_default_admin_user cannot be reverted.\n";

        return false;
    }*/

    
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->insert(User::tableName(), [
            'username'=>'admin',
            'email'=>'admin@example.com',
            'pass'=>  User::generateHashPassword('admin'),
            'display_name'=>'Admin',
            'created_date'=>date('Y-m-d H:i:s')
        ]);
        
        $userId = Yii::$app->db->getLastInsertID();
        
        $this->insert('usermeta', [
            'user_id'=>$userId,
            'meta_key'=>'role',
            'meta_value'=>  serialize('administrator')
        ]);
    }

    public function safeDown()
    {
    }
    
}
