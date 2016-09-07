<?php

class m121213_092949_add_cuisine_country extends CDbMigration
{
    private $_table = 'cook__cuisines';
	public function up()
	{
        $this->addColumn($this->_table, 'country_id', 'int(11) UNSIGNED');

        $this->addForeignKey('fk_'.$this->_table.'_country', $this->_table, 'country_id', 'geo__country', 'id','CASCADE',"CASCADE");
	}

	public function down()
	{
		echo "m121213_092949_add_cuisine_country does not support migration down.\n";
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