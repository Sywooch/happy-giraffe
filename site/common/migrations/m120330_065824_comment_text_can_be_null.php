<?php

class m120330_065824_comment_text_can_be_null extends CDbMigration
{
	public function up()
	{
        $this->execute('ALTER TABLE  `comment` CHANGE  `text`  `text` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL;');
	}

	public function down()
	{
		echo "m120330_065824_comment_text_can_be_null does not support migration down.\n";
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