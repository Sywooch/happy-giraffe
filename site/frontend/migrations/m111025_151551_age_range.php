<?php
class m111025_151551_age_range extends CDbMigration
{
	public function up()
	{
		$this->execute("CREATE TABLE `age_range` (
	`range_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`range_title` VARCHAR(50) NOT NULL,
	`range_order` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	PRIMARY KEY (`range_id`),
	INDEX `range_order` (`range_order`)
);");
		
		
	}
	

	public function down()
	{
		echo "m111025_151551_age_range does not support migration down.\n";
		return false;
		
		$this->execute("");
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
