<?php

class m120329_121214_change_albums extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `albums` ADD `permission` TINYINT NOT NULL DEFAULT '0' AFTER `type` ");
	}

	public function down()
	{
		echo "m120329_121214_change_albums does not support migration down.\n";
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