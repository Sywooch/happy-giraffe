<?php

class m170322_080417_create_founded_doctors_in_session extends CDbMigration
{
	private $tableName = 'founded_doctors_in_sessions';

	public function up()
	{
		$this->createTable($this->tableName, [
			'session_id' => 'int(11) unsigned not null',
			'doctor_id' => 'int(11) unsigned not null',
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