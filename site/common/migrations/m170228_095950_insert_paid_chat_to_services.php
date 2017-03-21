<?php

class m170228_095950_insert_paid_chat_to_services extends CDbMigration
{
	public function up()
	{
		$this->execute("INSERT INTO `paid_services` (`price`, `name`, `type`, `value`) VALUES (200, 'Платный чат', 1, 150);");
	}

	public function down()
	{
		echo "m170228_095950_insert_paid_chat_to_services does not support migration down.\n";
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