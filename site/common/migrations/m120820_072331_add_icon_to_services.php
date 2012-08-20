<?php

class m120820_072331_add_icon_to_services extends CDbMigration
{
    private $_table = 'services';

	public function up()
	{
        $this->addColumn($this->_table, 'photo_id', 'int(11) UNSIGNED NULL');

        $this->addForeignKey('fk_'.$this->_table.'_photo', $this->_table, 'photo_id', 'album__photos', 'id','CASCADE',"CASCADE");
	}

	public function down()
	{
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