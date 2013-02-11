<?php

class m130211_114658_cities_declination extends CDbMigration
{
    private $_table = 'geo__city';
	public function up()
	{
        $this->addColumn($this->_table, 'name_from', 'varchar(255)');
        $this->addColumn($this->_table, 'name_between', 'varchar(255)');
	}

	public function down()
	{
		echo "m130211_114658_cities_declination does not support migration down.\n";
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