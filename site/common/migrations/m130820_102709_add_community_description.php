<?php

class m130820_102709_add_community_description extends CDbMigration
{
    private $_table = 'community__communities';

	public function up()
	{
        $this->addColumn($this->_table, 'description', 'varchar(1000) after short_title');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'description');
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