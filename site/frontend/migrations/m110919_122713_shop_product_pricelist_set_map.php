<?php

class m110919_122713_shop_product_pricelist_set_map extends CDbMigration
{
	public function up()
	{
		$sql = "CREATE TABLE `shop_product_pricelist_set_map` (
	`map_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`map_set_id` INT(10) UNSIGNED NOT NULL,
	`map_pricelist_id` INT(10) UNSIGNED NOT NULL,
	`map_set_price` DECIMAL(10,2) UNSIGNED NOT NULL,
	PRIMARY KEY (`map_id`),
	INDEX `map_set_id` (`map_set_id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
ROW_FORMAT=DEFAULT";

		$this->execute($sql);
	}

	public function down()
	{
		echo "m110919_122713_shop_product_pricelist_set_map does not support migration down.\n";
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