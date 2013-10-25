<?php

class m131009_113523_contests_update extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `community__contests` ADD `rubric_id` INT(11)  UNSIGNED  NOT NULL  AFTER `forum_id`;");
        $this->execute("ALTER TABLE `community__contests` ADD INDEX `rubric_id` (`rubric_id`);");
	}

	public function down()
	{
		echo "m131009_113523_contests_update does not support migration down.\n";
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