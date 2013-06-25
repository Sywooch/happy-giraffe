<?php

class m130625_061843_blog_settings extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `users` CHANGE `blog_title` `blog_title` VARCHAR(50)  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NOT NULL  DEFAULT '';");
        $this->execute("ALTER TABLE `users` ADD `blog_description` VARCHAR(150)  NOT NULL  DEFAULT ''  AFTER `blog_title`;");
        $this->execute("ALTER TABLE `users` ADD `blog_photo_id` INT(11)  UNSIGNED  NULL  DEFAULT NULL  AFTER `blog_description`;");
        $this->execute("ALTER TABLE `users` ADD CONSTRAINT `blog_photo` FOREIGN KEY (`blog_photo_id`) REFERENCES `album__photos` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;");
        $this->execute("ALTER TABLE `users` ADD `blog_photo_position` TEXT  NOT NULL  AFTER `blog_photo_id`;");
	}

	public function down()
	{
		echo "m130625_061843_blog_settings does not support migration down.\n";
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