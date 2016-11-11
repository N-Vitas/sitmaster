<?php

use yii\db\Migration;

class m161111_171430_insert_base_data extends Migration
{
    public function up()
    {
        $this->insert('group',['id' => 1,'level' => 0,'title' => 'MangaSushi']);
        $this->insert('group',['id' => 2,'level' => 1,'title' => 'MangaSushi на Гоголя']);
        $this->insert('group',['id' => 3,'level' => 1,'title' => 'MangaSushi на Байтурсынова']);
        $this->insert('group',['id' => 4,'level' => 0,'title' => 'ProRest']);
        $this->insert('group',['id' => 5,'level' => 1,'title' => 'MangaSushi Офис']);

        $this->insert('user_group',['id' => 1,'user_id' => 1,'group_id' => 1]);
        $this->insert('user_group',['id' => 2,'user_id' => 1,'group_id' => 2]);
        $this->insert('user_group',['id' => 3,'user_id' => 1,'group_id' => 3]);
        $this->insert('user_group',['id' => 4,'user_id' => 1,'group_id' => 4]);
        $this->insert('user_group',['id' => 5,'user_id' => 1,'group_id' => 5]);

        $this->addColumn('profile', 'jobs', $this->string());
        $this->addColumn('profile', 'phone', $this->string(20));

        $this->insert('profile',[
            'user_id' => 1,
            'name' => 'Атрешкевич Максим',
            'public_email' => 'nikonov.vitas@gmail.com',
            'gravatar_email' => 'nikonov.vitas@gmail.com',
            'gravatar_id' => NULL,
            'location' => 'Алматы',
            'phone' => '+77077487410',
            'jobs' => '',
            'website' => 'sitmaster.kz',
            'bio' => NULL
        ]);

    }
    public function down()
    {
        echo "m161111_171430_insert_base_data cannot be reverted.\n";

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
