<?php

class m160331_074921_sectionsSort extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `community__sections` ADD `sort` TINYINT(3)  UNSIGNED  NOT NULL  AFTER `color`;");
		$this->execute("
UPDATE `community__sections` SET `sort` = '1' WHERE `id` = '1';
UPDATE `community__sections` SET `sort` = '2' WHERE `id` = '2';
UPDATE `community__sections` SET `sort` = '3' WHERE `id` = '3';
UPDATE `community__sections` SET `sort` = '5' WHERE `id` = '5';
UPDATE `community__sections` SET `sort` = '6' WHERE `id` = '6';");
	}

	public function down()
	{
		echo "m160331_074921_sectionsSort does not support migration down.\n";
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