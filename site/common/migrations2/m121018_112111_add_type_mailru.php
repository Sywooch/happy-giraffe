<?php

class m121018_112111_add_type_mailru extends CDbMigration
{
    private $_table = 'mailru__queries';
	public function up()
	{
        $this->addColumn($this->_table, 'type', 'tinyint default 0 not null');
    }

	public function down()
	{
		echo "m121018_112111_add_type_mailru does not support migration down.\n";
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