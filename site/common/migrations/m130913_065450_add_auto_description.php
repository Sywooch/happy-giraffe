<?php

class m130913_065450_add_auto_description extends CDbMigration
{
    private $_table = 'community__contents';
	public function up()
	{
        $this->addColumn($this->_table, 'meta_description_auto', 'varchar(255) after meta_description');
	}

	public function down()
	{
		echo "m130913_065450_add_auto_description does not support migration down.\n";
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