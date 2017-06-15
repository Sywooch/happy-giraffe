<?php

class m170214_112334_create_specialists_chats_comments_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('specialists__chats_comments', [
			'user_id' => 'int(11) unsigned not null',
			'chat_id' => 'int(11) unsigned not null',
			'text' => 'text not null',
		], 'ENGINE=InnoDB CHARSET=utf8');
	}

	public function down()
	{
		$this->dropTable('specialists__chats_comments');
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