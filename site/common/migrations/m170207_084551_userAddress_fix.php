<?php

class m170207_084551_userAddress_fix extends CDbMigration
{
	public function up()
	{
		$this->execute("
		INSERT INTO geo__user_address
		(user_id)
		SELECT u.id
		FROM users u
		LEFT OUTER JOIN geo__user_address a ON a.user_id = u.id
		WHERE a.user_id IS NULL;
		");
	}

	public function down()
	{
		echo "m170207_084551_userAddress_fix does not support migration down.\n";
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