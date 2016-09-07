<?php

class m141204_133147_albumSource extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `photo__albums` ADD `source` VARCHAR(255)  NOT NULL  DEFAULT 'myPhotos'  AFTER `removed`;");
	}

	public function down()
	{
		echo "m141204_133147_albumSource does not support migration down.\n";
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