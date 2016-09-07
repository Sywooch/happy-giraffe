<?php

class m120530_113834_change_spice_photo extends CDbMigration
{
    private $_table = 'cook__spices';

	public function up()
	{
        $this->dropColumn($this->_table,'photo');
        $this->addColumn($this->_table, 'photo_id', 'int(11) UNSIGNED NULL');

        $this->addForeignKey('fk_'.$this->_table.'_photo', $this->_table, 'photo_id', 'album__photos', 'id','CASCADE',"CASCADE");
	}

	public function down()
	{
		echo "m120530_113834_change_spice_photo does not support migration down.\n";
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