<?php

class m170505_075138_registration_finished extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `users` CHANGE `registration_finished` `registration_finished` TINYINT(1)  NOT NULL  DEFAULT '0';");
		$this->execute("UPDATE users SET registration_finished = 1;");
	}

	public function down()
	{
		echo "m170505_075138_registration_finished does not support migration down.\n";
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