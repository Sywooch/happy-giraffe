<?php

class m141117_090107_newAlbumId extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `album__albums` ADD `newAlbumId` INT(11)  UNSIGNED  NULL  DEFAULT NULL  AFTER `removed`;");
	}

	public function down()
	{
		echo "m141117_090107_newAlbumId does not support migration down.\n";
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