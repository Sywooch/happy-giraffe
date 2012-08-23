<?php

class m120823_103139_add_old_to_indexing extends CDbMigration
{
    private $_table = 'indexing__urls';

	public function up()
	{
        $this->addColumn($this->_table, 'old', 'tinyint(1) not null default 0');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'old');
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