<?php

class m150129_082356_views extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `post__contents` ADD `views` INT(11)  UNSIGNED  NOT NULL  AFTER `template`;");
	}

	public function down()
	{
		echo "m150129_082356_views does not support migration down.\n";
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