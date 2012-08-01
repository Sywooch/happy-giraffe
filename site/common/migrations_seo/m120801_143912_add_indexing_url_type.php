<?php

class m120801_143912_add_indexing_url_type extends CDbMigration
{
    private $_table = 'indexing__urls';
	public function up()
	{
        $this->addColumn($this->_table, 'type', 'tinyint NOT NULL default 0');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'type');
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