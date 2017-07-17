<?php

class m170714_100558_insert_test_kkt extends CDbMigration
{
	public function up()
	{
		$this->execute("INSERT INTO `atol_kkt` (`id`, `inn`, `address`, `callback_url`, `code`) VALUES (1, '112233445573', 'г. Москва, ул. Оранжевая, д.22 к.11', 'http://giraffe.code-geek.ru/v2_1/api/atol-callback/', 'ATOL-ProdTest-1');");
	}

	public function down()
	{
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