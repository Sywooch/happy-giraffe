<?php

class m130620_071636_add_index_rate extends CDbMigration
{
    private $_table = 'community__contents';
	public function up()
	{
        $this->alterColumn($this->_table, 'rate', 'int(10) UNSIGNED default 0 not null');
        $this->createIndex('rate', $this->_table, 'rate');
	}

	public function down()
	{
		echo "m130620_071636_add_index_rate does not support migration down.\n";
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