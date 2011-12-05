<?php

class m111205_222315_meta_tags extends CDbMigration
{
	public function up()
	{
		$this->execute("
ALTER TABLE `club_community_content` ADD `meta_title` VARCHAR( 255 ) NOT NULL ,
ADD `meta_keywords` VARCHAR( 255 ) NOT NULL ,
ADD `meta_description` VARCHAR( 255 ) NOT NULL ;
		");
	}

	public function down()
	{
		echo "m111205_222315_meta_tags does not support migration down.\n";
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