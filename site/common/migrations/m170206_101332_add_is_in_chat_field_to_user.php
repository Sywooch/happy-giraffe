<?php

class m170206_101332_add_is_in_chat_field_to_user extends CDbMigration
{
	public function up()
	{
		$this->addColumn('users', 'is_in_chat', 'tinyint(1) default 0');
	}

	public function down()
	{
		$this->dropColumn('users', 'is_in_chat');
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