<?php

class m111209_104459_post_2 extends CDbMigration
{
	public function up()
	{
		$this->execute("UPDATE `happy_giraffe`.`club_community_content_type` SET `slug` = 'post' WHERE `club_community_content_type`.`id` =1;");
	}

	public function down()
	{
		echo "m111209_104459_post_2 does not support migration down.\n";
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