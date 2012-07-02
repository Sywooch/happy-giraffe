<?php

class m120630_081032_add_parsing_priority extends CDbMigration
{
    private $_table = 'parsing_keywords';
	public function up()
	{
        $this->addColumn($this->_table, 'priority', 'tinyint UNSIGNED not null default 0');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'priority');
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