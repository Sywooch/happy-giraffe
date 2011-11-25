<?php

class m110903_101207_attribute extends CDbMigration
{
//	public function up()
//	{
//	}

	public function down()
	{
		echo "m110903_101207_attribute does not support migration down.\n";
		return false;
	}

	public function safeUp()
	{
		$sql = "CREATE TABLE `shop_product_attribute` (
	`attribute_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`attribute_title` VARCHAR(50) NOT NULL,
	`attribute_text` TEXT NULL,
	`attribute_type` TINYINT(5) UNSIGNED NOT NULL,
	`attribute_required` TINYINT(1) UNSIGNED NOT NULL,
	`attribute_is_insearch` TINYINT(1) UNSIGNED NOT NULL,
	PRIMARY KEY (`attribute_id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
ROW_FORMAT=DEFAULT;";
		$this->execute($sql);

		$sql = "CREATE TABLE `shop_product_attribute_set` (
	`set_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`set_title` VARCHAR(50) NOT NULL,
	`set_text` TEXT NULL,
	PRIMARY KEY (`set_id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
ROW_FORMAT=DEFAULT;";
		$this->execute($sql);

		$sql = "CREATE TABLE IF NOT EXISTS `shop_product_attribute_set_map` (
  `map_id` int(10) unsigned NOT NULL auto_increment,
  `map_set_id` int(10) unsigned NOT NULL,
  `map_attribute_id` int(10) unsigned NOT NULL,
  `map_attribute_title` varchar(2) NOT NULL,
  PRIMARY KEY  (`map_id`),
  UNIQUE KEY `map_set_id` (`map_set_id`,`map_attribute_title`),
  KEY `map_attribute_id` (`map_attribute_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
		$this->execute($sql);

		$sql = "CREATE TABLE `shop_product_attribute_value` (
	`value_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`value_value` VARCHAR(150) NOT NULL,
	PRIMARY KEY (`value_id`),
	UNIQUE INDEX `value_value` (`value_value`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
ROW_FORMAT=DEFAULT;";
		$this->execute($sql);

		$sql = "CREATE TABLE `shop_product_attribute_value_map` (
	`map_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`map_attribute_id` INT(10) UNSIGNED NOT NULL,
	`map_value_id` INT(10) UNSIGNED NOT NULL,
	PRIMARY KEY (`map_id`),
	INDEX `map_attribute_id` (`map_attribute_id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
ROW_FORMAT=DEFAULT;";
		$this->execute($sql);
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeDown()
	{
	}
	*/
}