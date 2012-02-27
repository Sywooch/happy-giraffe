<?php

class m120222_190106_change_report_table extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `report` CHANGE `type` `type` TINYINT NOT NULL ");
        $this->execute("ALTER TABLE `report` CHANGE `informer_id` `author_id` INT( 10 ) UNSIGNED NULL DEFAULT NULL  ");
        $this->execute("ALTER TABLE `report` ADD `path` VARCHAR( 255 ) NOT NULL AFTER `object_id` ");
        $this->execute("ALTER TABLE `report` ADD `updated` TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , ADD `created` TIMESTAMP NOT NULL ");
	}

	public function down()
	{
		echo "m120222_190106_change_report_table does not support migration down.\n";
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