<?php

class m141227_141704_avatar2 extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `users` ADD INDEX (`avatarId`);");
	}

	public function down()
	{
		echo "m141227_141704_avatar2 does not support migration down.\n";
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