<?php

class m120312_080214_add_virtual_user extends CDbMigration
{
    private $_table = 'auth_item';
	public function up()
	{
        $this->insert($this->_table, array(
            'name'=>'virtual user',
            'type'=>'2',
            'description'=>'Виртуальный модератор',
        ));
	}

	public function down()
	{
		echo "m120312_080214_add_virtual_user does not support migration down.\n";
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