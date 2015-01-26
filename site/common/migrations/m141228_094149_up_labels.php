<?php

class m141228_094149_up_labels extends CDbMigration
{
	public function up()
	{
        $this->execute('ALTER TABLE `post__labels` CHANGE COLUMN `text` `text` VARCHAR(350) NOT NULL;');
	}

	public function down()
	{
		echo "m141228_094149_up_labels does not support migration down.\n";
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