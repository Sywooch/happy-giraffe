<?php

class m140129_034056_mark_my_messages_as_reded extends CDbMigration
{
	public function up()
	{
		$this->execute("UPDATE `messaging__messages_users`
    JOIN `messaging__messages` ON
        `messaging__messages_users`.`user_id` = `messaging__messages`.`author_id` AND
        `messaging__messages_users`.`message_id` = `messaging__messages`.`id`
    SET `messaging__messages_users`.`dtime_read` = `messaging__messages`.`created`
    WHERE `messaging__messages_users`.`dtime_read` IS NULL");
	}

	public function down()
	{
		echo "m140129_034056_mark_my_messages_as_reded does not support migration down.\n";
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