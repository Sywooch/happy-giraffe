<?php

class m120327_082713_add_weather_id_to_city extends CDbMigration
{
    private $_table = 'geo__city';

	public function up()
	{
        $this->addColumn($this->_table, 'weather_id', 'varchar(20)');
	}

	public function down()
	{
		$this->dropColumn($this->_table,'weather_id');
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