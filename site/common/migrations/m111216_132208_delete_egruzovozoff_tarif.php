<?php

class m111216_132208_delete_egruzovozoff_tarif extends CDbMigration
{
	private $_table = 'shop__delivery_egruzovozofftarif';
	
	public function up()
	{
		$this->dropTable($this->_table);
	}

	public function down()
	{
		echo "m111216_132208_delete_egruzovozoff_tarif does not support migration down.\n";
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