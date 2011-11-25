<?php

class m110914_092745_product_set_map extends CDbMigration
{
	public function up()
	{
		$sql = "CREATE TABLE `shop_product_set_map` (
	`map_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`map_set_id` INT(10) UNSIGNED NOT NULL,
	`map_product_id` INT(10) UNSIGNED NOT NULL,
	INDEX `map_set_id` (`map_set_id`),
	PRIMARY KEY (`map_id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
ROW_FORMAT=DEFAULT";

		$this->execute($sql);
	}

	public function down()
	{
		echo "m110914_092745_product_set_map does not support migration down.\n";
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