<?php

class m170714_112649_add_id_to_users_payment extends CDbMigration
{
	public function up()
	{
		$this->addColumn('users_payment', 'id', 'pk');
	}

	public function down()
	{
		$this->dropColumn('users_payment', 'id');
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