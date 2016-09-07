<?php

class m121214_080526_add_created_cookbook extends CDbMigration
{
    private $_table = 'cook__cook_book';
	public function up()
	{
        $this->addColumn($this->_table, 'created', 'timestamp NOT NULL default now()');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'created');
	}
}