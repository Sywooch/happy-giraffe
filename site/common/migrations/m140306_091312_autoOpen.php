<?php

class m140306_091312_autoOpen extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `community__photo_posts` ADD `autoOpen` TINYINT(1)  UNSIGNED  NOT NULL  AFTER `photo_id`;");
	}

	public function down()
	{
		echo "m140306_091312_autoOpen does not support migration down.\n";
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