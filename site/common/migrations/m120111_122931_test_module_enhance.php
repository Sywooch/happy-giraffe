<?php

class m120111_122931_test_module_enhance extends CDbMigration
{
    private $_table = 'test';

	public function up()
	{
        $this->addColumn($this->_table, 'yes_no', 'tinyint(1) default 0');
	}

	public function down()
	{
        $this->dropColumn($this->_table,'yes_no');
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