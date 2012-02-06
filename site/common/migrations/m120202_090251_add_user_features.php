<?php

class m120202_090251_add_user_features extends CDbMigration
{
    private $_table = 'user';

    public function up()
	{
        $this->addColumn($this->_table, 'last_active', 'datetime');
        $this->addColumn($this->_table, 'online', 'tinyint(1) not null default 0');
	}

	public function down()
	{
        $this->dropColumn($this->_table,'last_active');
        $this->dropColumn($this->_table,'online');
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