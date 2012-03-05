<?php

class m120305_083549_change_comments extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `comment` ADD `quote_text` TEXT NOT NULL AFTER `quote_id` ");
	}

	public function down()
	{
		echo "m120305_083549_change_comments does not support migration down.\n";
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