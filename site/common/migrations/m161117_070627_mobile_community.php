<?php

class m161117_070627_mobile_community extends CDbMigration
{
	public function up()
	{
		$this->execute("DROP TABLE mobile__communities;");
	}

	public function down()
	{
		echo "m161117_070627_mobile_community does not support migration down.\n";
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