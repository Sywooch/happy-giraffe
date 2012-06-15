<?php

class m120614_112907_wordstat_parsing_enhance extends CDbMigration
{
    private $_table = 'parsing_keywords';

	public function up()
	{
        $this->addColumn($this->_table, 'depth', 'tinyint default NULL');
        $this->_table = 'keywords';
        $this->addColumn($this->_table, 'our', 'tinyint(1)');
	}

	public function down()
	{
		echo "m120614_112907_wordstat_parsing_enhance does not support migration down.\n";
		return false;
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