<?php

class m130613_070113_remove_useless extends CDbMigration
{
    private $_table = 'community__user_photos';

    public function up()
	{
        $this->execute('delete from community__contents where type_id=3; delete from community__content_types where id=3;');

        $this->execute('DROP TABLE IF EXISTS community__user_photos;');
        $this->execute('DROP TABLE IF EXISTS community__travel_images;');
        $this->execute('DROP TABLE IF EXISTS community__travel_waypoints;');
        $this->execute('DROP TABLE IF EXISTS community__travels;');
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