<?php

class m120614_071820_add_spice_ablative_title extends CDbMigration
{
    private $_table = 'cook__spices';
	public function up()
	{
        $this->addColumn($this->_table, 'title_ablative', 'varchar(255) after title');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'title_ablative');
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