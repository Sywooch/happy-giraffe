<?php

class m111216_131903_delete_egruzovozoff extends CDbMigration
{
	private $_table = 'shop__delivery_egruzovozoff';
	
	public function up()
	{
		$this->execute("DROP TABLE IF EXISTS `shop__delivery_egruzovozoff`");
	}

	public function down()
	{
		echo "m111216_131903_delete_egruzovozoff does not support migration down.\n";
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