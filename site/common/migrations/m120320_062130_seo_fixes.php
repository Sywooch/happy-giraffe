<?php

class m120320_062130_seo_fixes extends CDbMigration
{
    private $_table = 'seo__key_stats';
	public function up()
	{
        $this->addColumn($this->_table, 'year', 'int(1) not null default 2011');
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