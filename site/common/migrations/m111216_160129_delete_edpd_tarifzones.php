<?php

class m111216_160129_delete_edpd_tarifzones extends CDbMigration
{
	private $_table = 'shop__delivery_etarifzones';
	
	public function up()
	{
		$this->dropTable($this->_table);
	}

	public function down()
	{
		echo "m111216_160129_delete_edpd_tarifzones does not support migration down.\n";
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