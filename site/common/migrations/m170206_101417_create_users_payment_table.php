<?php

class m170206_101417_create_users_payment_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('users_payment', [
			'user_id' => 'int(11) unsigned not null',
			'service_id' => 'int(11) unsigned not null',
			'paid_at' => 'int(10) unsigned not null',
			'price' => 'int(11) unsigned not null',
			'transaction_id' => 'varchar(255) not null'
		], 'ENGINE=InnoDB CHARSET=utf8');
	}

	public function down()
	{
		$this->dropTable('users_payment');
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