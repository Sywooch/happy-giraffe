<?php

class m120615_150840_add_description_to_cook_choose extends CDbMigration
{
    private $_table = 'cook__choose__categories';

	public function up()
	{
        $this->addColumn($this->_table, 'description_center', 'text after description');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'description_center');
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