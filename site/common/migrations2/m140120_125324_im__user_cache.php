<?php

class m140120_125324_im__user_cache extends CDbMigration
{
	public function up()
	{
		$this->execute('TRUNCATE TABLE `im__user_cache`;');
	}

	public function down()
	{
		echo "m140120_125324_im__user_cache does not support migration down.\n";
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