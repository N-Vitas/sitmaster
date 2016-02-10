<?php

use yii\db\Schema;
use yii\db\Migration;

class m150223_095324_seed_rbac_root extends Migration
{
    public function up()
    {
    	$this->insert('user',[
    		'id'=>1,
			'username' => 'Admin',
			'email' => 'root@vesna.kz',
			'password_hash' => \Yii::$app->security->generatePasswordHash('123456'),
			'auth_key' => \Yii::$app->security->generateRandomString(),
			'confirmed_at' => time(),
			'created_at' => time(),
			'updated_at' => time(),
		]);

    	// Создаем правило "Доступ везде"
    	$this->insert('auth_item',[
    		'name' => '/*',
    		'type' => 2,
    		'created_at' => time(),
    		'updated_at' => time(),
    	]);

    	// Добавляем админа
		$this->insert('auth_item',[
			'name' => 'admin',
			'type' => 1,
			'created_at' => time(),
			'updated_at' => time(),
		]);

		// Связываем админа с правилом
		$this->insert('auth_item_child',[
			'parent' => 'admin',
			'child' => '/*',
		]);

		// Связываем админа с правилом
		$this->insert('auth_assignment',[
			'item_name' => 'admin',
			'user_id' => '1',
			'created_at' => time(),
		]);
    }

    public function down()
    {

		$this->delete('auth_assignment','user_id=:p_id AND item_name=:p_name',[
    		':p_id'=>1,
    		':p_name'=>'admin',
		]);

		$this->delete('auth_item_child','child=:p_child AND parent=:p_name',[
    		':p_child'=>'/*',
    		':p_name'=>'admin',
		]);


        $this->delete('auth_item','type=:p_type AND name=:p_name',[
    		':p_type'=>1,
    		':p_name'=>'admin',
		]);

		$this->delete('auth_item','type=:p_type AND name=:p_name',[
    		':p_type'=>2,
    		':p_name'=>'/*',
		]);

		$this->delete('user','id=:p_id AND username=:p_name',[
    		':p_id'=>1,
    		':p_name'=>'Admin',
		]);

        return true;
    }
}
