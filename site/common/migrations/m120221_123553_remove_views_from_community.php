<?php

class m120221_123553_remove_views_from_community extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `club_community_content` DROP `views`");
	}

	public function down()
	{
		$this->execute("ALTER TABLE `club_community_content` ADD `views` INT( 11 ) UNSIGNED NOT NULL AFTER `created` ");
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