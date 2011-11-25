<?php

class m110914_075416_product_set extends CDbMigration
{
	public function up()
	{
		$sql = "CREATE TABLE `shop_product_set` (
	`set_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`set_title` VARCHAR(250) NOT NULL,
	`set_text` TEXT NULL,
	PRIMARY KEY (`set_id`)
)
COLLATE='utf8_general_ci'
ENGINE=MyISAM
ROW_FORMAT=DEFAULT";
		$this->execute($sql);
	}

	public function down()
	{
		echo "m110914_075416_product_set does not support migration down.\n";
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