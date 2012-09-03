<?php

class m120829_101637_add_created_to_friend extends CDbMigration
{
    private $_table = 'friends';

	public function up()
	{
        $this->addColumn($this->_table, 'created', 'timestamp null');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'created');
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