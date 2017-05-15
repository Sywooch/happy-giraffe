<?php

class m170503_073450_create_chat_cstatistic_history_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('chat__statistics_history', [
			'user_id' => 'int(11) unsigned not null',
			'conducted_chats_count' => 'int(11) unsigned default 0',
			'skipped_chats_count' => 'int(11) unsigned default 0',
			'failed_chats_count' => 'int(11) unsigned default 0',
			'date' => 'TIMESTAMP(6)'
		], 'ENGINE=InnoDB CHARSET=utf8');
	}

	public function down()
	{
		$this->dropTable('chat__statistics_history');
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