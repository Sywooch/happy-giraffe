<?php

class m120328_080502_change_albums extends CDbMigration
{
	public function up()
	{
        $this->execute("
        SET FOREIGN_KEY_CHECKS = 0;
        ALTER TABLE  `album_photos_attaches` DROP FOREIGN KEY  `fk_photo_attach_photo` ;
        ALTER TABLE `album_photos_attaches` DROP PRIMARY KEY;
        SET FOREIGN_KEY_CHECKS = 1;
        ");
	}

	public function down()
	{
		echo "m120328_080502_change_albums does not support migration down.\n";
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