<?php

class m130822_122628_blog_title extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `users` CHANGE `blog_title` `blog_title` VARCHAR(50)  CHARACTER SET utf8  COLLATE utf8_unicode_ci  NULL  DEFAULT NULL;");
        $this->execute("UPDATE `users` SET `blog_title` = NULL WHERE `blog_title` = '';");
	}

	public function down()
	{
		echo "m130822_122628_blog_title does not support migration down.\n";
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