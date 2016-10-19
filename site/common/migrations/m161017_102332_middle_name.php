<?php

class m161017_102332_middle_name extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `users` ADD `middle_name` VARCHAR(255)  NOT NULL  DEFAULT ''  AFTER `specialistInfo`;");
	}

	public function down()
	{
		echo "m161017_102332_middle_name does not support migration down.\n";
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