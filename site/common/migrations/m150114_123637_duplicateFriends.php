<?php

class m150114_123637_duplicateFriends extends CDbMigration
{
	public function up()
	{
        $this->execute("DELETE f1 FROM friends f1, friends f2 WHERE f1.id > f2.id AND f1.user_id = f2.user_id AND f1.friend_id = f2.friend_id;");
        $this->execute("ALTER TABLE `friends` ADD UNIQUE INDEX (`user_id`, `friend_id`);");
	}

	public function down()
	{
		echo "m150114_123637_duplicateFriends does not support migration down.\n";
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