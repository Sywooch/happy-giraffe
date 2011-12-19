<?php

class m111219_111509_alter_edpd_tarifzone extends CDbMigration
{
	public function up()
	{
		$sql = "
			ALTER TABLE `shop_delivery_edpd_tarifzone` MODIFY COLUMN `city` VARCHAR(255) NOT NULL
		";
		$this->execute($sql);
	}

	public function down()
	{
		echo "m111219_111509_alter_edpd_tarifzone does not support migration down.\n";
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