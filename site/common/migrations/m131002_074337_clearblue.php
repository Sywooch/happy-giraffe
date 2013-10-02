<?php

class m131002_074337_clearblue extends CDbMigration
{
	public function up()
	{
        $this->execute("UPDATE `test__tests` SET `start_image` = 'bg_test_pregnancy__clearblue.jpg' WHERE `id` = '3';");
	}

	public function down()
	{
		echo "m131002_074337_clearblue does not support migration down.\n";
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