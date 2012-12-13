<?php

class m121213_123326_add_cook_tag_columns extends CDbMigration
{
    private $_table = 'cook__recipe_tags';

	public function up()
	{
        $this->addColumn($this->_table, 'description', 'text');
        $this->addColumn($this->_table, 'text_title', 'text');
        $this->addColumn($this->_table, 'text', 'text');
	}

	public function down()
	{
		echo "m121213_123326_add_cook_tag_columns does not support migration down.\n";
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