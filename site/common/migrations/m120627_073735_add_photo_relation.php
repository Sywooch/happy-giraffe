<?php

class m120627_073735_add_photo_relation extends CDbMigration
{
    private $_table = 'recipe_book__disease_categories';

	public function up()
	{
        $this->addForeignKey('fk_'.$this->_table.'_photo', $this->_table, 'photo_id', 'album__photos', 'id','CASCADE',"CASCADE");
        $this->_table = 'recipe_book__diseases';
        $this->addForeignKey('fk_'.$this->_table.'_photo', $this->_table, 'photo_id', 'album__photos', 'id','CASCADE',"CASCADE");
    }

	public function down()
	{
		echo "m120627_073735_add_photo_relation does not support migration down.\n";
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