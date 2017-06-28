<?php

class m170206_101303_create_users_cahts_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('users_chats', [
			'user_id' => 'int(11) unsigned not null',
			'chat_id' => 'int(11) unsigned not null'
		], 'ENGINE=InnoDB CHARSET=utf8');
	}

	public function down()
	{
		$this->dropTable('users_chats');
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