<?php

class m121031_083058_video_embed extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE  `community__videos` ADD  `embed` TEXT NOT NULL");
	}

	public function down()
	{
		echo "m121031_083058_video_embed does not support migration down.\n";
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