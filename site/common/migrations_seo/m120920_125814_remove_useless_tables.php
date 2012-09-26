<?php

class m120920_125814_remove_useless_tables extends CDbMigration
{
    private $_table = 'pastuhov_yandex_popularity';

	public function up()
	{
        $this->dropTable($this->_table);
        $this->_table = 'rambler_popularity';
        $this->dropTable($this->_table);
	}

	public function down()
	{
		echo "m120920_125814_remove_useless_tables does not support migration down.\n";
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