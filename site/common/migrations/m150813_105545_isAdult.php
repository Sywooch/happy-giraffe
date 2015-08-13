<?php

class m150813_105545_isAdult extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `post__contents` ADD `isAdult` TINYINT(1)  NOT NULL  AFTER `isRemoved`;");
	}

	public function down()
	{
		echo "m150813_105545_isAdult does not support migration down.\n";
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