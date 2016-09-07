<?php

class m130801_113428_statuses extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `community__statuses` DROP FOREIGN KEY `community__statuses_ibfk_1`;");
        $this->execute("ALTER TABLE `community__statuses` DROP `status_id`;");
        $this->execute("ALTER TABLE `community__statuses` CHANGE `text` `text` VARCHAR(250)  CHARACTER SET utf8  COLLATE utf8_general_ci  NOT NULL  DEFAULT '';");
	}

	public function down()
	{
		echo "m130801_113428_statuses does not support migration down.\n";
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