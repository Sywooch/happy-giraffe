<?php

class m111219_131250_delete_shop__delivery_epickpointtarif extends CDbMigration
{
	private $_table = 'shop__delivery_epickpointtarif';
	
	public function up()
	{
		$this->dropTable($this->_table);
	}

	public function down()
	{
		echo "m111219_131250_delete_shop__delivery_epickpointtarif does not support migration down.\n";
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