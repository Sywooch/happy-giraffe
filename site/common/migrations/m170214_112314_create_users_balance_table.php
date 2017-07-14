<?php

class m170214_112314_create_users_balance_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('users_balance', [
			'user_id' => 'int(11) unsigned not null',
			'sum' => 'int(11) unsigned default 0',
		], 'ENGINE=InnoDB CHARSET=utf8');
	}

	public function down()
	{
		$this->dropTable('users_balance');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}