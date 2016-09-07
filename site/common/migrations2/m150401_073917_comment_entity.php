<?php

class m150401_073917_comment_entity extends CDbMigration
{
	public function up()
	{
        $this->execute('ALTER TABLE `comments` CHANGE COLUMN `entity` `entity` VARCHAR(200) NOT NULL;');
	}

	public function down()
	{
		echo "m150401_073917_comment_entity does not support migration down.\n";
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