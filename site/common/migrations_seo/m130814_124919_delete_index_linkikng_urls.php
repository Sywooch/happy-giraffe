<?php

class m130814_124919_delete_index_linkikng_urls extends CDbMigration
{
    private $_table = 'inner_linking__urls';
	public function up()
	{
        $this->dropTable($this->_table);
	}

	public function down()
	{
		echo "m130814_124919_delete_index_linkikng_urls does not support migration down.\n";
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