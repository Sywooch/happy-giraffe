<?php

class m120715_060121_add_linking_auth extends CDbMigration
{
    private $_table = 'auth__items';
	public function up()
	{
        $this->insert($this->_table, array(
            'name'=>'promotion',
            'type'=>2,
            'description'=>'Перелинковка',
        ));
	}

	public function down()
	{
		echo "m120715_060121_add_linking_auth does not support migration down.\n";
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