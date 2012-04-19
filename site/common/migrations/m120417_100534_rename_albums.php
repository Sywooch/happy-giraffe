<?php

class m120417_100534_rename_albums extends CDbMigration
{
	public function up()
	{
        $this->renameTable('albums','album__albums');
        $this->renameTable('album_photos','album__photos');
        $this->renameTable('album_photos_attaches','album__photo_attaches');
	}

	public function down()
	{
		echo "m120417_100534_rename_albums does not support migration down.\n";
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