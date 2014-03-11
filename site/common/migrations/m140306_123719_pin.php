<?php

class m140306_123719_pin extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `community__contents` ADD `pinned` TINYINT(1)  UNSIGNED  NOT NULL  AFTER `privacy`;");
        $this->execute("UPDATE community__contents
SET pinned = 1, created = real_time WHERE real_time IS NOT NULL;");
        $this->execute("ALTER TABLE `community__contents` DROP `real_time`;");
	}

	public function down()
	{
		echo "m140306_123719_pin does not support migration down.\n";
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