<?php

class m120914_124130_page_keyword_group_null extends CDbMigration
{
    private $_table = 'pages';

	public function up()
	{
        $this->alterColumn($this->_table, 'keyword_group_id', 'int(10) unsigned');
	}

	public function down()
	{

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