<?php

class m110913_142529_shop_product_type extends CDbMigration
{
	public function up()
	{
		$sql = "CREATE TABLE `shop_product_type` (
	`type_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`type_title` VARCHAR(150) NOT NULL,
	`type_text` TEXT NULL,
	`type_image` VARCHAR(250) NULL DEFAULT NULL,
	`type_time` INT(10) UNSIGNED NOT NULL,
	`type_attribute_set_id` INT(10) UNSIGNED NOT NULL,
	PRIMARY KEY (`type_id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
ROW_FORMAT=DEFAULT";
		$this->execute($sql);
	}

	public function down()
	{
		echo "m110913_142529_shop_product_type does not support migration down.\n";
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