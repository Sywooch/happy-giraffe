<?php

class m120117_100556_add_famous_link extends CDbMigration
{
    private $_table = 'name_famous';
	public function up()
	{
        $this->addColumn($this->_table, 'link', 'varchar(1024)');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'link');
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