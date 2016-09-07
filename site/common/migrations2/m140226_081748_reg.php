<?php

class m140226_081748_reg extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `users` ADD `activation_code` CHAR(40)  NOT NULL  DEFAULT ''  AFTER `registration_finished`;");
        $this->execute("ALTER TABLE `users` ADD `status` TINYINT(1)  UNSIGNED  NOT NULL  AFTER `activation_code`;");
        $this->execute("UPDATE users SET status = 1;");
	}

	public function down()
	{
		echo "m140226_081748_reg does not support migration down.\n";
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