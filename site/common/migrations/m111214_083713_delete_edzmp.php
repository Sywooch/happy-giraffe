<?php

class m111214_083713_delete_edzmp extends CDbMigration
{
	public function up()
	{
		$this->dropTable('shop__delivery_edzpm');
	}

	public function down()
	{
		echo "m111214_083713_delete_edzmp does not support migration down.\n";
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