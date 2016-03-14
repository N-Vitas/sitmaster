<?php

use yii\db\Migration;

class m160312_083550_create_comment_ticket extends Migration
{
    public function up()
    {
        $this->createTable('comment_ticket', [
            'id' => "INT(10)  NOT NULL AUTO_INCREMENT PRIMARY KEY",
            'ticket_id' => "INT(10)  DEFAULT NULL",
            'author_id' => "INT(11)  DEFAULT NULL",
            'text' => "MEDIUMTEXT  DEFAULT NULL",
            'status' => "TINYINT(1)  UNSIGNED DEFAULT NULL DEFAULT '1'",
            'created_at' => "INT(10)  UNSIGNED DEFAULT NULL",
        ]);
        $this->createIndex('index_author_id', 'comment_ticket', ['author_id']);
        $this->createIndex('index_ticket_id', 'comment_ticket', ['ticket_id']);
    }

    public function down()
    {
        $this->dropTable('comment_ticket');
    }
}
