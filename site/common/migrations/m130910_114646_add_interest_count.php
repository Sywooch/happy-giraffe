<?php

class m130910_114646_add_interest_count extends CDbMigration
{
    private $_table = 'interest__interests';
	public function up()
	{
        $this->addColumn($this->_table, 'count', 'int not null default 0');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'count');
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