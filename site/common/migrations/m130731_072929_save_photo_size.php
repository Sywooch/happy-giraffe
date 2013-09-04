<?php

class m130731_072929_save_photo_size extends CDbMigration
{
    private $_table = 'album__photos';

	public function up()
	{
        $this->addColumn($this->_table, 'width', 'int(5) after title');
        $this->addColumn($this->_table, 'height', 'int(5) after width');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'width');
		$this->dropColumn($this->_table,'height');
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