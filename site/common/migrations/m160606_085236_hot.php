<?php

class m160606_085236_hot extends CDbMigration
{
	public function up()
	{
		$this->execute("
		  ALTER TABLE `post__contents` ADD `hotRate` INT(11)  UNSIGNED  NOT NULL  AFTER `buzzMigrate`;
          ALTER TABLE `post__contents` ADD `hotStatus` TINYINT(1)  UNSIGNED  NOT NULL  AFTER `hotRate`;
          ALTER TABLE `post__contents` ADD `isPinned` TINYINT(1)  UNSIGNED  NOT NULL  AFTER `hotStatus`;
          ALTER TABLE `post__contents` ADD INDEX (`hotRate`);
		");
	}

	public function down()
	{
		echo "m160606_085236_hot does not support migration down.\n";
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