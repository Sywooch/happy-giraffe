<?php

class m130115_104243_fix_ukr_cities extends CDbMigration
{
	public function up()
	{
        $this->update('geo__region', array('name'=>'Ровненская область'), 'id=14');
	}

	public function down()
	{
		echo "m130115_104243_fix_ukr_cities does not support migration down.\n";
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