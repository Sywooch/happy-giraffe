<?php

class m120427_182525_add_test_type extends CDbMigration
{
    private $_table = 'test__tests';
	public function up()
	{
        $this->dropColumn($this->_table,'yes_no');
        $this->addColumn($this->_table, 'type', 'tinyint not null');
	}

	public function down()
	{
		echo "m120427_182525_add_test_type does not support migration down.\n";
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