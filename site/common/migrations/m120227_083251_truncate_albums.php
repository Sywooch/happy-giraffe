<?php

class m120227_083251_truncate_albums extends CDbMigration
{
	public function up()
	{
        $this->execute('TRUNCATE albums');
	}

	public function down()
	{
		echo "m120227_083251_truncate_albums does not support migration down.\n";
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