<?php

class m130823_084825_blog_position extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `users` CHANGE `blog_photo_position` `blog_photo_position` VARCHAR(255)  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NULL  DEFAULT NULL;");
        $this->execute("UPDATE users SET blog_photo_position = NULL WHERE blog_photo_position = '';");
	}

	public function down()
	{
		echo "m130823_084825_blog_position does not support migration down.\n";
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