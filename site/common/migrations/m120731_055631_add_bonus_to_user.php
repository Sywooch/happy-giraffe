<?php

class m120731_055631_add_bonus_to_user extends CDbMigration
{
    private $_table = 'users';
	public function up()
	{
        $this->addColumn($this->_table, 'bonus', 'tinyint(1) not null default 0');
	}

	public function down()
	{
		echo "m120731_055631_add_bonus_to_user does not support migration down.\n";
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