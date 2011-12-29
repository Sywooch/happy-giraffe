<?php

class m111229_100250_change_user_id extends CDbMigration
{
    private $_table = 'user';

	public function up()
	{
        $this->alterColumn($this->_table, 'id', 'int unsigned not null auto_increment');
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