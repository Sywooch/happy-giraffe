<?php

class m120625_124126_add_user_groups extends CDbMigration
{
    private $_table = 'users';
    public function up()
	{
        $this->addColumn($this->_table, 'group', 'tinyint default 0');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'group');
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