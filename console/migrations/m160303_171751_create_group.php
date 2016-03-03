<?php

use yii\db\Migration;

class m160303_171751_create_group extends Migration
{
    public function up()
    {
        $this->createTable('group', [
            'id' => "INT(10)  NOT NULL AUTO_INCREMENT PRIMARY KEY",
            'level' => "INT(11) NOT NULL DEFAULT 0",
            'title' => "VARCHAR(255)  DEFAULT NULL",
        ]);
        $this->createIndex('index_level', 'group', ['level']);
    }

    public function down()
    {
        $this->dropTable('group');
    }
}
