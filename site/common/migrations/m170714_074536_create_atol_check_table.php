<?php

class m170714_074536_create_atol_check_table extends CDbMigration
{
	private $tableName = 'atol_check';

	public function up()
	{
		$this->createTable($this->tableName, [
			'id' => 'pk',
			'kkt_id' => 'int(11) unsigned not null',
			'payment_id' => 'int(11) unsigned not null',
			'status' => 'varchar(255) not null',
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