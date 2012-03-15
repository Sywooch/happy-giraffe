<?php

class m120315_082642_change_create_time_recipeBook extends CDbMigration
{
    private $_table = 'recipeBook_recipe';
	public function up()
	{
        $this->alterColumn($this->_table, 'create_time', 'timestamp not null default 0');
	}

	public function down()
	{

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