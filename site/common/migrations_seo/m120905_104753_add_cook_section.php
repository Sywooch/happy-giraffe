<?php

class m120905_104753_add_cook_section extends CDbMigration
{
    private $_table = 'task';

	public function up()
	{
        $this->addColumn($this->_table, 'section', 'tinyint not null default 1 after type');
        $this->addColumn($this->_table, 'multivarka', 'tinyint after section');
        $this->alterColumn($this->_table, 'keyword_group_id', 'int(10) UNSIGNED NULL');
        $this->_table = 'rewrite_urls';
        $this->renameTable($this->_table, 'task_urls');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'section');
		$this->dropColumn($this->_table,'multivarka');
        $this->renameTable('task_urls', 'rewrite_urls');
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