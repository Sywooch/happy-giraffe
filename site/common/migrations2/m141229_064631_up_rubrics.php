<?php

class m141229_064631_up_rubrics extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `community__rubrics` ADD COLUMN `label_id` INT(10) UNSIGNED NULL DEFAULT NULL AFTER `sort`");
	}

	public function down()
	{
		echo "m141229_064631_up_rubrics does not support migration down.\n";
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