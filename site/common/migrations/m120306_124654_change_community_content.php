<?php

class m120306_124654_change_community_content extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `club_community_content` ADD `preview` TEXT NOT NULL AFTER `type_id`");
	}

	public function down()
	{
		echo "m120306_124654_change_community_content does not support migration down.\n";
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