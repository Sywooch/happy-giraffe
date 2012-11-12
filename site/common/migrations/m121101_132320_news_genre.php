<?php

class m121101_132320_news_genre extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `community__posts` ADD  `genre` ENUM(  'lenta',  'message',  'article',  'interview' ) NULL");
	}

	public function down()
	{
		echo "m121101_132320_news_genre does not support migration down.\n";
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