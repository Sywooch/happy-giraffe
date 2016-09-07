<?php

class m130617_121636_search_scoring_fields extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `community__contents` ADD `views` INT(10)  UNSIGNED  NOT NULL  AFTER `rate`;");
	}

	public function down()
	{
		echo "m130617_121636_search_scoring_fields does not support migration down.\n";
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