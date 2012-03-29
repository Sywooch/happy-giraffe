<?php

class m120329_110639_change_albums extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `albums` ADD `type` TINYINT NOT NULL DEFAULT '0' AFTER `author_id`");
        $this->execute("ALTER TABLE `album_photos_attaches` ADD `id` INT( 10 ) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST ");
        $this->execute("ALTER TABLE `album_photos_attaches`
          ADD CONSTRAINT `fk_album_photos_attaches_photo` FOREIGN KEY (`photo_id`) REFERENCES `album_photos` (`id`)
          ON DELETE CASCADE ON UPDATE CASCADE;");
	}

	public function down()
	{
		echo "m120329_110639_change_albums does not support migration down.\n";
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