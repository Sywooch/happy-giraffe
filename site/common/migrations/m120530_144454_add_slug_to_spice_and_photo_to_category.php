<?php

class m120530_144454_add_slug_to_spice_and_photo_to_category extends CDbMigration
{
    private $_table = 'cook__spices__categories';
	public function up()
	{
        $this->addColumn($this->_table, 'photo_id', 'int(11) UNSIGNED NULL');
        $this->addForeignKey('fk_'.$this->_table.'_photo', $this->_table, 'photo_id', 'album__photos', 'id','CASCADE',"CASCADE");

        $this->addColumn($this->_table, 'slug', 'varchar(255)');

        $this->_table = 'cook__spices';
        $this->addColumn($this->_table, 'slug', 'varchar(255)');
	}

	public function down()
	{
		echo "m120530_144454_add_slug_to_spice_and_photo_to_category does not support migration down.\n";
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