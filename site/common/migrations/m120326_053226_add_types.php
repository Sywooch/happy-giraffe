<?php

class m120326_053226_add_types extends CDbMigration
{
    private $_table = 'geo__region';

	public function up()
	{
        $this->addColumn($this->_table, 'type', 'varchar(20)');
        $this->addColumn($this->_table, 'center_id', 'int unsigned');
        $this->_table = 'geo__city';
        $this->addColumn($this->_table, 'type', 'varchar(20)');

        $this->_table = 'auth_item_child';
        $this->insert($this->_table, array('parent'=>'isAuthor', 'child'=>'removeAlbumPhoto'));
	}

	public function down()
	{
		echo "m120326_053226_add_types does not support migration down.\n";
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