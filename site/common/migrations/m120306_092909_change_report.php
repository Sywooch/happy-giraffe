<?php

class m120306_092909_change_report extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `report` CHANGE `type` `type` TINYINT( 4 ) NOT NULL DEFAULT '0'");
	}

	public function down()
	{
		echo "m120306_092909_change_report does not support migration down.\n";
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