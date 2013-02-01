<?php

class m130201_090337_add_route_cols extends CDbMigration
{
    private $_table = 'routes__routes';

	public function up()
	{
        $this->addColumn($this->_table, 'wordstat_value', 'int not null default 0');
        $this->addColumn($this->_table, 'distance', 'int');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'wordstat_value');
		$this->dropColumn($this->_table,'distance');
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