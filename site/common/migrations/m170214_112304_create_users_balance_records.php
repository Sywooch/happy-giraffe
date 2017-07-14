<?php

class m170214_112304_create_users_balance_records extends CDbMigration
{
	public function up()
	{
		$this->createTable('users__balance_records', [
			'payment_id' => 'int(11) unsigned not null',
			'user_id' => 'int(11) unsigned not null',
			'paid_at' => 'int(10) unsigned default 0',
			'sum' => 'int(11) unsigned default 0',
			'service_id' => 'int(11) unsigned default 0'
		], 'ENGINE=InnoDB CHARSET=utf8');
	}

	public function down()
	{
		$this->dropTable('users__balance_records');
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