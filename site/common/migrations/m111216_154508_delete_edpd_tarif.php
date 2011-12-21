<?php

class m111216_154508_delete_edpd_tarif extends CDbMigration
{
	private $_table = 'shop__delivery_etarif';
	
	public function up()
	{
		$this->execute("DROP TABLE IF EXISTS `shop__delivery_etarif`");
	}

	public function down()
	{
		echo "m111216_154508_delete_edpd_tarif does not support migration down.\n";
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