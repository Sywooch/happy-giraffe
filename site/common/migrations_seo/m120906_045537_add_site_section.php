<?php

class m120906_045537_add_site_section extends CDbMigration
{
    private $_table = 'sites__sites';

	public function up()
	{
        $this->addColumn($this->_table, 'section', 'tinyint not null default 1');
	}

	public function down()
	{
		echo "m120906_045537_add_site_section does not support migration down.\n";
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