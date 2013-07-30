<?php

class m130730_062027_add_user_about extends CDbMigration
{
    private $_table = 'users';

	public function up()
	{
        $this->addColumn($this->_table, 'about', 'varchar(10000) after birthday');
	}

	public function down()
	{
		echo "m130730_062027_add_user_about does not support migration down.\n";
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