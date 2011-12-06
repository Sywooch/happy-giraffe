<?php

class m111206_101413_moder extends CDbMigration
{
	public function up()
	{
		$this->execute("UPDATE `user` SET `role`='moder';");
	}

	public function down()
	{
		echo "m111206_101413_moder does not support migration down.\n";
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