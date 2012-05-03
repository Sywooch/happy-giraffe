<?php

class m120502_055036_test_fx extends CDbMigration
{
	public function up()
	{
        $this->update('test__results', array('points'=>'2'), 'id=19');
	}

	public function down()
	{
		echo "m120502_055036_test_fx does not support migration down.\n";
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