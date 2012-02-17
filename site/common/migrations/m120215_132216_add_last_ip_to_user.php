<?php

class m120215_132216_add_last_ip_to_user extends CDbMigration
{
    private $_table = 'user';

	public function up()
	{
        $this->addColumn($this->_table, 'last_ip', 'varchar(20)');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'last_ip');
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