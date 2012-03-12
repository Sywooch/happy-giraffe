<?php

class m120312_131016_change_albums extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `album_photos` ADD `title` VARCHAR( 50 ) NOT NULL AFTER `fs_name`");
	}

	public function down()
	{
		echo "m120312_131016_change_albums does not support migration down.\n";
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