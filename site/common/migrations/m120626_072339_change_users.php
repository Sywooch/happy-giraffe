<?php

class m120626_072339_change_users extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `users` ADD `remember_code` MEDIUMINT( 5 ) NOT NULL ");
	}

	public function down()
	{
		echo "m120626_072339_change_users does not support migration down.\n";
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