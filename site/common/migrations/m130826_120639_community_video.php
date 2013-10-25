<?php

class m130826_120639_community_video extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `community__videos` DROP `player_favicon`;");
        $this->execute("ALTER TABLE `community__videos` DROP `player_title`;");
	}

	public function down()
	{
		echo "m130826_120639_community_video does not support migration down.\n";
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