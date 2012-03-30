<?php

class m120330_163512_add_partner_birthday extends CDbMigration
{
    private $_table = 'user_partner';

	public function up()
	{
        $this->addColumn($this->_table, 'birthday', 'date after name');
	}

	public function down()
	{
		echo "m120330_163512_add_partner_birthday does not support migration down.\n";
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