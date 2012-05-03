<?php

class m120502_115058_update_test_prikorm extends CDbMigration
{
	public function up()
	{
        $this->update('test__results', array('number'=>1), 'id=5');
        $this->update('test__results', array('number'=>0), 'id=6');
	}

	public function down()
	{
		echo "m120502_115058_update_test_prikorm does not support migration down.\n";
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