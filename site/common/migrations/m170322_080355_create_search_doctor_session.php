<?php

class m170322_080355_create_search_doctor_session extends CDbMigration
{
	private $tableName = 'search_doctors_sessions';

	public function up()
	{
		$this->createTable($this->tableName, [
			'id' => 'pk',
			'user_id' => 'int(11) unsigned not null',
			'expires_in' => 'int(10) unsigned default null',
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