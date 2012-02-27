<?php

class m120224_075443_change_reports_table extends CDbMigration
{
	public function up()
	{
        $this->execute("TRUNCATE report");
        $this->execute("ALTER TABLE `report` ADD `breaker_id` INT( 10 ) UNSIGNED NOT NULL AFTER `author_id`");
        $this->execute("ALTER TABLE `report` ADD CONSTRAINT `fk_report_breaker` FOREIGN KEY (`breaker_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
	}

	public function down()
	{
		echo "m120224_075443_change_reports_table does not support migration down.\n";
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