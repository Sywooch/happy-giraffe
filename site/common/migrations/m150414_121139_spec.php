<?php

class m150414_121139_spec extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `users` ADD `specInfo` TEXT  NOT NULL  AFTER `avatarInfo`;");
	}

	public function down()
	{
		echo "m150414_121139_spec does not support migration down.\n";
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