<?php

class m120206_115718_remove_rating_columns extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `club_community_content` DROP `rating`");
        $this->execute("ALTER TABLE `club_contest_work` DROP `work_rate`");

	}

	public function down()
	{
		echo "m120206_115718_remove_rating_columns does not support migration down.\n";
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