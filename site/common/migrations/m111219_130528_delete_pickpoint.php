<?php

class m111219_130528_delete_pickpoint extends CDbMigration
{
	private $_table = 'shop__delivery_epickpoint';
	
	public function up()
	{
		$this->dropTable($this->_table);
	}

	public function down()
	{
		echo "m111219_130528_delete_pickpoint does not support migration down.\n";
		return false;
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