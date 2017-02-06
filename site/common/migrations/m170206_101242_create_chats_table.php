<?php

class m170206_101242_create_chats_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('chats', [
			'id' => 'pk',
			'created_at' => 'int(10) unsigned not null',
			'expires_in' => 'int(10) unsigned default null',
			'limit' => 'int(10) unsigned default null',
			'type' => 'int(10) unsigned default 0',
		], 'ENGINE=InnoDB CHARSET=utf8');
	}

	public function down()
	{
		$this->dropTable('chats');
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