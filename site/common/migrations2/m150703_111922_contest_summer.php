<?php

class m150703_111922_contest_summer extends CDbMigration
{
	public function up()
	{
		$this->execute("ALTER TABLE `commentators__contests` ADD `title` VARCHAR(255)  NOT NULL  DEFAULT ''  AFTER `endDate`;");
		$this->execute("ALTER TABLE `commentators__contests` ADD `cssClass` VARCHAR(32)  NOT NULL  DEFAULT ''  AFTER `title`;");
	}

	public function down()
	{
		echo "m150703_111922_contest_summer does not support migration down.\n";
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