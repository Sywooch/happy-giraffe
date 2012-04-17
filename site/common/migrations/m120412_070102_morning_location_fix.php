<?php

class m120412_070102_morning_location_fix extends CDbMigration
{
    private $_table = 'club_community_photo_post';

	public function up()
	{
        $this->dropColumn($this->_table,'location_url');

        $this->addColumn($this->_table, 'lat', 'varchar(255)');
        $this->addColumn($this->_table, 'long', 'varchar(255)');
        $this->addColumn($this->_table, 'zoom', 'varchar(5)');
	}

	public function down()
	{
		echo "m120412_070102_morning_location_fix does not support migration down.\n";
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