<?php

class m120313_060518_change_albums extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `album_photos` ADD `removed` BOOLEAN NOT NULL DEFAULT '0';");
        $this->execute("ALTER TABLE album_photos DROP FOREIGN KEY fk_photo_user;");
        $this->execute("ALTER TABLE `album_photos` CHANGE `user_id` `author_id` INT( 10 ) UNSIGNED NOT NULL;");
        $this->execute("alter table `album_photos` add FOREIGN KEY fk_photo_user (author_id) REFERENCES user(id) ON DELETE cascade on update cascade");
	}

	public function down()
	{
		echo "m120313_060518_change_albums does not support migration down.\n";
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