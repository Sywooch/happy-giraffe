<?php

class m151020_114940_buzzMigrate extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `post__contents` ADD `buzzMigrate` TINYINT(1)  NOT NULL  AFTER `views`;");
	}

	public function down()
	{
		echo "m151020_114940_buzzMigrate does not support migration down.\n";
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