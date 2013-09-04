<?php

class m130826_081631_add_photo_hide extends CDbMigration
{
    private $_table = 'album__photos';
	public function up()
	{
        $this->addColumn($this->_table, 'hidden', 'tinyint(1) default 0 NOT NULL');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'hidden');
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