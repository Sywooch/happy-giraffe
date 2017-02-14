<?php

class m170214_112250_create_specialist_chats_statistics_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('specialist__chats_statistics', [
			'user_id' => 'int(11) unsigned not null',
			'conducted_chats_count' => 'int(11) unsigned default 0',
			'skipped_chats_count' => 'int(11) unsigned default 0',
			'failed_chats_count' => 'int(11) unsigned default 0'
		], 'ENGINE=InnoDB CHARSET=utf8');
	}

	public function down()
	{
		$this->dropTable('specialist__chats_statistics');
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