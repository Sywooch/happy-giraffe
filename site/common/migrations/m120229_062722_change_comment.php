<?php

class m120229_062722_change_comment extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `comment` ADD `response_id` INT UNSIGNED NOT NULL ");
        $this->execute("ALTER TABLE `comment` ADD `quote_id` INT UNSIGNED NOT NULL ");
	}

	public function down()
	{
		echo "m120229_062722_change_comment does not support migration down.\n";
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