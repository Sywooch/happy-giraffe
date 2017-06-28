<?php

class m170206_101442_create_specialists__chats_rating_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('specialists__chats_rating', [
			'specialist_id' => 'int(11) unsigned not null',
			'chat_id' => 'int(11) unsigned not null',
			'rating' => 'int(10) unsigned not null'
		], 'ENGINE=InnoDB CHARSET=utf8');
	}

	public function down()
	{
		$this->dropTable('specialists__chats_rating');
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