<?php

class m120718_123758_multivarka extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `cook__recipes` ADD `section` INT( 1 ) UNSIGNED NOT NULL DEFAULT '0'");
	}

	public function down()
	{
		echo "m120718_123758_multivarka does not support migration down.\n";
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