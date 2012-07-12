<?php

class m120711_120702_uniqueness extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `community__contents` ADD `uniqueness` INT NULL");
	}

	public function down()
	{
		echo "m120711_120702_uniqueness does not support migration down.\n";
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