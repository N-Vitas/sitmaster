<?php

use yii\db\Migration;

class m160304_040236_create_user_group extends Migration
{
    public function up()
    {
        $this->createTable('user_group', [
            'id' => $this->primaryKey(),
            'user_id' => 'INT(11)  DEFAULT NULL',
            'group_id' => 'INT(10) DEFAULT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('user_group');
    }
}
