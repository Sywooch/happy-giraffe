<?php

class m130904_105425_fix_some_clubs extends CDbMigration
{
    private $_table = 'community__forums';
	public function up()
	{
        $this->update($this->_table, array('club_id'=>21), 'id=19');
        $this->update($this->_table, array('club_id'=>22), 'id=20');
	}

	public function down()
	{
		echo "m130904_105425_fix_some_clubs does not support migration down.\n";
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