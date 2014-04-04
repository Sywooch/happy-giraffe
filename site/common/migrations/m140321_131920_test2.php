<?php

class m140321_131920_test2 extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `age_ranges` ADD `test2` INT(11)  NOT NULL  AFTER `position`;");
	}

	public function down()
	{
		echo "m140321_131920_test2 does not support migration down.\n";
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