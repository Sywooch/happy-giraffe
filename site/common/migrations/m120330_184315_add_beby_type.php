<?php

class m120330_184315_add_beby_type extends CDbMigration
{
    private $_table = 'user_baby';
	public function up()
	{
        $this->addColumn($this->_table, 'type', 'tinyint(2)');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'type');
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