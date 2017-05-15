<?php

class m170428_081259_create_action_tokens_table extends CDbMigration
{
	private $tableName = 'action_tokens';

	public function up()
	{
		$this->createTable($this->tableName, [
			'user_id' => 'int(11) unsigned not null',
			'action' => 'int(11) unsigned not null',
			'token' => 'varchar(255) not null',
		], 'ENGINE=InnoDB CHARSET=utf8');
	}

	public function down()
	{
		$this->dropTable($this->tableName);
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