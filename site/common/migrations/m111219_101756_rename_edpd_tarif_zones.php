<?php

class m111219_101756_rename_edpd_tarif_zones extends CDbMigration
{
	public function up()
	{
		$sql = "
			 ALTER TABLE `shop_delivery_edpd_tarifzones` RENAME AS `shop_delivery_edpd_tarifzone`
		";
		$this->execute($sql);
	}

	public function down()
	{
		$sql = "
			ALTER TABLE `shop_delivery_edpd_tarifzone` RENAME AS `shop_delivery_edpd_tarifzones`
		";
		$this->execute($sql);
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