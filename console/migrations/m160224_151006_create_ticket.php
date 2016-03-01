<?php

use yii\db\Migration;

class m160224_151006_create_ticket extends Migration
{
    public function up()
    {
        $this->createTable('ticket', [
            'id' => "INT(10)  NOT NULL AUTO_INCREMENT PRIMARY KEY",
            'user_id' => "INT(11)  DEFAULT NULL",
            'agent_id' => "INT(11)  DEFAULT NULL",
            'cat_id' => "INT(11)  DEFAULT NULL",
            'cat_level' => "INT(11)  DEFAULT NULL",
            'priorited' => "VARCHAR(255)  DEFAULT NULL",
            'title' => "VARCHAR(255)  DEFAULT NULL",
            'text' => "MEDIUMTEXT  DEFAULT NULL",
            'files' => "MEDIUMTEXT  DEFAULT NULL",
            'json' => "MEDIUMTEXT  DEFAULT NULL",
            'status' => "TINYINT(1)  UNSIGNED DEFAULT NULL DEFAULT '1'",
            'callback' => "MEDIUMTEXT  DEFAULT NULL",
            'created_at' => "INT(10)  UNSIGNED DEFAULT NULL",
            'updated_at' => "INT(10)  UNSIGNED DEFAULT NULL",
            'closed_at' => "INT(10)  UNSIGNED DEFAULT NULL",
        ]);
        $this->createIndex('index_user_id', 'ticket', ['user_id']);
        $this->createIndex('index_agent_id', 'ticket', ['agent_id']);
        $this->createIndex('index_cat_id', 'ticket', ['cat_id']);
        $this->createIndex('index_cat_level', 'ticket', ['cat_level']);
        $this->createIndex('index_status', 'ticket', ['status']);
    }

    public function down()
    {
        $this->dropTable('ticket');
    }
}
