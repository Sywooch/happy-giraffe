<?php

class m111206_100443_by_happy_giraffe extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `club_community_content` ADD `by_happy_giraffe` BOOLEAN NOT NULL ");
	}

	public function down()
	{
		echo "m111206_100443_by_happy_giraffe does not support migration down.\n";
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