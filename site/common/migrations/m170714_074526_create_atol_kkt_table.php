<?php

class m170714_074526_create_atol_kkt_table extends CDbMigration
{
	private $tableName = 'atol_kkt';

	public function up()
	{
		$this->createTable($this->tableName, [
			'id' => 'pk',
			'inn' => 'varchar(255) not null',
			'address' => 'varchar(255) not null',
			'callback_url' => 'varchar(255) not null',
			'code' => 'varchar(255) not null',
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