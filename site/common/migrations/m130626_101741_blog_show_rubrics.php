<?php

class m130626_101741_blog_show_rubrics extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `users` ADD `blog_show_rubrics` BOOL  NOT NULL  DEFAULT '1'   AFTER `blog_photo_position`;");
	}

	public function down()
	{
		echo "m130626_101741_blog_show_rubrics does not support migration down.\n";
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