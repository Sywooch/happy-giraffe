<?php

class m110923_183526_set_to_product extends CDbMigration
{
	public function up()
	{
		$sql = "ALTER TABLE `shop_product_pricelist_set_map`
	CHANGE COLUMN `map_set_id` `map_set_id` INT(10) UNSIGNED NULL AFTER `map_id`,
	ADD COLUMN `map_product_id` INT(10) UNSIGNED NOT NULL AFTER `map_pricelist_id`,
	ADD INDEX `map_product_id` (`map_product_id`)";

		$this->execute($sql);
	}

	public function down()
	{
		$sql = "ALTER TABLE `shop_product_pricelist_set_map`
	CHANGE COLUMN `map_set_id` `map_set_id` INT(10) UNSIGNED NOT NULL AFTER `map_id`,
	DROP COLUMN `map_product_id`";

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