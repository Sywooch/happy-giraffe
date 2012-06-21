<?php

class m120621_032948_user_unrecovery extends CDbMigration
{
    private $_table = 'users';
	public function up()
	{
        $this->addColumn($this->_table, 'recovery_disable', 'tinyint(1) unsigned not null default 0');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'recovery_disable');
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