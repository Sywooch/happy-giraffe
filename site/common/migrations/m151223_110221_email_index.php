<?php

class m151223_110221_email_index extends CDbMigration
{
	public function up()
	{
		$this->execute('ALTER TABLE `users` ADD INDEX `email` (`email`) USING BTREE ;');
	}

	public function down()
	{
		$this->execute('ALTER TABLE `users` DROP INDEX `email`;');
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