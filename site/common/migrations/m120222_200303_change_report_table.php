<?php

class m120222_200303_change_report_table extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `report` ADD `accepted` BOOLEAN NOT NULL DEFAULT '0' AFTER `path` ");
	}

	public function down()
	{
		echo "m120222_200303_change_report_table does not support migration down.\n";
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