<?php

class m131113_092659_user_registration_source extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `users` ADD `registration_source` TINYINT(1)  NOT NULL  DEFAULT '0'  AFTER `main_photo_id`;");
        $this->execute("ALTER TABLE `users` ADD `registration_finished` TINYINT(1)  NOT NULL  DEFAULT '1'  AFTER `registration_source`;");
	}

	public function down()
	{
		echo "m131113_092659_user_registration_source does not support migration down.\n";
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