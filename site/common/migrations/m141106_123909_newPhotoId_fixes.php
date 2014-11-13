<?php

class m141106_123909_newPhotoId_fixes extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `album__photos` ADD INDEX (`newPhotoId`);");
        $this->execute("ALTER TABLE `album__photos` ADD FOREIGN KEY (`newPhotoId`) REFERENCES `photo__photos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;");
	}

	public function down()
	{
		echo "m141106_123909_newPhotoId_fixes does not support migration down.\n";
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