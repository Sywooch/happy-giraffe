<?php

class m110903_085832_category extends CDbMigration
{
	public function up()
	{
		$sql = "CREATE TABLE `shop_category` (
	`category_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`category_root` INT(10) UNSIGNED NOT NULL,
	`category_lft` INT(10) UNSIGNED NOT NULL,
	`category_rgt` INT(10) UNSIGNED NOT NULL,
	`category_level` SMALLINT(5) UNSIGNED NOT NULL,
	`category_name` VARCHAR(150) NOT NULL,
	`category_text` TEXT NOT NULL,
	`category_keywords` VARCHAR(250) NOT NULL,
	`category_description` VARCHAR(250) NOT NULL,
	PRIMARY KEY (`category_id`),
	INDEX `category_lft` (`category_lft`),
	INDEX `category_rgt` (`category_rgt`),
	INDEX `category_level` (`category_level`),
	INDEX `category_root` (`category_root`)
)
COMMENT='Категории товаров'
COLLATE='utf8_general_ci'
ENGINE=MyISAM
ROW_FORMAT=DEFAULT";
		$this->execute($sql);
	}

	public function down()
	{
		echo "m110903_085832_category does not support migration down.\n";
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