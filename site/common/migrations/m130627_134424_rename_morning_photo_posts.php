<?php

class m130627_134424_add_photo_posts extends CDbMigration
{
    private $_table = 'community__photo_posts';

	public function up()
	{
        $this->renameTable($this->_table, 'community__morning_posts');
	}

	public function down()
	{
		echo "m130627_134424_add_photo_posts does not support migration down.\n";
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