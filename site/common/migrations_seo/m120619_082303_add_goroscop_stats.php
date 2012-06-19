<?php

class m120619_082303_add_goroscop_stats extends CDbMigration
{
	public function up()
	{
        $sql = file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR.'sites__keywords_visits2.sql');
        $this->execute($sql);
	}

	public function down()
	{
		echo "m120619_082303_add_goroscop_stats does not support migration down.\n";
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