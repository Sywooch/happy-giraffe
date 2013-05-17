<?php

class m130507_082707_friends_lists extends CDbMigration
{
	public function up()
	{
        $this->execute("
           INSERT INTO friends__lists (title, user_id)
            (
              SELECT
              'Коллеги',
              id
               FROM users
            )
            UNION
            (
                SELECT
              'Родственники',
              id
              FROM users
            );
        ");
	}

	public function down()
	{
		echo "m130507_082707_friends_lists does not support migration down.\n";
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