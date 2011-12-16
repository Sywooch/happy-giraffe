<?php

class m111216_153956_delete_edpd_table extends CDbMigration
{
	private $_table = 'shop__delivery_edpm';
	
	public function up()
	{
		$this->dropTable($this->_table);
	}

	public function down()
	{
		echo "m111216_153956_delete_edpd_table does not support migration down.\n";
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