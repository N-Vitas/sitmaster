<?php

use yii\db\Migration;

class m160303_172619_add_column_user extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'cat_id', 'INT(11)  NOT NULL DEFAULT 0  AFTER `id`'); 
        $this->addColumn('user', 'cat_level', 'INT(11)  NOT NULL DEFAULT 0  AFTER `cat_id`'); 
        $this->addColumn('user', 'role_id', 'INT(11)  NOT NULL DEFAULT 1  AFTER `cat_level`'); 
        $this->createIndex('index_cat_id', 'user', ['cat_id']);    
        $this->createIndex('index_role_id', 'user', ['role_id']);    
    }

    public function down()
    {
        $this->dropColumn('user', 'cat_id');
        $this->dropColumn('user', 'cat_level');
        $this->dropColumn('user', 'role_id');
    }
}
