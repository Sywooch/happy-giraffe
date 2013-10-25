<?php

class m130911_075200_add_video_field_to_post extends CDbMigration
{
    private $_table = 'community__posts';
	public function up()
	{
        $this->addColumn($this->_table, 'video', 'varchar(255)');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'video');
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