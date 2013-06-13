<?php

class m130613_070113_remove_useless extends CDbMigration
{
    private $_table = 'community__user_photos';

    public function up()
	{
        $this->execute('delete from community__contents where type_id=3; delete from community__content_types where id=3;');

        $this->dropTable($this->_table);

        $this->_table = 'community__travel_images';
        $this->dropTable($this->_table);

        $this->_table = 'community__travel_waypoints';
        $this->dropTable($this->_table);

        $this->_table = 'community__travels';
        $this->dropTable($this->_table);
    }

	public function down()
	{
		echo "m130613_070113_remove_useless does not support migration down.\n";
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