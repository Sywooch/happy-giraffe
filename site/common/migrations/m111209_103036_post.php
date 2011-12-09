<?php

class m111209_103036_post extends CDbMigration
{
	public function up()
	{
		$this->execute("RENAME TABLE `happy_giraffe`.`club_community_article` TO `happy_giraffe`.`club_community_post` ;");
	}

	public function down()
	{
		echo "m111209_103036_post does not support migration down.\n";
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