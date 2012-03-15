<?php

class m120314_151248_change_community extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `club_community` ADD `position` TINYINT( 2 ) UNSIGNED NOT NULL ");
	}

	public function down()
	{
		echo "m120314_151248_change_community does not support migration down.\n";
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