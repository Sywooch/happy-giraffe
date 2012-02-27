<?php

class m120226_092157_change_user_table extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `user` ADD `blocked` BOOLEAN NOT NULL DEFAULT '0' AFTER `deleted`");
	}

	public function down()
	{
		echo "m120226_092157_change_user_table does not support migration down.\n";
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