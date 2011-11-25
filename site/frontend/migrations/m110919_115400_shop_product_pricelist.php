<?php

class m110919_115400_shop_product_pricelist extends CDbMigration
{
	public function up()
	{
		$sql = "CREATE TABLE `shop_product_pricelist` (
	`pricelist_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`pricelist_title` VARCHAR(250) NOT NULL,
	`price_list_settings` TEXT NOT NULL,
	PRIMARY KEY (`pricelist_id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
ROW_FORMAT=DEFAULT";

		$this->execute($sql);
	}

	public function down()
	{
		echo "m110919_115400_shop_product_pricelist does not support migration down.\n";
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