<?php

class m170706_113357_change_price_for_doctor_chat extends CDbMigration
{
	public function up()
	{
		$this->execute("UPDATE `paid_services` SET `type` = 2, `price` = 399, `value` = 200");
	}

	public function down()
	{
		return true;
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