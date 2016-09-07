<?php

class m120627_082605_add_dizz_auth extends CDbMigration
{
    private $_table = 'auth__items';
	public function up()
	{
        $this->insert($this->_table, array(
            'name'=>'editRecipeBook',
            'type'=>0,
            'description'=>'Редактирование Детских болезней',
        ));
	}

	public function down()
	{
		echo "m120627_082605_add_dizz_auth does not support migration down.\n";
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