<?php

class m130628_042724_add_show_region_to_routes extends CDbMigration
{
    private $_table = 'geo__city';
	public function up()
	{
        $this->addColumn($this->_table, 'show_region', 'tinyint(2) default 0 not null');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'show_region');
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