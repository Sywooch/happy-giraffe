<?php

class m120409_122953_add_profile_check extends CDbMigration
{
    private $_table = 'user';

	public function up()
	{
        $this->addColumn($this->_table, 'profile_check', 'int');
	}

	public function down()
	{
		echo "m120409_122953_add_profile_check does not support migration down.\n";
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