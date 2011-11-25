<?php

class m110913_142451_shop_product_image extends CDbMigration
{
	public function up()
	{
		$sql = "CREATE TABLE `shop_product` (
	`product_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`product_type_id` INT(10) UNSIGNED NOT NULL,
	`product_title` VARCHAR(150) NOT NULL,
	`product_slug` VARCHAR(150) NOT NULL,
	`product_text` TEXT NULL,
	`product_image` VARCHAR(250) NULL DEFAULT NULL,
	`product_keywords` VARCHAR(250) NULL DEFAULT NULL,
	`product_description` VARCHAR(250) NULL DEFAULT NULL,
	`product_time` INT(10) UNSIGNED NOT NULL,
	`product_rate` TINYINT(4) NULL DEFAULT '0',
	`product_attribute_set_id` INT(10) UNSIGNED NOT NULL,
	PRIMARY KEY (`product_id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
ROW_FORMAT=DEFAULT";

		$this->execute($sql);
	}

	public function down()
	{
		echo "m110913_142451_shop_product_image does not support migration down.\n";
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