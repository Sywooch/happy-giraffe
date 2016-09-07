<?php

class m141021_084905_photoMigration extends CDbMigration
{
	public function up()
	{
        $this->execute("ALTER TABLE `album__photos` ADD `newPhotoId` INT(11)  UNSIGNED  NULL  DEFAULT NULL  AFTER `views`;");
	}

	public function down()
	{
		echo "m141021_084905_photoMigration does not support migration down.\n";
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