<?php

class m120802_163556_email_confirmed extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `users` ADD `email_confirmed` BOOLEAN NOT NULL ");
	}

	public function down()
	{
		echo "m120802_163556_email_confirmed does not support migration down.\n";
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