<?php

class m120814_101938_add_updated_to_users extends CDbMigration
{
    private $_table = 'users';

	public function up()
	{
        $this->addColumn($this->_table, 'updated', 'timestamp null');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'updated');
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