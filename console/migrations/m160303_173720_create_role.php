<?php

use yii\db\Migration;

class m160303_173720_create_role extends Migration
{
    public function up()
    {
        $this->createTable('role', [
            'id' => "INT(10)  NOT NULL AUTO_INCREMENT PRIMARY KEY",
            'title' => "VARCHAR(255)  DEFAULT NULL",
        ]);
        $this->insert('role',[
            'id'=>1,
            'title' => 'Пользователь'
        ]);
        $this->insert('role',[
            'id'=>2,
            'title' => 'Сотрудник'
        ]);
        $this->insert('role',[
            'id'=>3,
            'title' => 'Директор'
        ]);
        $this->insert('role',[
            'id'=>4,
            'title' => 'Администратор'
        ]);
    }

    public function down()
    {
        $this->dropTable('role');
    }
}
