<?php

class m120713_111415_blog_title extends CDbMigration
{
	public function up()
	{
        $this->execute('ALTER TABLE `users` ADD `blog_title` VARCHAR( 255 ) NULL ');
	}

	public function down()
	{
		echo "m120713_111415_blog_title does not support migration down.\n";
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