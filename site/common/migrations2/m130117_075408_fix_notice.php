<?php

class m130117_075408_fix_notice extends CDbMigration
{
    private $_table = 'user__users_babies';

	public function up()
	{
        $this->alterColumn($this->_table, 'name', 'varchar(50)');
        $this->alterColumn($this->_table, 'notice', 'varchar(100)');
        $this->_table = 'user__users_partners';
        $this->alterColumn($this->_table, 'name', 'varchar(50)');
        $this->alterColumn($this->_table, 'notice', 'varchar(100)');
	}

	public function down()
	{

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