<?php

class m131120_060611_community_contest_2 extends CDbMigration
{
	public function up()
	{
	    $this->execute("ALTER TABLE `community__contests` ADD `cssClass` VARCHAR(32)  NOT NULL  DEFAULT ''  AFTER `status`;");
        $this->execute("ALTER TABLE `community__contests` ADD `textHint` TEXT  NOT NULL  AFTER `cssClass`;");
    }

	public function down()
	{
		echo "m131120_060611_community_contest_2 does not support migration down.\n";
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