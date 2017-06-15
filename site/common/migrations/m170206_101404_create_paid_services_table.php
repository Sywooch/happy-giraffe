<?php

class m170206_101404_create_paid_services_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('paid_services', [
			'id' => 'pk',
			'price' => 'int(11) unsigned not null',
			'name' => 'varchar(255) not null'
		], 'ENGINE=InnoDB CHARSET=utf8');
	}

	public function down()
	{
		$this->dropTable('paid_services');
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